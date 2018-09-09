<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Product;
use App\Kas;
use App\Rent;
use App\Invoice;
use DateTime;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(){

    }

    public function inventaris(Request $request){
      if (!empty($request->keywords)) {
        $products = Product::where('name','like','%'.$request->keywords.'%')
        ->orWhere('description','like','%'.$request->keywords.'%')->where('deleted', 0)->paginate(12);
        $keywords = $request->keywords;
      }else {
        $products = Product::where('deleted', 0)->paginate(12);
        $keywords = 'empty';
      }
      return view('inventaris', ['products' => $products->appends(Input::except('page')), 'keywords' => $keywords]);
    }

    public function bukuBesar(Request $request){
      return view('log');
    }

    public function historis(Request $request){
      return view('historis');
    }

    public function getHistory(){
      $packets = Invoice::select('id_invoice', 'rent_date','cust_name', 'total_price')->orderBy('rent_date', 'asc')->get();
      return response()->json(['data'=>$packets]);
    }

    public function getKas(){
      $packets = Kas::select('id_kas','description','date','price','type')->orderBy('date', 'desc')->get();
      return response()->json(['data'=>$packets]);
    }

    public function editKas(Request $request)
    {
      try {
        Kas::where('id_kas', $request->id_kas)
        ->update([
          'description' => $request->deskripsiEdit,
          'price' => $request->jumlahEdit,
        ]);
      } catch (\Exception $e) {
        return redirect('/log')->with('error', 'Pemasukan gagal diedit!');
      }
      return redirect('/log')->with('success', 'Pemasukan berhasil diedit!');
    }

    public function deleteKas(Request $request){
      try {
        Kas::where('id_kas', $request->id_kas)->delete();
      } catch (\Exception $e) {
        return redirect('/log')->with('error', 'Catatan kas gagal
        dihapus!');
      }
      return redirect('/log')->with('success', 'Catatan kas berhasil
      dihapus!');
    }

    public function pemasukan(Request $request)
    {
      try {
        Kas::create([
          'description' => $request->deskripsiMasuk,
          'price' => $request->jumlahMasuk,
          'type' => 'pemasukan',
          'date' => Carbon::now() //timezone jakarta
        ]);
      } catch (\Exception $e) {
        return redirect('/log')->with('error', 'Pemasukan gagal disimpan!');
      }
      return redirect('/log')->with('success', 'Pemasukan berhasil disimpan!');
    }

    public function pengeluaran(Request $request)
    {
      try {
        Kas::create([
          'description' => $request->deskripsiKeluar,
          'price' => $request->jumlahKeluar,
          'type' => 'pengeluaran',
          'date' => Carbon::now() //timezone jakarta
        ]);
      } catch (\Exception $e) {
        return redirect('/log')->with('error', 'Pengeluaran gagal disimpan!');
      }
      return redirect('/log')->with('success', 'Pengeluaran berhasil disimpan!');
    }

    public function report(Request $request){
      return view('report');
    }

    //utk nambah barang baru
    public function addProduct(Request $request){
      try {
        Product::create([
          'quantity' => $request->product_quantity,
          'description' => $request->product_description,
          'name' => $request->product_name,
          'price' => $request->product_price,
          'category' => 'alat musik'
        ]);
      } catch (\Exception $e) {
        // return $e->getMessage();
        return redirect('/inventaris')->with('error', 'Barang gagal
        disimpan!');
      }
      return redirect('/inventaris')->with('success', 'Barang berhasil
      disimpan!');
    }

    public function deleteProduct(Request $request){
      try {
        Product::where('id_product', $request->id_product)->update(['deleted' => 1]);
      } catch (\Exception $e) {
        return redirect('/inventaris')->with('error', 'Barang gagal
        dihapus!');
      }
      return redirect('/inventaris')->with('success', 'Barang berhasil
      dihapus!');
    }

    public function findProduct(Request $request){
      try {
        $product = Product::find($request->id_product);
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
      return response()->json($product, 200);
    }

    public function updateProduct(Request $request){
      try {
        Product::where('id_product', $request->id_product)
        ->update([
          'quantity' => $request->product_quantity,
          'description' => $request->product_description,
          'name' => $request->product_name,
          'price' => $request->product_price,
          'category' => 'alat musik'
        ]);
      } catch (\Exception $e) {

        return redirect('/inventaris')->with('error', 'Barang gagal
        diperbaruhi!');
      }
      return redirect('/inventaris')->with('success', 'Barang berhasil
      diperbaruhi!');

    }

    public function transaksiPage(){
      $products = Product::where('deleted', 0)->get();
      return view('transaksi', ['products' => $products]);
    }

    public function productsForTransaction(){
      $products = Product::where('deleted', 0)->get();
      return response()->json(['data' => $products], 200);
    }

    public function newTransaction(Request $request){
      $ngutang = 0;
      try {
        $dp=$request->total_price_hidden;
        $discount = 0;
        if ($request->dp != null || $request->dp > 0) {
          $dp = $request->dp;
          $ngutang = 1;
        }
        if ($request->discount != null || $request->discount > 0) {
          $discount = $request->$discount;
        }
        // return $products = json_decode($request->products);
        //bikin nota
        $now =  Carbon::now();
        $invoice = Invoice::create([
          'invoice_date' => $now, //timezone jakarta/.
          'rent_date' => $request->start_date,
          'deadline_date' => $request->end_date,
          'cust_name' => $request->cust_name,
          'address' => $request->address,
          'cust_phone' => $request->cust_phone,
          'dp' => $dp,
          'total_price' => $request->total_price_hidden,
          'status' => 0,
          'admin' => 'Penjual Arta',
          'discount' => 0
        ]);

        $product_name = '';

        $products = json_decode($request->products);
        //rent baru utk produk yang dipinjam
        for ($i=0; $i < count($products) ; $i++) {
          $product_name.=$products[$i]->name.', ';
          Rent::create([
            'id_invoice' => $invoice->id_invoice,
            'id_product' => $products[$i]->id_product,
            'prod_quantity' => $products[$i]->chose,
            'sum_price' => $products[$i]->chose * $products[$i]->price
          ]);
          $p = Product::find($products[$i]->id_product);
          $p->on_rent = $p->on_rent + $products[$i]->chose;
          $p->save();
        }
        $pemasukan = 0;
        if ($ngutang) {
          $pemasukan = $dp;
          $desc = 'Uang Muka';
        }else {
          $pemasukan = $request->total_price_hidden;
          $desc = 'Lunas';
        }

        //tambahin ke tabel kas sebagai Pemasukan
        Kas::create([
          'description' => $desc.' | ID NOTA: '. $invoice->id_invoice.' | '. $product_name,
          'price' => $pemasukan,
          'type' => 'pemasukan',
          'date' => Carbon::now() //timezone jakarta
        ]);

        Kas::create([
          'description' => 'peminjaman dari '.$request->cust_name,
          'price' => $request->total_price_hidden,
          'type' => 'peminjaman',
          'date' => $request->start_date
        ]);

      } catch (\Exception $e) {
        // return $e->getMessage();
        return response()->json($e->getMessage(), 500);

      }
      return response()->json(['message'=>'success', $invoice, $products], 201);
    }

    public function invoice($id){
      $invoice = Invoice::find($id);
      $rents = Rent::where('id_invoice', $id)->get();

      return view('pdf.invoice', ['invoice' => $invoice, 'rents' => $rents]);
    }

}
