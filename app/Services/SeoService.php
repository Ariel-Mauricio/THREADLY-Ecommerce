<?php

namespace App\Services;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class SeoService
{
    protected $title;
    protected $description;
    protected $keywords;
    protected $image;
    protected $url;
    protected $type = 'website';
    protected $siteName;
    protected $locale = 'es_EC';
    protected $twitterCard = 'summary_large_image';
    protected $canonical;
    protected $robots = 'index, follow';
    protected $schema = [];

    public function __construct()
    {
        $this->siteName = config('app.name', 'THREADLY');
        $this->url = url()->current();
    }

    public function setTitle(string $title, bool $appendSiteName = true): self
    {
        $this->title = $appendSiteName 
            ? $title . ' | ' . $this->siteName 
            : $title;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = Str::limit(strip_tags($description), 160);
        return $this;
    }

    public function setKeywords(array|string $keywords): self
    {
        $this->keywords = is_array($keywords) ? implode(', ', $keywords) : $keywords;
        return $this;
    }

    public function setImage(string $image): self
    {
        $this->image = Str::startsWith($image, 'http') ? $image : asset($image);
        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function setCanonical(string $url): self
    {
        $this->canonical = $url;
        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function setRobots(string $robots): self
    {
        $this->robots = $robots;
        return $this;
    }

    public function noIndex(): self
    {
        $this->robots = 'noindex, nofollow';
        return $this;
    }

    /**
     * Set product schema for structured data
     */
    public function setProductSchema(array $product): self
    {
        $this->schema = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product['name'],
            'description' => $product['description'] ?? '',
            'image' => $product['image'] ?? '',
            'sku' => $product['sku'] ?? '',
            'brand' => [
                '@type' => 'Brand',
                'name' => $product['brand'] ?? $this->siteName,
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => $this->url,
                'priceCurrency' => 'USD',
                'price' => $product['price'],
                'availability' => ($product['stock'] ?? 0) > 0 
                    ? 'https://schema.org/InStock' 
                    : 'https://schema.org/OutOfStock',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => $this->siteName,
                ],
            ],
        ];

        // Add aggregateRating if reviews exist
        if (isset($product['rating']) && isset($product['review_count']) && $product['review_count'] > 0) {
            $this->schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $product['rating'],
                'reviewCount' => $product['review_count'],
            ];
        }

        return $this;
    }

    /**
     * Set organization schema
     */
    public function setOrganizationSchema(): self
    {
        $this->schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $this->siteName,
            'url' => url('/'),
            'logo' => asset('images/logo.png'),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => config('app.phone', ''),
                'contactType' => 'customer service',
                'availableLanguage' => 'Spanish',
            ],
            'sameAs' => array_filter([
                config('app.social.facebook'),
                config('app.social.instagram'),
                config('app.social.twitter'),
            ]),
        ];

        return $this;
    }

    /**
     * Set breadcrumb schema
     */
    public function setBreadcrumbSchema(array $items): self
    {
        $breadcrumbs = [];
        foreach ($items as $position => $item) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => $position + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
        }

        $this->schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbs,
        ];

        return $this;
    }

    /**
     * Generate all meta tags
     */
    public function generate(): string
    {
        $html = '';

        // Basic meta tags
        if ($this->title) {
            $html .= '<title>' . e($this->title) . '</title>' . PHP_EOL;
        }

        if ($this->description) {
            $html .= '<meta name="description" content="' . e($this->description) . '">' . PHP_EOL;
        }

        if ($this->keywords) {
            $html .= '<meta name="keywords" content="' . e($this->keywords) . '">' . PHP_EOL;
        }

        $html .= '<meta name="robots" content="' . $this->robots . '">' . PHP_EOL;

        // Canonical URL
        $canonical = $this->canonical ?? $this->url;
        $html .= '<link rel="canonical" href="' . $canonical . '">' . PHP_EOL;

        // Open Graph
        $html .= PHP_EOL . '<!-- Open Graph / Facebook -->' . PHP_EOL;
        $html .= '<meta property="og:type" content="' . $this->type . '">' . PHP_EOL;
        $html .= '<meta property="og:url" content="' . $this->url . '">' . PHP_EOL;
        
        if ($this->title) {
            $html .= '<meta property="og:title" content="' . e($this->title) . '">' . PHP_EOL;
        }
        
        if ($this->description) {
            $html .= '<meta property="og:description" content="' . e($this->description) . '">' . PHP_EOL;
        }
        
        if ($this->image) {
            $html .= '<meta property="og:image" content="' . $this->image . '">' . PHP_EOL;
        }
        
        $html .= '<meta property="og:site_name" content="' . e($this->siteName) . '">' . PHP_EOL;
        $html .= '<meta property="og:locale" content="' . $this->locale . '">' . PHP_EOL;

        // Twitter Card
        $html .= PHP_EOL . '<!-- Twitter -->' . PHP_EOL;
        $html .= '<meta name="twitter:card" content="' . $this->twitterCard . '">' . PHP_EOL;
        $html .= '<meta name="twitter:url" content="' . $this->url . '">' . PHP_EOL;
        
        if ($this->title) {
            $html .= '<meta name="twitter:title" content="' . e($this->title) . '">' . PHP_EOL;
        }
        
        if ($this->description) {
            $html .= '<meta name="twitter:description" content="' . e($this->description) . '">' . PHP_EOL;
        }
        
        if ($this->image) {
            $html .= '<meta name="twitter:image" content="' . $this->image . '">' . PHP_EOL;
        }

        // JSON-LD Schema
        if (!empty($this->schema)) {
            $html .= PHP_EOL . '<!-- Structured Data -->' . PHP_EOL;
            $html .= '<script type="application/ld+json">' . PHP_EOL;
            $html .= json_encode($this->schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            $html .= PHP_EOL . '</script>' . PHP_EOL;
        }

        return $html;
    }

    /**
     * Share the SEO data with all views
     */
    public function share(): void
    {
        View::share('seoMeta', $this->generate());
    }

    /**
     * Static helper for quick setup
     */
    public static function make(): self
    {
        return new self();
    }
}
