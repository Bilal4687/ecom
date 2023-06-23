<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function Product(){


        return view('Product.product');

    }
    public function AddProduct(Request $req){
if($req->input('id')){
    $data = DB::table('products')->where('product_id', $req->input('id'))->first();
    $attributes = DB::table('product_attribute')->where('product_id', $req->input('id'))->get();

}
// return $attributes;
        $defaultAttributes = ['Weight', 'Size', 'Color', 'Height'];
        return view('Product.AddProduct', ['defaultAttributes'=> $defaultAttributes, "attributes"=> $attributes, "data"=>$data]);


    }
    public function ProductStore(Request $req)
    {
        $validator = Validator::make($req->all(), [

            'product_name' => 'required',
            'product_description' => 'required',
            'product_main_image' => 'required'

        ]);
        $attributes_id = json_decode($req->input('attributes_id'));
        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        if($req->hasFile('product_main_image'))
        {
                $image = $req->file('product_main_image');
                $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
                file_put_contents(base_path("public/Product/" . $imageName), file_get_contents($image));

        }
        else
        {
            $data =  DB::table('products')->where('product_id',$req->input('product_id'))->get();
            $imageName = $data[0]->product_main_image;
        }

        try {



            $Product =  DB::table('products')->updateOrInsert(

                ['product_id' => $req->input('product_id')],
                [

                    'product_name' => $req->input('product_name'),
                    'product_description' => $req->input('product_description'),
                    'product_main_image' => $imageName
                ]
            );

            $product_id = DB::getPdo()->lastInsertId();

            foreach ($attributes_id as $row) {
            DB::table('product_attribute')->where('attribute_id', $row)->update(['product_id'=> $product_id]);
            }

            return response()->json(["success" => true, "message" => !$req->input('product_id') ? "Product Create Successfully" : "Product Updated Successfully"]);
        } catch (\Throwable $th) {
            return $th->getMessage();
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err"=>$th]);
        }
    }

    public function AttributeStore(Request $req)
    {
        $validator = Validator::make($req->all(), [

            'attribute_name' => 'required',
            'attribute_value' => 'required',
            'attribute_price' => 'required',
            'attribute_image' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        $data = [
            'attribute_name' => $req->input('attribute_name'),
            'attribute_value' => $req->input('attribute_value'),
            'attribute_price' => $req->input('attribute_price'),
            'attribute_status' => $req->input('status') ? 1 : 0,
        ];

        if ($req->hasFile('attribute_image')) {
            $image = $req->file('attribute_image');
            $data['attribute_image'] = Str::random(20) . '.' . $image->getClientOriginalExtension();
            file_put_contents(base_path("public/AttributeImage/" . $data['attribute_image']), file_get_contents($image));

        }

        /* if($req->hasFile('attribute_image'))
        {
                $image = $req->file('attribute_image');
                $imageNameWithExt = $image->getClientOriginalName();
                $imageName = $imageNameWithExt;
                $newName = str_replace(" ", "_", strtolower($imageName));
                $newName = strtolower($imageName) . '.' . $image->extension();
                $imageThumbnail = mt_rand(100, 99999) . '_' . $imageNameWithExt;
                $image->move('public/AttributeImage/', $imageThumbnail);

                if ($req->input('attribute_id')) {
                    $findImage = DB::table('product_attribute')->where('attribute_id', $req->input('attribute_id'))->first();
                    if (file_exists('public/AttributeImage/' . $findImage->attribute_image) && !empty($findImage->attribute_image)) {
                        unlink('public/AttributeImage/' . $findImage->attribute_image);
                    }
                }

        } */
        else
        {
            $data =  DB::table('product_attribute')->where('attribute_id',$req->input('attribute_id'))->get();
            $imageName = $data[0]->attribute_image;
        }

        try {

            $Attributes =  DB::table('product_attribute')->updateOrInsert(

                ['attribute_id' => $req->input('attribute_id')],
                $data
            );
            return response()->json(["success" => true, "data"=>$data, "id"=>DB::getPdo()->lastInsertId() ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err"=>$th]);
        }
    }

    public function ProductShow()
    {
        $Products = DB::table('products')->get();
        return response()->json($Products);
    }
    // app/Http/Controllers/ProductController.ph
}
