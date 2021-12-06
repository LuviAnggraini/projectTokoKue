<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cake;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Alert;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $cake = Cake::where('id', $id)->first();

        return view('pesan.index', compact('cake'));
    }

    public function pesan(Request $request, $id)
    {   
        $cake = Cake::where('id', $id)->first();
        $tanggal = Carbon::now();

        //validasi apakah melebihi stok
        if($request->jumlah_pesan > $cake->stok)
        {
            return redirect('pesan/'.$id);
        }

        //cek validasi
        $cek_transaction = Transaction::where('user_id', Auth::user()->id)->where('status',0)->first();
        //simpan ke database pesanan
        if(empty($cek_transaction))
        {
            $transaction = new Transaction();
            $transaction->user_id = Auth::user()->id;
            $transaction->tanggal = $tanggal;
            $transaction->status = 0;
            $transaction->jumlah_harga = 0;
            $transaction->kode = mt_rand(100, 999);
            $transaction->save();
        }
        

        //simpan ke database transaction detail
        $transaction_baru = Transaction::where('user_id', Auth::user()->id)->where('status',0)->first();

        //cek transaction detail
        $cek_transaction_detail = TransactionDetail::where('cake_id', $cake->id)->where('transaction_id', $transaction_baru->id)->first();
        if(empty($cek_transaction_detail))
        {
            $transaction_detail = new TransactionDetail;
            $transaction_detail->cake_id = $cake->id;
            $transaction_detail->transaction_id = $transaction_baru->id;
            $transaction_detail->jumlah = $request->jumlah_pesan;
            $transaction_detail->jumlah_harga = $cake->harga*$request->jumlah_pesan;
            $transaction_detail->save();
        } else {
            $transaction_detail = TransactionDetail::where('cake_id', $cake->id)->where('transaction_id', $transaction_baru->id)->first();

            $transaction_detail->jumlah = $transaction_detail->jumlah+$request->jumlah_pesan;

            //harga sekarang
            $harga_transaction_detail_baru = $cake->harga*$request->jumlah_pesan;
            $transaction_detail->jumlah_harga = $transaction_detail->jumlah_harga+$harga_transaction_detail_baru;
            $transaction_detail->update();
        }

        //jumlah total
        $transaction = Transaction::where('user_id', Auth::user()->id)->where('status',0)->first();
        $transaction->jumlah_harga = $transaction->jumlah_harga+$cake->harga*$request->jumlah_pesan;
        $transaction->update();
        
        Alert::success('Pesanan Sukses Masuk Keranjang', 'Success');
        return redirect('check-out');
    }

    public function check_out()
    {
        $transaction = Transaction::where('user_id', Auth::user()->id)->where('status',0)->first();
        if(!empty($transaction))
        {
            $transaction_details = TransactionDetail::where('transaction_id', $transaction->id)->get();

        }
        
        return view('transaction.check_out', compact('transaction', 'transaction_details'));
    }

    public function delete($id)
    {
        $transaction_detail = TransactionDetail::where('id', $id)->first();

        $transaction = Transaction::where('id', $transaction_detail->transaction_id)->first();
        $transaction->jumlah_harga = $transaction->jumlah_harga-$transaction_detail->jumlah_harga;
        $transaction->update();


        $transaction_detail->delete();

        Alert::error('Pesanan Sukses Dihapus', 'Hapus');
        return redirect('check-out');
    }

    public function konfirmasi()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if(empty($user->alamat))
        {
            Alert::error('Identitasi Harap dilengkapi', 'Error');
            return redirect('profile');
        }

        if(empty($user->nohp))
        {
            Alert::error('Identitasi Harap dilengkapi', 'Error');
            return redirect('profile');
        }

        $transaction = Transaction::where('user_id', Auth::user()->id)->where('status',0)->first();
        $transaction_id = $transaction->id;
        $transaction->status = 1;
        $transaction->update();

        $transaction_details = TransactionDetail::where('transaction_id', $transaction_id)->get();
        foreach ($transaction_details as $transaction_detail) {
            $cake = Cake::where('id', $transaction_detail->cake_id)->first();
            $cake->stok = $cake->stok-$transaction_detail->jumlah;
            $cake->update();
        }

        Alert::success('Pesanan Sukses Check Out Silahkan Lanjutkan Proses Pembayaran', 'Success');
        return redirect('history/'.$transaction_id);
    }
}
