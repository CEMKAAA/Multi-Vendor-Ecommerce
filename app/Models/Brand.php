<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Brand extends Model
{
    use HasFactory;

    public static function getBrands()
    {

        $brands = Brand::where('status', 1)->orderByDesc('id')->get()->toArray();

        if (!empty($brands) && is_array($brands)) :
            return $brands;
        endif;

    }

    public static function getProductCount($id)
    {

        $products = Product::where(['status' => 1, 'brand_id' => $id])->orderByDesc('id')->get()->toArray();
        $product_counts = count($products);

        return $product_counts;

    }
}
