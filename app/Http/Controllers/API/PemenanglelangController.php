<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Models\Pemenanglelang;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PemenanglelangController extends Controller
{
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $status = $request->input('status');

        $pemenangLelang = Pemenanglelang::with(['user','lelangdetail','collection'])
                                                ->where('users_id', Auth::user()->id);

        if($status)
        {
            $pemenangLelang->where('status', $status);
        }

        return ResponseFormatter::success(
            $pemenangLelang->paginate($limit),
                'Data Pemenang Lelang Berhasil Di Ambil!'
        );
    }

    public function all(Request $request)
    {
        $limit = $request->input('limit', 100);
        $status = $request->input('status');

        $pemenangLelang = Pemenanglelang::with(['user','lelangdetail','collection']);

        if($status)
        {
            $pemenangLelang->where('status', $status);
        }

        return ResponseFormatter::success(
            $pemenangLelang->paginate($limit),
                'Data Pemenang Lelang Berhasil Di Ambil!'
        );
    }

     public function updateStatus(Request $request, $id)
     {
        $pemenangLelang = Pemenanglelang::findOrFail($id);

        $pemenangLelang->status = $request->status;
        $pemenangLelang->save();

        if($pemenangLelang)
            {
                return ResponseFormatter::success(
                    $pemenangLelang,
                    'Status berhasil diubah'
                );
            }else{
                return ResponseFormatter::error([
                    null,
                    'Data Tidak Ada',
                    404
                ]);
            }
     }

    public function create(Request $request)
    {
        try{
            $request->validate([
                'users_id' => 'required',
                'collection_id' => 'required',
                'lelangdetail_id' => 'required',
                'status' => 'required'
            ]);

            $pemenangLelang = Pemenanglelang::create([
                'users_id' => $request->users_id,
                'collection_id' => $request->collection_id,
                'lelangdetail_id' => $request->lelangdetail_id,
                'status' => $request->status
            ]);

            $pemenangLelang = Pemenanglelang::with(['user','lelangdetail','collection'])->find($pemenangLelang->id);
            return ResponseFormatter::success($pemenangLelang,'Transaksi berhasil');

        }catch(Exception $e)
        {
            return ResponseFormatter::error($e->getMessage(),'Transaksi Gagal');
        }
    }

    public function updatePhotoPembayaran(Request $request, $id)
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

            $transaksi = Pemenanglelang::find($id);
            $transaksi->pembayaranPath = $file;
            $transaksi->update();

            return ResponseFormatter::success([$file],'File successfully uploaded');
        }


     }


}
