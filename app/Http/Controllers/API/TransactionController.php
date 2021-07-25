<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
     public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $collection_id = $request->input('collection_id');
        $status = $request->input('status');


        if($id)
        {
            $transaction = Transaksi::with(['collection','user'])->find($id);

            if($transaction)
            {
                return ResponseFormatter::success(
                    $transaction,
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

        $transaction = Transaksi::with(['collection','user'])
                                    ->where('user_id', Auth::user()->id);

        if($collection_id)
        {
            $transaction->where('collection_id', $collection_id);
        }
        if($status)
        {
            $transaction->where('status', $status);
        }

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Data List transaksi Berhasil Di Ambil!'
        );
    }

    public function fetch(Request $request)
    {

        $status = $request->input('status');
        $limit = $request->input('limit', 100);

         $transaksi = Transaksi::with(['collection','user']);

         if($status)
        {
            $transaksi->where('status', 'like', '%'. $status . '%');
        }

        return ResponseFormatter::success(
            $transaksi->paginate($limit),
            'Data List Transaksi Berhasil Di Ambil!'
        );


    }

    public function update(Request $request, $id)
    {
        $transaction = Transaksi::findOrFail($id);

        $transaction->update($request->all());

        return ResponseFormatter::success($transaction, 'Transaksi berhasil diubah');
    }
     public function checkout(Request $request)
    {
        try {
        $request->validate([
            'collection_id' => 'required|exists:collections,id',
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required',
            'total' => 'required',
            'no_transaksi' => 'string',
            'no_resi' => 'string',
            'status' => 'required',
        ]);

        $transaction = Transaksi::create([
            'collection_id' => $request->collection_id,
            'user_id' => $request->user_id,
            'quantity' => $request->quantity,
            'total' => $request->total,
            'status' => $request->status,
            'no_transaksi' => $request->no_transaksi,
            'no_resi' => $request->no_resi

        ]);
        $transaction = Transaksi::with(['collection','user'])->find($transaction->id);
            return ResponseFormatter::success($transaction,'Transaksi berhasil');

        }catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(),'Transaksi Gagal');
        }
    }

     public function getPastOrders(Request $request)
     {
        $id = $request->input('id');
        $limit = $request->input('limit', 100);
        $collection_id = $request->input('collection_id');
        $status = $request->input('status');

        if($id)
        {
            $transaction = Transaksi::with(['collection','user'])->find($id);

            if($transaction)
            {
                return ResponseFormatter::success(
                    $transaction,
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

        $transaction = Transaksi::with(['collection','user'])
                                    ->where('user_id', Auth::user()->id)->whereIn('status', ['DONE']);

        if($collection_id)
        {
            $transaction->where('collection_id', $collection_id);
        }
        if($status)
        {
            $transaction->where('status', $status);
        }

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Data List transaksi!'
        );
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

            $transaksi = Transaksi::find($id);
            $transaksi->pembayaranPath = $file;
            $transaksi->update();

            return ResponseFormatter::success([$file],'File successfully uploaded');
        }


     }

}
