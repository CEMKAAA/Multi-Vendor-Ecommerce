<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Session;

class ProductsController extends Controller
{
    
    public function listing(Request $request)
    {
        $url = Route::getFacadeRoot()->current()->uri(); // we get the url on the other hands
        
        $categoryCount = Category::where(['url' => $url,'status' => 1])->count();

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
    

        if ($categoryCount>0)
        {
            $categoryDetails = Category::categoryDetails($url);

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

            return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'paginationInfo', 'url'))->with(session()->all());
        }
        else
        {
            abort(404);
        }
    }

    public function show($id)
    {
        $product_real = Product::find($id);

        if (!empty($product_real)) {
            return view('front.layout.quick-view')->with(compact('product_real'));
        }

        // Handle case when product is not found
        abort(404);
    }

}
