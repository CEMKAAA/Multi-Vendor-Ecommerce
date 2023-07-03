<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsImage extends Model
{
    use HasFactory;

    public static function getProductImages($id)
    {
        $product_images = ProductsImage::where(['status' => 1, 'product_id' => $id])->orderByDesc('id')->get()->toArray();

        if (!empty($product_images) && is_array($product_images)) {
            return $product_images;
        } else {
            return null;
        }
    }

}
