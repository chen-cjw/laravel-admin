<?php

namespace App\Transformers;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    public function transform(Products $products)
    {
        //    protected $fillable = ['title','description','image','on_sale','sold_count','price','stock','sort'];
        return [
            'id'=>$products->id,
            'title'=>$products->title,
            'description'=>$products->description,
            'image'=>$products->image,
            'on_sale'=>$products->on_sale,
            'sold_count'=>$products->sold_count,
            'price'=>$products->price,
            'stock'=>$products->stock,
            'sort'=>$products->sort,
        ];
    }
}
