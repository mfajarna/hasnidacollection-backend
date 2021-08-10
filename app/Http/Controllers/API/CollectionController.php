<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CollectionController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $category = $request->input('category');
        $types = $request->input('types');

        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        $rate_from = $request->input('rate_from');
        $rate_to = $request->input('rate_to');

        if($id)
        {
            $collection = Collection::find($id);

            if($collection)
            {
                return ResponseFormatter::success(
                    $collection,
                    'Data Produk Berhasil Di Ambil'
                );
            }else{
                return ResponseFormatter::error([
                    null,
                    'Data Produk Tidak Ada',
                    404
                ]);
            }
        }

        $collection = Collection::query();

        if($name)
        {
            $collection->where('name', 'like', '%'. $name . '%');
        }
        if($types)
        {
            $collection->where('types', 'like', '%'. $types . '%');
        }
        if($category)
        {
            $collection->where('category', 'like', '%'. $category . '%');
        }
        if($price_from)
        {
            $collection->where('price', '>=' ,$price_from );
        }
        if($price_to)
        {
            $collection->where('price', '>=' ,$price_to );
        }
        if($rate_from)
        {
            $collection->where('rate', '>=' ,$rate_from );
        }
        if($rate_to)
        {
            $collection->where('rate', '>=' ,$rate_to );
        }

        return ResponseFormatter::success(
            $collection->paginate($limit),
            'Data List Berhasil Di Ambil!'
        );
    }

    public function changeStock(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);

        $collection->stock = $request->stock;
        $collection->save();

            if($collection)
            {
                return ResponseFormatter::success(
                    $collection,
                    'Stock berhasil diubah'
                );
            }else{
                return ResponseFormatter::error([
                    null,
                    'Data Produk Tidak Ada',
                    404
                ]);
            }
    }

    public function create(Request $request)
    {
       try{
         $request->validate([
                'name' => 'required|unique:collections',
                'description' => 'required',
                'stock' => 'required',
                'price' => 'required',
                'rate' => 'required',
                'types' => 'required',
                'category' => 'required',
                'url_barcode' => 'required'
           ]);

           $collection = Collection::create([
                'name' => $request->name,
                'description' => $request->description,
                'stock' => $request->stock,
                'price' => $request->price,
                'rate' => $request->rate,
                'types' => $request->types,
                'category' => $request->category,
                'url_barcode' => $request->url_barcode,
                'picturePath' => $request->picturePath,
                'photoBarcode' =>  $request->photoBarcode
           ]);

           return ResponseFormatter::success($collection, 'Berhasil input data');
       }catch(Exception $e)
       {
           return ResponseFormatter::error($e->getMessage(),'Gagal Input Data');
       }
    }

    public function updatePhoto(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(['error'=>$validator->errors()], 'Update Photo Fails', 401);
        }

        if ($request->file('file')) {

            $file = $request->file->store('assets/user', 'public');

            //store your file into database

            $transaksi = Collection::find($id);
            $transaksi->picturePath = $file;
            $transaksi->update();

            return ResponseFormatter::success([$file],'File successfully uploaded');
        }
    }

        public function updateBarcode(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(['error'=>$validator->errors()], 'Update Photo Fails', 401);
        }

        if ($request->file('file')) {

            $file = $request->file->store('assets/user', 'public');

            //store your file into database

            $transaksi = Collection::find($id);
            $transaksi->photoBarcode = $file;
            $transaksi->update();

            return ResponseFormatter::success([$file],'File successfully uploaded');
        }
    }

}
