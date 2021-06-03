<?php

namespace App\Http\Controllers\Api;

use App\api\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Category;

class CategoryController extends Controller
{
    public function getCategories(Request $request) {

        $categories = Category::all();
        try {
          
                if ($categories) {

                    $serverResponse = new JsonResponse('Success', 1, 'Category found', 1, $categories);
                
                } else {
                    
                    $serverResponse = new JsonResponse('Success', 1, 'Category not found', 0);
                }

                return response()->json($serverResponse, 200);

        }catch (\Exception $exception) {
            $serverResponse = new JsonResponse('Error', 2, 'Internal Server Error! . Something Went Wrong', 0);
            return response()->json($serverResponse, 200);
        }

    }

    public function store(Request $request)
    {
        try {
            $input['name'] = $request->name;
           
            $input['is_active'] = $request->is_active;

            $input['thumbnail'] = $request->file('thumbnail');

            //return $request->file('thumbnail');

            if ($request->hasFile('thumbnail')) {
                $image = $request->file('thumbnail');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
    
                $img = Image::make($image->getRealPath());
                $img->resize(120, 120, function ($constraint) {
                    $constraint->aspectRatio();                 
                });
    
                $img->stream();

                Storage::disk('local')->put('images/category'.'/'.$fileName, $img, 'public');
             }

            $input['thumbnail'] = $fileName;
            $category = Category::create($input);

            if ($category) {
                $serverResponse = new JsonResponse('Success', 1, 'Category created', 1, $category);
            } else {
                $serverResponse = new JsonResponse('Success', 1, 'Category not created', 0);
            }
             
            return response()->json($serverResponse, 200);
            

        } catch (\Exception $exception) {
            $serverResponse = new JsonResponse('Error', 2, 'Internal Server Error! . Something Went Wrong', 0);
            return response()->json($serverResponse, 200);
        }
    }

    public function Delete($id)
    {
       
        try {
          $category = Category::find($id);

          if($category){
                $category = Category::destroy($id);

                $serverResponse = new JsonResponse('Success', 1, 'Category Deteted', 1, $category);
            } 
            else {
                $serverResponse = new JsonResponse('Success', 1, 'Category not found', 0);
            }

            return response()->json($serverResponse, 200);

        } catch (\Exception $exception) {
            $serverResponse = new JsonResponse('Error', 2, 'Internal Server Error! . Something Went Wrong', 0);
            return response()->json($serverResponse, 200);
        }
    }


  
   

}
