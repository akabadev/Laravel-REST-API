<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CentralWikiController extends Controller
{
    /**
     * @param string|null $slug
     * @return View
     */
    public function __invoke(?string $slug = "index"): View
    {
        $payloads = $this->payloads();
        $default = data_get($payloads, "default");
        $pages = data_get($payloads, "pages");
        $slugs = data_get($pages, '*.slug');

        $slug = Str::of($slug)->lower()->slug()->__toString();
        $slug = in_array($slug, $slugs) ? $slug : $default['slug'];

        if (!file_exists(resource_path("wiki/pages/$slug.md"))) {
            $slug = $default['slug'];
        }

        $content = Str::markdown(file_get_contents(resource_path("wiki/pages/$slug.md")));

        $title = "🔥 Wiki";

        return view('wiki.index', compact("content", "pages", "slug", "title"));
    }

    private function payloads(): array
    {
        return json_decode(
            file_get_contents(resource_path('wiki/payload.json')),
            true
        );
    }
}
