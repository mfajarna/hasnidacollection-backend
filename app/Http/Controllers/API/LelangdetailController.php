<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Lelangdetail;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LelangdetailController extends Controller
{
    public function prosesLelang(Request $request)
    {

        try{
            $request->validate([
                'id_collection' => 'required|exists:collections,id',
                'id_users' => 'required|exists:users,id',
                'jumlah_bid' => 'required|integer'
            ]);

            $lelang = Lelangdetail::create([
                'id_collection' => $request->id_collection,
                'id_users' => $request->id_users,
                'jumlah_bid' => $request->jumlah_bid
            ]);
            $lelang = Lelangdetail::with(['collection','user'])->find($lelang->id);
            return ResponseFormatter::success($lelang,'Lelang Proses berhasil');

        }catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(),'Transaksi Gagal');
        }
    }
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 100);
        $jumlah_bid = $request->input('jumlah_bid');


        if($id)
        {
            $lelang = Lelangdetail::with(['collection','user'])->find($id);

            if($lelang)
            {
                return ResponseFormatter::success(
                    $lelang,
                    'Data Lelang Berhasil Di Ambil'
                );
            }else{
                return ResponseFormatter::error([
                    null,
                    'Data Lelang Tidak Ada',
                    404
                ]);
            }
        }

        $lelang = Lelangdetail::with(['collection','user'])
                                    ->where('id_users', Auth::user()->id);

        if($jumlah_bid)
        {
            $lelang->where('jumlah_bid', $jumlah_bid);
        }
        return ResponseFormatter::success(
            $lelang->paginate($limit),
            'Data List transaksi Berhasil Di Ambil!'
        );
    }

}
