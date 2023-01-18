<?php

namespace App\Console\Commands;

use App\Models\TenantTemplate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MakeTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-template {name : An unique template name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new tenant template model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            ['name' => $name] = $this->arguments();
        } catch (ValidationException $exception) {
            $this->error("An error occurred");
            $this->table(['Errors'], $exception->errors(), 'symfony-style-guide');
            return self::FAILURE;
        }

        TenantTemplate::create(compact('name'));
        $this->info("Tenant Template <$name> created in Database");

        $basic = storage_path('templates' . DIRECTORY_SEPARATOR . 'basic');
        $current = storage_path('templates' . DIRECTORY_SEPARATOR . $name);

        $result = File::copyDirectory($basic, $current);

        if ($result) {
            $this->info("Files generated successfully in <$current>");
        } else {
            $this->error("Files generation failed: <$current>");
        }

        return $result ? self::SUCCESS : self::FAILURE;
    }

    /**
     * @throws ValidationException
     */
    public function arguments(): array
    {
        $this->input->setArgument("name", Str::lower($this->argument('name') ?: ''));
        return Validator::make(
            parent::arguments(),
            ['name' => 'required|regex:/^[a-zA-Z]+$/u|max:100|unique:tenant_templates,name']
        )->validate();
    }
}
