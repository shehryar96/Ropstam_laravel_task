<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Product;

class SearchController extends Controller
{
    //

    public function Search(Request $request){
       
        try {
            
       
          $product = Product::where('title', 'like', "%{$request->search_text}%")->get();
         
            if ($product) {

                $serverResponse = new JsonResponse('Success', 1, 'Result found', 1, $product);
            
            } else {
                
                $serverResponse = new JsonResponse('Success', 1, 'Result not found', 0);
            }

            return response()->json($serverResponse, 200);


        }catch (\Exception $exception) {
            $serverResponse = new JsonResponse('Error', 2, 'Internal Server Error! . Something Went Wrong', 0);
            return response()->json($serverResponse, 200);
        }

    }
}
