<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function section(){
        return $this->belongsTo('App\Models\Section','section_id')->select('id','name'); //bu modelin id si eğer section modelinin satırlarından birinin section id sine eşit ise o zaman bu category modeline ait database satırı o section id nin satırına aittir
    }

    public function parentcategory(){
        return $this->belongsTo('App\Models\Category','parent_id')->select('id','category_name');
    }

    public function subcategories(){
        return $this->hasMany('App\Models\Category','parent_id')->where('status',1); // ilk yerdeki belong to nun tam tersi bu modeldeki parent_id id si bu modeldeki id leri ile aynı olan database satırlarında parent_id si normal id ye eşit olanlarla aynıdır
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function categoryDetails($url)
    {
        $categoryDetails = Category::select('id', 'category_name', 'url', 'section_id')->with('subcategories')->where('url',$url)->first()->toArray();

        $catIds = array();
        $catIds[] = $categoryDetails['id'];

        foreach($categoryDetails['subcategories'] as $key => $subcat)
        {
            $catIds[] = $subcat['id'];
        }
        
        $resp = array('catIds' => $catIds, 'categoryDetails' => $categoryDetails);
        return $resp;
    }

    public static function categoryDetailsSection($sectionId)
    {

        $categoryDetails = Category::select('id', 'category_name', 'url', 'section_id')->with('subcategories')->where('section_id', $sectionId)->where('status', 1)->first()->toArray();

        $catIds = array();
        $catIds[] = $categoryDetails['id'];

        foreach ($categoryDetails['subcategories'] as $key => $subcat) {
            $catIds[] = $subcat['id'];
        }

        $resp = array('catIds' => $catIds, 'categoryDetails' => $categoryDetails);
        return $resp;

    }

    public static function getCategory($id)
    {

        $category = Category::where(['id' => $id, 'status' => 1])->get()->first();
        $parent_id = $category['parent_id'];

        $parent_category = Category::where('id', $parent_id)->where('status', 1)->get()->first();

        if (!empty($parent_category)) :

            $resp = array("category" => $category, "parent_category" => $parent_category);
            return $resp;

        else :

            $resp = $category;

        endif;

    }

    public static function getParentCategories()
    {

        $parentCategories = Category::where(['parent_id' => 0, 'status' => 1])->inRandomOrder()->get()->toArray();

        if (!empty($parentCategories)) :

            return $parentCategories;

        endif;

    }

    public static function getChildCategories($id)
    {

        $childCategories = Category::where('parent_id', $id)->where('status', 1)->orderByDesc('id')->get()->toArray();

        return $childCategories;

    }

    public static function getChildCount($id)
    {

        $products = Product::where(['status' => 1, 'category_id' => $id])->orderByDesc('id')->get()->toArray();
        $count = count($products);

        return $count;

    }

    
}
