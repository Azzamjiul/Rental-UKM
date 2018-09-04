<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Product;

class AdminController extends Controller
{
    public function index(){

    }

    public function inventaris(Request $request){
      if (!empty($request->keywords)) {
        $products = Product::where('name','like','%'.$request->keywords.'%')
        ->orWhere('description','like','%'.$request->keywords.'%')->paginate(12);
        $keywords = $request->keywords;
      }else {
        $products = Product::paginate(12);
        $keywords = 'empty';
      }
      return view('inventaris', ['products' => $products->appends(Input::except('page')), 'keywords' => $keywords]);
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
        Product::find($request->id_product)->delete();
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
