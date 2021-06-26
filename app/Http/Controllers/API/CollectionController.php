<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
