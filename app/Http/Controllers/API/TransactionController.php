<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
     public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $collection_id = $request->input('collection_id');
        $status = $request->input('status');


        if($id)
        {
            $transaction = Transaction::with(['collection','user'])->find($id);

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

        $transaction = Transaction::with(['collection','user'])
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

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->update($request->all());

        return ResponseFormatter::success($transaction, 'Transaksi berhasil diubah');
    }
}
