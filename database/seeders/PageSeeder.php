<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->viewsData()->map(function (array $view) {
            $view['code'] = strtoupper(Str::slug($view['code'] ?? Page::freshCode()));
            return Page::create($view);
        });
    }

    /**
     * @return Collection
     */
    private function viewsData(): Collection
    {
        return collect(json_decode(File::get(base_path('data/pages.json')), true))
            ->flatMap(function (array $page) {
                $result = [];

                foreach ($page['items'] ?? [] as $item) {
                    $result[] = $item;
                }

                return count($result) ? $result : [Arr::except($page, 'items')];
            });
    }
}
