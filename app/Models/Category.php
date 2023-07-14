<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'image',
        'thumbnail',
        'cat_ust',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->hasMany(Category::class, 'cat_ust', 'id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id','cat_ust');
    }

    public function getTotalProductCount()
    {
        $total = $this->items()->count();

        foreach ($this->subcategory as $sub_category) {
            $total += $sub_category->items()->count();
        }

        return $total;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
