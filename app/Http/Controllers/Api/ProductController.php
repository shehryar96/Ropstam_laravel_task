<?php

namespace App\Http\Controllers\Api;

use App\api\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Product;


class ProductController extends Controller
{
    //

    public function getSingleproduct($id){
       
        try {
            
            $product = Product::find($id); 

            if($product)
            {
                $serverResponse = new JsonResponse('Success', 1, 'Product found', 1, $product);

            }
            else{

                $serverResponse = new JsonResponse('Success', 1, 'Product not found', 0);
            }

            return response()->json($serverResponse, 200);


        }catch (\Exception $exception) {
            $serverResponse = new JsonResponse('Error', 2, 'Internal Server Error! . Something Went Wrong', 0);
            return response()->json($serverResponse, 200);
        }


    }



    public function getProducts(Request $request) {

        try {
            $Product = Product::all();
                if ($Product) {
                    $serverResponse = new JsonResponse('Success', 1, 'Product found', 1, $Product);
                } else {
                    $serverResponse = new JsonResponse('Success', 1, 'Product not found', 0);
                }

                return response()->json($serverResponse, 200);

        }catch (\Exception $exception) {
            $serverResponse = new JsonResponse('Error', 2, 'Internal Server Error! . Something Went Wrong', 0);
            return response()->json($serverResponse, 200);
        }

    }


    public function store(Request $request){

        $input['title'] = $request['title'];
        $input['description'] = $request['description'];
        $input['is_avaliable'] = $request['is_avaliable'];
        $input['price'] = $request['price'];
        $input['trending'] = $request['trending'];
        $category_id = $request['category_id'];

        $image_names = array();
       
        try {
              
            if($request->hasfile('images'))
            {
                
                foreach($request->file('images') as $image)
                { 
                    $image = $image;
                    $fileName = time() . '.' . $image->getClientOriginalExtension();
        
                    $img = Image::make($image->getRealPath());
                    $img->resize(120, 120, function ($constraint) {
                        $constraint->aspectRatio();                 
                    });
        
                    $img->stream();
        
                    Storage::disk('local')->put('images/product'.'/'.$fileName, $img, 'public');
        
            
                    array_push($image_names,$fileName);
                }       

            }
  
            $input['images'] = json_encode($image_names);

            $categories_explode = explode(",",$category_id);

            $product = Product::create($input);

            $product->categories()->attach($categories_explode);
 
            if ($product) {

                $serverResponse = new JsonResponse('Success', 1, 'product created', 1, $product);
           
            } else {

                $serverResponse = new JsonResponse('Success', 1, 'product not created', 0);
           
            }

            return response()->json($serverResponse, 200);
 
          } catch (\Exception $exception) {
              $serverResponse = new JsonResponse('Error', 2, 'Internal Server Error! . Something Went Wrong', 0);
              return response()->json($serverResponse, 200);
          }

    }


    public function getTrendingproduct(){

        try {
           
            $trending_products = Product::where('trending','1')->orderBy('id','desc')->get();

            if ($trending_products) {

                $serverResponse = new JsonResponse('Success', 1, ' Trending Found', 1, $trending_products);
           
            } else {

                $serverResponse = new JsonResponse('Success', 1, 'Trending not found', 0);
            }

            return response()->json($serverResponse, 200);
  
        }
        catch (\Exception $exception) {
            $serverResponse = new JsonResponse('Error', 2, 'Internal Server Error! . Something Went Wrong', 0);
            return response()->json($serverResponse, 200);
        }
    }
}
