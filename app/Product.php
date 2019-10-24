<?php

namespace App;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model implements Searchable
{
    use HasSlug;
    use SearchableTrait;
    
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            'products.sku' => 10,
        ],
        // 'joins' => [
        //     'categories' => ['products.id','categories.product_id'],
        //     'preacher' => ['products.id','preachers.product_id'],
        // ],
    ];

    protected $casts = [
        'is_taxable' => 'boolean',
        'is_fulfilled' => 'boolean',
        'is_available' => 'boolean',
        'is_discountable' => 'boolean',
        'is_active' => 'boolean',
        'is_digital' => 'boolean',
        'is_audio' => 'boolean',
    ];


    public function getSearchResult(): SearchResult
    {
       $url = route('products.show', $this->id);
         
       return new SearchResult($this, $this->name, $url);
    }

    /**
     * The categories that belong to the product.
     */
    public function preacher()
    {
        return $this->belongsTo('App\Preacher');
    }

    /**
     * The categories that belong to the product.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_product');
    }
}
