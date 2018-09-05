<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Product;
use App\Kas;
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
      $kas = Kas::all();
      return view('log', compact('kas'));
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
        return response()->json($e->getMessage());
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

}
