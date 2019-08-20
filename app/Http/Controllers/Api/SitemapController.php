<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Spatie\Sitemap\Sitemap;
use Illuminate\Support\Facades\Cache;
use App\Category;
use App\Ad;

class SitemapController extends Controller
{

    private $sitemapPath;

    public function __construct()
    {
        $this->sitemapPath = public_path('sitemap.xml');
    }

    public function create()
    {
        $sitemap = Sitemap::create();

        //Static Routes
        $sitemap->add(route('welcome'));
        $sitemap->add(route('add'));
        $sitemap->add(route('contact'));
        $sitemap->add(route('blog_index'));

        //SomeTime Stores here ....

        //Global Cached Categories Data Cache one week
        $categories = Cache::remember('cached_categories', 60 * 24 * 7, function () {
            return Category::with('description')->get();
        });

        //Iterate Over cateogories
        $parent_categories = [];
        $category_formatted = [];
        foreach ($categories as $cat) {
            if (is_null($cat->parent_id)) {
                $parent_categories[] = $cat;
                $sitemap->add(route('super_category_index', ['category' => $cat->description->slug]));
            } else {
                $category_formatted[$cat->parent_id][] = $cat->description;
                $sitemap->add(route('category_index', ['category' => $cat->parent->description->slug, 'subcategory' => $cat->description->slug]));
            }
        }

        //News
        $latest_blog_post = Cache::remember('latest_blog_post_10', 60 * 12, function () {
            return Post::latest()->limit(10)->get();
        });
        foreach ($latest_blog_post as $blog_post) {
            $sitemap->add(route('blog_post', ['entry_slug' => $blog_post->slug]));
        }

        //Latest Ads (How Many?? 1000??)
        $ads = Cache::remember('cached_1000_ads', 30, function () {
            return Ad::with(['description', 'category', 'resources'])->limit(1000)->latest()->get();
        });
        foreach ($ads as $ad) {
            $sitemap->add(ad_url($ad));
        }

        $sitemap->writeToFile($this->sitemapPath);
    }
}
