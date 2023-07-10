<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Sluggable;
    protected $fillable = [
        'name',
        'category_id',
        'content',
        'slug',
        'image',
        'short_text',
        'price',
        'status',
        'size',
        'color',
        'qty',
    ];

    public function category()
    {
       return $this->hasOne(Category::class, 'id','category_id');
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
