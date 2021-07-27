<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Tukarbarang;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TukarbarangController extends Controller
{

    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $status = $request->input('status');


        if($id)
        {
            $tukarBarang = Tukarbarang::with(['collection','user'])->find($id);

            if($tukarBarang)
            {
                return ResponseFormatter::success(
                    $tukarBarang,
                    'Data Transaksi Berhasil Di Ambil'
                );
            }else{
                return ResponseFormatter::error([
                    null,
                    'Data Transaksi Tidak Ada',
                    404
                ]);
            }
        }

        $tukarBarang = Tukarbarang::with(['collection','users'])
                                    ->where('id_users', Auth::user()->id);

        if($status)
        {
            $tukarBarang->where('status', $status);
        }

        return ResponseFormatter::success(
            $tukarBarang->paginate($limit),
            'Data List transaksi Berhasil Di Ambil!'
        );
    }


    public function create(Request $request)
    {
        try{
            $request->validate([
                'id_collection' => 'required|exists:collections,id',
                'id_users' => 'required|exists:users,id',
                'alasan_tukar_barang' => 'required|string',
                'status' => 'required|string'
            ]);


                $tukarBarang = Tukarbarang::create([
                    'id_collection' => $request->id_collection,
                    'id_users' => $request->id_users,
                    'alasan_tukar_barang' => $request->alasan_tukar_barang,
                    'status' => $request->status
                ]);

                $tukarBarang = Tukarbarang::with(['collection','users'])->find($tukarBarang->id);
                    return ResponseFormatter::success($tukarBarang, 'Berhasil input tukar barang');

        }catch(Exception $e)
        {
             return ResponseFormatter::error($e->getMessage(),'Transaksi Gagal');
        }
    }

    public function updateBuktiPhoto(Request $request, $id)
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

            $transaksi = Tukarbarang::find($id);
            $transaksi->buktiPhoto = $file;
            $transaksi->update();

            return ResponseFormatter::success([$file],'File successfully uploaded');
        }

    }


}
