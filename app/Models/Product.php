<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function section(){
        return $this->belongsTo('App\Models\Section','section_id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }

    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public function images(){
        return $this->hasMany('App\Models\ProductsImage');
    }

    public static function getDiscountPrice($product_id){
        $proDetails = Product::select('product_price', 'product_discount', 'category_id')->where('id', $product_id)->first();
        $proDetails = json_decode(json_encode($proDetails),true); //this is toArray function but safer not a fancy thing :)
        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails), true); 

        if($proDetails['product_discount']>0){
            $discounted_price = $proDetails['product_price'] - (($proDetails['product_price']*$proDetails['product_discount'])/100);
            return $discounted_price;
        }else if($catDetails['category_discount']>0){
            $discounted_price = $proDetails['product_price'] - (($proDetails['product_price'] * $catDetails['category_discount']) / 100);
            return $discounted_price;
        }else {
            $discounted_price = 0;
        }
    }

    public static function getParentCount($id)
    {

        $parentId = $id; // The ID of the parent category

        $products = Product::whereHas('category', function ($categoryQuery) use ($parentId) {
            $categoryQuery->where(function ($query) use ($parentId) {
                $query->where('id', $parentId)
                    ->orWhere('parent_id', $parentId);
            });
        })->get()->toArray();

        $product_count = count($products);

        return $product_count;
        
    }

    public static function getProductBySection($id)
    {

        $products = Product::where('section_id', $id)->where('status', 1)->orderByDesc('id')->get()->toArray();

        if (!empty($products) && is_array($products)) :

            return $products;

        endif;

    }

    public static function breadCrumb($id)
    {
        $product = Product::where(['id' => $id, 'status' => 1])->first();
        $section_id = empty($product) ? null : $product['section_id'];
        $section = Section::select('name')->where(['id' => $section_id, 'status' => 1])->first();
        $category_id = $product['category_id'];

        $category = Category::where(['status' => 1, 'id' => $category_id])->where('parent_id', '!=', 0)->first();

        if (!empty($category)) :
            $parent_id = $category['parent_id'];

            $real_parent = Category::where(['id' => $parent_id, 'status' => 1])->first();
        endif;

        if (empty($category)) :

            $real_parent = Category::where(['status' => 1, 'id' => $category_id])->where('parent_id', '==', 0)->first();

        endif;  

        $breads = array();
        $names = array('section_name','parent_name','category_name');

        $section_name = empty($section) ? null : $section['name'];
        $breads[] = $section_name;
        $parent_name = empty($real_parent) ? null : $real_parent['url'];
        $breads[] = $parent_name;
        $category_name = empty($category) ? null : $category['url'];
        $breads[] = $category_name;
        
        $breadCrumbs = [];
        $count = 0;

        foreach ($breads as $bread) :

            $name = $names[$count];
            $breadCrumbs[$name] = $bread;
            $count++;

        endforeach;

        return $breadCrumbs;
    }

    public static function inStock($id)
    {

        $stock = Product::select('stock')->where(['status' => 1,  'id' => $id])->first();

        return $stock['stock'];

    }

}
