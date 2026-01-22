<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class SitemapController extends Controller
{
    /**
     * Generate sitemap.xml
     */
    public function index()
    {
        $urls = collect();

        // Static pages
        $urls->push([
            'loc' => url('/'),
            'lastmod' => Carbon::now()->toW3cString(),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ]);

        $urls->push([
            'loc' => route('products.index'),
            'lastmod' => Product::max('updated_at')?->toW3cString() ?? Carbon::now()->toW3cString(),
            'changefreq' => 'daily',
            'priority' => '0.9',
        ]);

        // Static pages
        $staticPages = [
            ['route' => 'about', 'priority' => '0.5'],
            ['route' => 'contact', 'priority' => '0.5'],
            ['route' => 'terms', 'priority' => '0.3'],
            ['route' => 'privacy', 'priority' => '0.3'],
        ];

        foreach ($staticPages as $page) {
            if (Route::has($page['route'])) {
                $urls->push([
                    'loc' => route($page['route']),
                    'lastmod' => Carbon::now()->toW3cString(),
                    'changefreq' => 'monthly',
                    'priority' => $page['priority'],
                ]);
            }
        }

        // Categories
        $categories = Category::where('is_active', true)->get();
        foreach ($categories as $category) {
            $urls->push([
                'loc' => route('products.index', ['category' => $category->slug ?? $category->id]),
                'lastmod' => $category->updated_at?->toW3cString() ?? Carbon::now()->toW3cString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ]);
        }

        // Products
        $products = Product::where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($products as $product) {
            $urls->push([
                'loc' => route('products.show', $product),
                'lastmod' => $product->updated_at->toW3cString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ]);
        }

        $content = view('sitemap.index', ['urls' => $urls])->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate robots.txt dynamically (optional, can use static file)
     */
    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /cart\n";
        $content .= "Disallow: /checkout\n";
        $content .= "Disallow: /profile/\n";
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /register\n";
        $content .= "\n";
        $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}
