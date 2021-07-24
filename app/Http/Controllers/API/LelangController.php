<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Lelang;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class LelangController extends Controller
{
    public function create(Request $request)
    {
        try
        {
            $request->validate([
                'id_collection' => 'required|exists:collections,id',
                'time' => 'required|integer',
                'bid' => 'required|integer',
                'status' => 'required|string',
            ]);

            $lelang = Lelang::create([
                'id_collection' => $request->id_collection,
                'time' => $request->time,
                'bid' => $request->bid,
                'status' => $request->status
            ]);

            $lelang = Lelang::with(['collection'])->find($lelang->id);
            return ResponseFormatter::success($lelang, 'Lelang Berhasil');
        }catch(Exception $e)
        {
             return ResponseFormatter::error($e->getMessage(),'Lelang Barang Gagal');
        }
    }

    public function fetch(Request $request)
    {
        $status = $request->input('status');
        $limit = $request->input('limit', 100);

        $lelang = Lelang::with(['collection']);

        if($status)
        {
            $lelang->where('status', 'like', '%'. $status . '%');
        }

        return responseFormatter::success(
            $lelang->paginate($limit),
            'Data list lelang berhasil diambil'
        );
    }
}
