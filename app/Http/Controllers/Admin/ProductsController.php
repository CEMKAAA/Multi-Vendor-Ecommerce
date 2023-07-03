<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsImage;
use Session;
use Auth;
use Image;

class ProductsController extends Controller
{
    public function products(){
        Session::put('page','products');
        $products = Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }])->get()->toArray();
        /*dd($products);*/
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }

    public function deleteProduct($id){
        // Delete Product
        Product::where('id',$id)->delete();
        $message = "Product has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditProduct(Request $request, $id=null){
        Session::put('page','products');
        if($id==""){
            $title = "Add Product";
            $product = new Product;
            $message = "Product added successfully!";
        }else{
            $title = "Edit Product";
            $product = Product::find($id);
            /*echo "<pre>"; print_r($product); die;*/
            $message = "Product updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-\d]+$/u',
                'product_code' => 'required|regex:/^\w+$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
            ];

            $customMessages = [
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'Valid Product Code is required',
                'product_price.required' => 'Product Price is required',
                'product_price.numeric' => 'Valid Product Price is required',
                'product_color.required' => 'Product Color is required',
                'product_color.regex' => 'Valid Product Color is required',
            ];

            $this->validate($request,$rules,$customMessages);

            $row = Product::latest()->first();
            $latest_id = $row->id;
            $next_id = empty($id) ? ($latest_id + 1) : $id;

            if ($request->hasFile('product_image')) {
                $images = $request->file('product_image');

                $count = 0;

                /*dd($images); die;*/

                foreach ($images as $image) {
                    if ($image->isValid()) {
                        // Get Image Extension
                        $extension = $image->getClientOriginalExtension();
                        // Generate New Image Name
                        $imageName = rand(111, 99999) . '.' . $extension;

                        $directory = public_path('front' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product_images' . DIRECTORY_SEPARATOR . $next_id);
                        $large = public_path('front' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product_images' . DIRECTORY_SEPARATOR . $next_id. DIRECTORY_SEPARATOR .'large');
                        $medium = public_path('front' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product_images' . DIRECTORY_SEPARATOR . $next_id. DIRECTORY_SEPARATOR .'medium');
                        $small = public_path('front' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product_images' . DIRECTORY_SEPARATOR . $next_id. DIRECTORY_SEPARATOR .'small');

                        // Create the directory if it doesn't exist
                        if (!is_dir($directory)) {
                            mkdir($directory, 0755, true);
                            mkdir($large, 0755, true);
                            mkdir($medium, 0755, true);
                            mkdir($small, 0755, true);
                        }

                        $largeImagePath = $directory . DIRECTORY_SEPARATOR . 'large' . DIRECTORY_SEPARATOR . $imageName;
                        $mediumImagePath = $directory . DIRECTORY_SEPARATOR . 'medium' . DIRECTORY_SEPARATOR . $imageName;
                        $smallImagePath = $directory . DIRECTORY_SEPARATOR . 'small' . DIRECTORY_SEPARATOR . $imageName;

                        // Upload the Large, Medium, and Small Images after Resize
                        Image::make($image)->resize(1000, 1000)->save($largeImagePath);
                        Image::make($image)->resize(500, 500)->save($mediumImagePath);
                        Image::make($image)->resize(250, 250)->save($smallImagePath);

                        $product_image = new ProductsImage();
                        $product_image->product_id = $next_id;
                        $product_image->image = $imageName;
                        $product_image->status = 1;
                        $product_image->save();

                        if ($count == 0)
                        {

                            $directory = public_path('front' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product_images');
                            $large = public_path('front' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product_images' . DIRECTORY_SEPARATOR .'large');
                            $medium = public_path('front' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product_images' . DIRECTORY_SEPARATOR .  'medium');
                            $small = public_path('front' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product_images' . DIRECTORY_SEPARATOR .  'small');

                            // Create the directory if it doesn't exist
                            if (!is_dir($directory)) 
                            {
                                mkdir($directory, 0755, true);
                                mkdir($large, 0755, true);
                                mkdir($medium, 0755, true);
                                mkdir($small, 0755, true);
                            }

                            $largeImagePath = $directory . DIRECTORY_SEPARATOR . 'large' . DIRECTORY_SEPARATOR . $imageName;
                            $mediumImagePath = $directory . DIRECTORY_SEPARATOR . 'medium' . DIRECTORY_SEPARATOR . $imageName;
                            $smallImagePath = $directory . DIRECTORY_SEPARATOR . 'small' . DIRECTORY_SEPARATOR . $imageName;

                            // Upload the Large, Medium, and Small Images after Resize

                            if ($request->hasFile('product_image_main')) :

                                $image = $request->file('product_image_main');
                                Image::make($image)->resize(1000, 1000)->save($largeImagePath);
                                Image::make($image)->resize(500, 500)->save($mediumImagePath);
                                Image::make($image)->resize(250, 250)->save($smallImagePath);

                            endif;

                            $product->product_image = $imageName;

                        }

                        $count++;

                    }
                }

                // Insert Image Names in products table
            }


            // Upload Product Video
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                    // Upload Video in videos folder
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(111,99999).'.'.$extension;
                    $videoPath = 'front/videos/product_videos';
                    $video_tmp->move($videoPath,$videoName);
                    // Insert Video name in products table
                    $product->product_video = $videoName;
                }
            }
            //save image


            // Save Product details in products table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;

            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;
            if($adminType=="vendor"){
                $product->vendor_id = $vendor_id;
            }else{
                $product->vendor_id = 0;    
            }

            if (empty($data['product_discount'])) 
            {

               $data['product_discount'] = 0; 

            }

            if (empty($data['product_weight'])) 
            {

                $data['product_weight'] = 0;

            }

            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->stock = $data['stock'];
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            if (!empty($data['is_bestseller'])) {
                $product->is_bestseller = $data['is_bestseller'];
            } else {
                $product->is_bestseller = "No";
            }

            if (!empty($data['in_stock'])) {
                $product->in_stock = $data['in_stock'];
            } else {
                $product->in_stock = "No";
            }

            $product->status = 1;
            $product->save();
            
            return redirect('admin/products')->with('success_message',$message);
        }

        // Get Sections with Categories and Sub Categories
        $categories = Section::with('categories')->get()->toArray();
        /*dd($categories);*/

        // Get All Brands
        $brands = Brand::where('status',1)->get()->toArray();

        //get all images 
        $images_real = !empty($id) ? ProductsImage::where(['product_id' => $id, 'status' => 1])->orderByDesc('id')->get()->toArray() : null;

        return view('admin.products.add_edit_product')->with(compact('title','categories','brands','product','images_real'));
    }

    public function deleteProductImage($id){
        // Get product image
        $productImage = Product::select('product_image')->where('id',$id)->first();

        // Get Product Image Paths
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';
    
        // Delete Product small image if exists in small folder
        if(file_exists($small_image_path.$productImage->product_image)){
            unlink($small_image_path.$productImage->product_image);
        }

        // Delete Product medium image if exists in medium folder
        if(file_exists($medium_image_path.$productImage->product_image)){
            unlink($medium_image_path.$productImage->product_image);
        }

        // Delete Product large image if exists in large folder
        if(file_exists($large_image_path.$productImage->product_image)){
            unlink($large_image_path.$productImage->product_image);
        }

        // Delete Product image from products table
        Product::where('id',$id)->update(['product_image'=>'']);

        $message = "Product Image has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);

    }

    

    public function deleteProductGallery($image_name)
    {

        $productImage = ProductsImage::where('image', $image_name)->get()->first();
        $product_id = $productImage->product_id;

        $large = public_path('front' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product_images' . DIRECTORY_SEPARATOR . $product_id . DIRECTORY_SEPARATOR . 'large' . DIRECTORY_SEPARATOR);
        $medium = public_path('front' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product_images' . DIRECTORY_SEPARATOR . $product_id . DIRECTORY_SEPARATOR . 'medium' . DIRECTORY_SEPARATOR);
        $small = public_path('front' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product_images' . DIRECTORY_SEPARATOR . $product_id . DIRECTORY_SEPARATOR . 'small' . DIRECTORY_SEPARATOR);

        // Delete Product small image if exists in small folder
        if (file_exists($small . $image_name)) {
            unlink($small . $image_name);
        }

        // Delete Product medium image if exists in medium folder
        if (file_exists($medium . $image_name)) {
            unlink($medium . $image_name);
        }

        // Delete Product large image if exists in large folder
        if (file_exists($large . $image_name)) {
            unlink($large . $image_name);
        }

        ProductsImage::where(['product_id' => $product_id, 'image' => $image_name])->delete();

        $message = "Görsel başarıyla silindi!";
        return redirect()->back()->with('success_message', $message);

    }

    public function deleteProductVideo($id)
    {

        // Get Product Video
        $productVideo = Product::select('product_video')->where('id',$id)->first();

        // Get Product Video Path
        $product_video_path = 'front/videos/product_videos/';

        // Delete Product Video from product_videos folder if exists
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }

        // Delete Product Video Image from products table
        Product::where('id',$id)->update(['product_video'=>'']);

        $message = "Product Video has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);

    }

    public function addAttributes(Request $request, $id)
    {
        Session::put('page','products');
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);
        /*$product = json_decode(json_encode($product),true);
        dd($product);*/
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            foreach ($data['sku'] as $key => $value) {
                if(!empty($value)){

                    // SKU duplicate check
                    $skuCount = ProductsAttribute::where('sku',$value)->count();
                    if($skuCount>0){
                        return redirect()->back()->with('error_message','SKU already exists! Please add another SKU!');    
                    }

                    // Size duplicate check
                    $sizeCount = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if($sizeCount>0){
                        return redirect()->back()->with('error_message','Size already exists! Please add another Size!');    
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }

            return redirect()->back()->with('success_message','Product Attributes has been added successfully!');
        }

        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
    }

    public function updateAttributeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function editAttributes(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            foreach ($data['attributeId'] as $key => $attribute) {
                if(!empty($attribute)){
                    ProductsAttribute::where(['id'=>$data['attributeId'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
                }
            }
            return redirect()->back()->with('success_message','Product Attributes has been updated successfully!');
        }
    }

    public function addImages($id, Request $request){
        Session::put('page','products');
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('images')->find($id); 

        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('images')){
                $images = $request->file('images');
                /*echo "<pre>"; print_r($images); die;*/
                foreach ($images as $key => $image) {
                    // Generate Temp Image
                    $image_tmp = Image::make($image);
                    // Get Image Name
                    $image_name = $image->getClientOriginalName();
                    // Get Image Extension
                    $extension = $image->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = $image_name.rand(111,99999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    // Upload the Large, Medium and Small Images after Resize
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);
                    // Insert Image Name in products table
                    $image = new ProductsImage; 
                    $image->image = $imageName;
                    $image->product_id = $id;
                    $image->status = 1;
                    $image->save();
                }
            }
            return redirect()->back()->with('success_message','Product Images has been added successfully!');
        }

        return view('admin.images.add_images')->with(compact('product'));
    }

    public function updateImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsImage::where('id',$data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
        }
    }

    public function deleteImage($id){
        // Get product image
        $productImage = ProductsImage::select('image')->where('id',$id)->first();

        // Get Product Image Paths
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';
    
        // Delete Product small image if exists in small folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        // Delete Product medium image if exists in medium folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        // Delete Product large image if exists in large folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        // Delete Product image from products_images table
        ProductsImage::where('id',$id)->delete();

        $message = "Product Image has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);

    }
}
