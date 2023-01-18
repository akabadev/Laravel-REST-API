<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Profile;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sequence = 1;
        $this->createMenuItems($this->viewsData(), null, $sequence);
    }

    /**
     * @return Collection
     */
    private function viewsData(): Collection
    {
        return collect(json_decode(File::get(base_path('data/menus.json')), true));
    }

    /**
     * @param array $menu
     * @param Profile $profile
     * @param Page $view
     * @param Menu|null $parent
     * @param int $sequence
     * @return Menu
     */
    private function createMenu(array $menu, Profile $profile, Page $view, ?Menu $parent = null, int $sequence = 1): Menu
    {
        return Menu::create([
            'name' => $menu['label'] ?? '',
            'title' => $menu['label'] ?? '',
            'profile_id' => $profile->id,
            'page_id' => $view->id,
            'parent_id' => optional($parent)->id,
            'sequence' => $sequence,
            'active' => true,
            'payload' => $menu['payload']
        ]);
    }

    private function createMenuItems(Collection $menus, Menu $parent = null, int &$sequence = 1)
    {
        $menus->each(function (array $menu) use (&$sequence, &$parent) {
            $code = strtoupper(Str::slug($menu['page_code']));
            $view = Page::firstOrCreate(
                ['code' => $code],
                ['name' => $menu['label'], 'description' => $menu['label']]
            );

            Profile::query()->whereIn('code', $menu['profile_codes'] ?? [])
                ->get('id')->each(function (Profile $profile) use (&$parent, &$view, &$sequence, $menu) {
                    $sequence++;
                    $childParent = $this->createMenu($menu, $profile, $view, $parent, $sequence);
                    $this->createMenuItems(collect($menu['items'] ?? []), $childParent, $sequence);
                });
        });
    }
}
