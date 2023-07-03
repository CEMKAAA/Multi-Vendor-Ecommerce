<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Session;
use Image;

class BannersController extends Controller
{
    
    public function banners()
    {
        Session::put('page', 'banners');
        $banners = Banner::get()->toArray();
        /*dd($banners); die;*/
        return view('admin.banners.banners')->with(compact('banners'));

    }

    public function updateBannerStatus(Request $request)
    {

        if ($request->ajax())
        {

            $data = $request->all();

            if ($data['status'] == "Active")
            {
                $status = 0;
            }
            else
            {
                $status = 1;
            }

            Banner::where('id', $data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'banner_id'=>$data['banner_id']]);

        }

    }

    public function deleteBanner($id)
    {

        //Get banner Image from the id

        $bannerImage = Banner::where('id',$id)->first();

        //Get banner image path

        $banner_image_path = 'front/images/banner_images/';

        //Delete banner image if not exists in Folder

        if (file_exists($banner_image_path.$bannerImage->image))
        {
            unlink($banner_image_path.$bannerImage->image);
        }

        //delete banners image from banners table

        Banner::where('id',$id)->delete();
        $message = "Banner deleted successfully";
        return redirect('admin/banners')->with('success_message', $message);
    }

    public function addEditBanner(Request $request, $id=null)
    {
        Session::put('page', 'banners');
        if (empty($id))
        {
            //Add banner
            $banner = new Banner;
            $title = "Add banner image";
            $message = "banner added successfully";
        }
        else
        {
            $banner = Banner::find($id);
            $title = "Edit banner image";
            $message = "banner updated successfully";
        }

        if ($request->isMethod('post'))
        {
            $data = $request->all();

            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
            $banner->status = 1;
            $banner->type = $data['type'];

            if ($data['type'] == "Slider") 
            {

                $width = "1920";
                $height = "720";

            }
            else if ($data['type'] == "Fix")
            {

                $width = "1920";
                $height = "450";

            }

            // Upload Banner Image
            if ($request->hasFile('image')) 
            {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front/images/banner_images/' . $imageName;
                    // Upload the Image
                    Image::make($image_tmp)->resize($width,$height)->save($imagePath);
                    $banner->image = $imageName;
                }
            }

            $banner->save();
            return redirect('admin/banners')->with('success_message', $message);
        }

        return view('admin.banners.add-edit-banner')->with(compact('title', 'banner'));

    }

}
