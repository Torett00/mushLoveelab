<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\catRequest;
use App\Models\Variation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class VariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $catss = Variation::all();
        return response()->json($catss);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(catRequest $request)
    {
       
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imageName = Str::random(32) . "." . $request->file('image')->getClientOriginalExtension();
        
                Variation::create([
                    'name' => $request->name,
                    'image' => $imageName,
                    'price'=>$request->price,
                    'stock'=>$request->stock,
                    'product_id'=>$request->product_id,
                    'description' => $request->description
                ]);
        
                Storage::disk('public')->put($imageName, file_get_contents($request->file('image')));
        
                return response()->json(['message' => 'Variation successfully created!'], 200);
            } else {
                return response()->json(['message' => 'No valid file uploaded!'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
        
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Variation::find($id);
        if(!$product){
          return response()->json([
             'message'=>'variation Not Found.'
          ],404);
        }
       
        // Return Json Response
        return response()->json([
           'product' => $product
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(catRequest $request, $id)
    {
        try {
            // Find product
            $product = Variation::find($id);
            if(!$product){
              return response()->json([
                'message'=>'variation Not Found.'
              ],404);
            }
          
            
            //echo "request : $request->image";
            $product->name = $request->name;
            $product->description = $request->description;
      
            if($request->hasFile('image')) {
 
                // Public storage
                $storage = Storage::disk('public');
      
                // Old iamge delete
                if($storage->exists($product->image)){
                    $storage->delete($product->image);}
      
                // Image name
                $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
                $product->image = $imageName;
      
                // Image save in public folder
                $storage->put($imageName, file_get_contents($request->image));
            }
      
            // Update Product
            $product->save();
      
            // Return Json Response
            return response()->json([
                'message' => "variation successfully updated."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            Log::error($e->getMessage());
            return response()->json([
                'message' => "Something went really wrong!$$e"
                
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        {
            // Detail 
            $product = Variation::find($id);
            if(!$product){
              return response()->json([
                 'message'=>'Product Not Found.'
              ],404);
            }
          
            // Public storage
            $storage = Storage::disk('public');
          
            // Iamge delete
            if($storage->exists($product->image))
                $storage->delete($product->image);
          
            // Delete Product
            $product->delete();
          
            // Return Json Response
            return response()->json([
                'message' => "Product successfully deleted."
            ],200);
        }
    }
}
