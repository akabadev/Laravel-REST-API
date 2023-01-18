<?php

namespace App\Jobs;

use App\Models\Tenant;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class CreateTenantFilesStructure implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $stubs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private ?\Stancl\Tenancy\Contracts\Tenant $tenant)
    {
        $this->stubs = [
            '{{ name }}' => $this->tenantName()
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
        $template = object_get($this->tenant, 'template.name', 'basic');
        $template = File::directories(template_path($template))[0];

        $destination = tenants_path() . DIRECTORY_SEPARATOR . $this->tenantName();

        throw_unless(
            File::copyDirectory($template, $destination),
            new FileExistsException('Directory copy failed'),
        );

        $this->renameDirectories($destination);

        $this->renameFiles($destination);

        $from = Storage::path('cache' . DIRECTORY_SEPARATOR . $this->tenant->id . DIRECTORY_SEPARATOR . $this->tenant->logo);
        $to = $destination . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $this->tenant->logo;

        try {
            File::move($from, $to);
        } catch (Exception) {
        }
    }

    /**
     * @return string
     */
    private function tenantName(): string
    {
        return Str::ucfirst(Str::camel($this->tenant->id));
    }

    private function renameDirectories(string $destination)
    {
        collect(File::directories($destination))
            ->each(function ($directory) {
                if (Str::contains($directory, array_keys($this->stubs))) {
                    $renameTo = str_replace(
                        array_keys($this->stubs),
                        array_values($this->stubs),
                        $directory
                    );

                    File::moveDirectory($directory, $renameTo);

                    $directory = $renameTo;
                }

                if (is_dir($directory)) {
                    $this->renameDirectories($directory);
                }
            });
    }

    private function renameFiles(string $baseDirectory)
    {
        collect(File::allFiles($baseDirectory))
            ->map(fn ($file) => $file->getRealPath())
            ->filter(fn ($file) => Str::contains($file, array_keys($this->stubs)) || Str::endsWith($file, ".stub"))
            ->each(function ($file) {
                $renameTo = str_replace(
                    array_keys($this->stubs),
                    array_values($this->stubs),
                    $file
                );

                $this->feedContent($file);

                $renameTo = Str::replaceLast(".stub", "", $renameTo);

                File::move($file, $renameTo);
            });
    }

    /**
     * @param string $file
     * @return bool|int
     */
    private function feedContent(string $file): bool|int
    {
        $data = file_get_contents($file);

        $data = str_replace(
            array_keys($this->stubs),
            array_values($this->stubs),
            $data
        );

        return File::put($file, $data);
    }
}
