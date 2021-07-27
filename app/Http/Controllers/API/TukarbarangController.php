<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tukarbarang;

class TukarbarangController extends Controller
{
    public function create(Request $request)
    {
        try{
            $request->validate([
                'id_collection' => 'required|exists:collections, id',
                'id_users' => 'required|exists:users, id',
                'alasan_tukar_barang' => 'required|string',
                'file' => 'required|image:jpeg,png,jpg|max:2048',
                'status' => 'required|string'
            ]);

            if($request->file('file'))
            {
                $file = $request->file->store('assets/user', 'public');

                $tukarBarang = Tukarbarang::create([
                    'id_collection' => $request->id_collection,
                    'id_users' => $request->id_users,
                    'alasan_tukar_barang' => $request->alasan_tukar_barang,
                    'file' => $file,
                    'status' => $request->status
                ]);

                $tukarBarang = Tukarbarang::with(['collection','users'])->find($tukarBarang->id);
                    return ResponseFormatter::success($tukarBarang, 'Berhasil input tukar barang');
            }
        }catch(Exception $e)
        {
             return ResponseFormatter::error($e->getMessage(),'Transaksi Gagal');
        }
    }
}
