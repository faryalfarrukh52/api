<?php

// namespace App\Http\Controllers;

// use App\Model\Product;
// use Illuminate\Http\Request;
// use App\Http\Resources\Product\ProductResource;
// use App\Http\Resources\Product\ProductCollection;

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     //  return product::all();
       //return new ProductCollection(Product::all());
       //return ProductCollection::collection(Product::all());
      // return $data->toArray($data);
        
      return ProductCollection::collection(Product::paginate(20));  
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
       // return $request->all();
         $product = new Product;
         $product->name = $request->name;
         $product->detail = $request->description;
         $product->price = $request->price;
         $product->stock = $request->stock;
         $product->discount = $request->discount;

         $product->save();

         return response([
            'data' => new ProductResource($product)

         ], Response::HTTP_CREATED);
      //  return 'hello';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //return $product;
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
      //  return $request->all();
      $request['detail'] = $request->description;
      unset($request['description']);
      return $product->update($request->all());

      
      return response([
        'data' => new ProductResource($product)

     ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
       // return $product;
       $product->delete();

       return response(null,Response::HTTP_NO_CONTENT);
    }
}
