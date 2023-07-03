<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SectionController extends Controller
{

    public function listing(Request $request)
    {
        $url = Route::getFacadeRoot()->current()->uri(); // we get the section in here

        $section = Section::where(['status' => 1, 'name' => $url])->first();

        $section_id = $section['id'];

        $categoryCount = Category::where(['section_id' => $section_id, 'status' => 1])->count();

        $data = $request->all();

        if (!session()->has('pagination') && empty(session('pagination')) || (!empty($data['value']))) {
            $pagination = !empty($data['value']) ? $data['value'] : 8;
            session()->put('pagination', $pagination);
        }

        if (!session()->has('value_2') && empty(session('value_2')) || (!empty($data['value_2']))) {
            $value_2 = !empty($data['value_2']) ? $data['value_2'] : "null";
            session()->put('value_2', $value_2);
        }

        $pagination = session('pagination');
        $value_2 = session('value_2');


        if ($categoryCount > 0) {
            $categoryDetails = Category::categoryDetailsSection($section_id);

            $sorting = !empty($data['value_2']) ? $data['value_2'] : null;

            if ($sorting == "en_satan") {
                $categoryProducts = Product::whereIn('category_id', $categoryDetails['catIds'])
                    ->where('status', 1)
                    ->where('is_bestseller', 'Yes')
                    ->paginate($pagination)
                    ->appends(['value_2' => $sorting]);
            } elseif ($sorting == "en_son") {
                $categoryProducts = Product::whereIn('category_id', $categoryDetails['catIds'])
                    ->where('status', 1)
                    ->orderByDesc('id')
                    ->paginate($pagination)
                    ->appends(['value_2' => $sorting]);
            } elseif ($sorting == "en_dusuk_ucret") {
                $categoryProducts = Product::whereIn('category_id', $categoryDetails['catIds'])
                    ->where('status', 1)
                    ->orderByRaw("CASE WHEN product_discount > 0 THEN product_price - (product_price * (product_discount / 100)) ELSE product_price END ASC")
                    ->paginate($pagination)
                    ->appends(['value_2' => $sorting]);
            } elseif ($sorting == "en_yuksek_ucret") {
                $categoryProducts = Product::whereIn('category_id', $categoryDetails['catIds'])
                    ->where('status', 1)
                    ->orderByRaw("CASE WHEN product_discount > 0 THEN product_price - (product_price * (product_discount / 100)) ELSE product_price END DESC")
                    ->paginate($pagination)
                    ->appends(['value_2' => $sorting]);
            } else {
                $categoryProducts = Product::whereIn('category_id', $categoryDetails['catIds'])
                    ->where('status', 1)
                    ->paginate($pagination)
                    ->appends(['value_2' => $sorting]);
            }

            // $productArrays will contain an array of arrays, each array representing a row from the database

            // If you want to include additional pagination information, you can access it from $categoryProducts

            $paginationInfo = [
                'total' => $categoryProducts->total(),
                'per_page' => $categoryProducts->perPage(),
                'current_page' => $categoryProducts->currentPage(),
                'last_page' => $categoryProducts->lastPage(),
                'pagination' => $pagination
                // ... other pagination properties you may need
            ];

            /*
            dd($categoryProducts); die;
            */

            $section_name = $section['name'];

            return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'paginationInfo', 'url', 'section_name'))->with(session()->all());
        } else {
            abort(404);
        }
    }

}
