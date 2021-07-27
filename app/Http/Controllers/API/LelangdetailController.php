<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Lelangdetail;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;

class LelangdetailController extends Controller
{
    public function prosesLelang(Request $request)
    {

        try{
            $request->validate([
                'id_lelang' => 'required|exists:lelangs,id',
                'id_collection' => 'required|exists:collections,id',
                'id_users' => 'required|exists:users,id',
                'jumlah_bid' => 'required|integer'
            ]);

            $lelangDetail = Lelangdetail::create([
                'id_lelang' => $request->id_lelang,
                'id_collection' => $request->id_collection,
                'id_users' => $request->id_users,
                'jumlah_bid' => $request->jumlah_bid
            ]);
            $lelangDetail = Lelangdetail::with(['lelang','user','collection'])->find($lelangDetail->id);
            return ResponseFormatter::success($lelangDetail,'Lelang Proses berhasil');

        }catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(),'Transaksi Gagal');
        }
    }
    public function all(Request $request)
    {
        $id = $request->input('id');
        $id_users = $request->input('id_users');
        $id_lelang = $request->input('id_lelang');
        $limit = $request->input('limit', 100);
        $jumlah_bid = $request->input('jumlah_bid');


        if($id)
        {
            $lelangDetail = Lelangdetail::with(['collection','user','lelang'])->find($id);

            if($lelangDetail)
            {
                return ResponseFormatter::success(
                    $lelangDetail,
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

        $lelangDetail = Lelangdetail::with(['lelang','user','collection']);

        if($id_lelang)
        {
            $lelangDetail->where('id_lelang', $id_lelang);
        }

        if($jumlah_bid)
        {
            $lelangDetail->where('jumlah_bid', $jumlah_bid);
        }
        return ResponseFormatter::success(
            $lelangDetail->paginate($limit),
            'Data List transaksi Berhasil Di Ambil!'
        );
    }

    public function fetch(Request $request)
    {
        $limit = $request->input('limit', 100);
        $id_lelang = $request->input('id_lelang');

        $lelangDetail = Lelangdetail::with(['lelang','user','collection'])->where('id_lelang', 'like', '%'. $id_lelang . '%')->orderBy('jumlah_bid', 'desc');


        return ResponseFormatter::success(
            $lelangDetail->paginate($limit),
            'Data List transaksi Berhasil Di Ambil!'
        );
    }

}
