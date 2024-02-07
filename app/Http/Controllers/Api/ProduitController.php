<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            "products"=> Product::all()
        ]);
    }

    public function findOne($id): JsonResponse
    {
        $produit = Product::where('id', $id)->first();

        if($produit===null){
            return response()->json([
                "errors"=>' Product with the given id does not exists'
            ]);
        }
        return response()->json([
            "products"=>  $produit
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code'=> 'required|numeric|min:3',
            'description'=> 'required|min:10',
            'unit_price'=> 'required|numeric|min:1',
        ]);

        if ($validator->fails()){
            return response()->json([
                "errors"=> $validator->messages(),
                "status"=> 400
            ],400);
        }

        return response()->json([
             "products"=> Product::create($request->all())
        ]);
    }

    public function update(Request $request,  $id)
    {
        //Chercher d'abord si le produit avec cet id existe
        $products = Product::all();
        $product = $products->find($id);


        $isValid = $this->validateProduct($request);
        if($product=== null || !$isValid['isValid'] )
        {
            return response()->json([
                'errors'=> $isValid['errors'],
                'productNotFound'=> $product===null ? 'Product not found' : false,
            ]);
        }

        //Updated
        $product->update($request->all());

        return response()->json([
            'product_updated'=>  $products->find($id)
        ]);

    }

    public function delete($id)
    {
        //Find
        $product = Product::find($id);

        if($product=== null)
        {
            return response()->json([
                'errors'=> 'product not found'
            ]);
        }

        Product::where('id', $id)->delete();

        //Supprime tous les enregistrement associé au models
        //Product::truncate();

        return response()->json([
            "product"=> "Delete product success"
        ]);

    }

    public function validateProduct($request): array
    {
        $validator = Validator::make($request->all(),[
            'code'=> 'required|numeric|min:3',
            'description'=> 'required|min:10',
            'unit_price'=> 'required|numeric|min:1',
        ]);

        if ($validator->fails()){

            return [
                'isValid'=> false,
                'errors'=> $validator->messages()
            ];
        }
        return  [
            'isValid'=> true,
            'errors'=> null
        ];

    }


}
