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
      $packets = Invoice::select('id_invoice', 'rent_date','cust_name', 'total_price', 'type')->orderBy('rent_date', 'asc')->get();
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
          'category' => 'alat musik',
          'type' => $request->type
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
      $products = Product::where('deleted', 0)->where('type', 'sewa')->get();
      return view('transaksi', ['products' => $products]);
    }

    public function productsForTransaction(){
      $products = Product::where('deleted', 0)->get();
      return response()->json(['data' => $products], 200);
    }

    public function newTransaction(Request $request){

      $ngutang = 0;
      $lunas = 1;
      try {
        $dp=$request->total_price_hidden;
        $discount = 0;
        if ($request->dp != null || $request->dp > 0) {
          $dp = $request->dp;
          $ngutang = 1;
          $lunas = 0;
        }
        if ($request->discount != null || $request->discount > 0) {
          $discount = $request->$discount;
        }

        $now =  Carbon::now();
        $invoice = Invoice::create([
          'id_invoice' => 'ARTA-'.str_random(4),
          'invoice_date' => $now, //timezone jakarta/.
          'rent_date' => $request->start_date,
          'deadline_date' => $request->end_date,
          'cust_name' => $request->cust_name,
          'address' => $request->address,
          'cust_phone' => $request->cust_phone,
          'dp' => $dp,
          'total_price' => $request->total_price_hidden,
          'status' => $lunas, //1 berarti udah lunas
          'admin' => 'Penjual Arta',
          'discount' => 0,
          'description' => $request->product_description
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
          'description' => 'PENYEWAAN | '. $desc.' | ID NOTA: '. $invoice->id_invoice.' | '. $product_name,
          'price' => $pemasukan,
          'type' => 'pemasukan',
          'date' => $now
        ]);

      } catch (\Exception $e) {
        // return $e->getMessage();
        return response()->json($e->getMessage(), 500);

      }
      return response()->json(['message'=>'success', $invoice, $products], 201);
    }
    //sewa
    public function invoice($id){
      $invoice = Invoice::where('ref_id', $id)->first();

      //ini yang sebelumnya uang muka tapi udah lunas
      if (0) {
        $rents = Rent::where('id_invoice', $id)->get();
      }
      else {
        $invoice = Invoice::find($id);
        $rents = Rent::where('id_invoice', $id)->get();
      }

      $type = $invoice->type;


      return view('pdf.invoice', ['invoice' => $invoice, 'rents' => $rents, 'type' => $type]);
    }
    //nota pelunasan sewa
    public function newInvoice($id){
      $invoice = Invoice::find($id);
      $type = $invoice->type;
      $rents = Rent::where('id_invoice', $invoice->ref_id)->get();

      return view('pdf.invoice', ['invoice' => $invoice, 'rents' => $rents,  'type' => $type]);
    }

    public function pengembalianBarang(){
      return view('pengembalian');
    }

    public function getOnRentInvoices(){
      $invoices = Invoice::where('status', '<', 3)->where('type', 'sewa')->get();
      return response()->json(['data' => $invoices]);
    }

    public function getItemsOnRent(Request $request){
      try {
        $products = Rent::where('id_invoice', $request->id_invoice)->with('product')->get();
        $invoice = Invoice::find($request->id_invoice);
        //cek kalo sudah lunas
        $paid_fully = 0;
        if ($invoice->dp == $invoice->total_price) {
          $paid_fully = 1;
        }
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
      return response()->json([$products, 'lunas' => $paid_fully, $invoice]);
    }

    public function returnProduct(Request $request){
      try {
        $on_rent = Rent::where('id_invoice', $request->id_invoice)->get();
        $invoice = Invoice::find($request->id_invoice);
        $invoice->status = $invoice->status + 2;  //kalo stattus = 1 udah lunas, status = 2 berarti udak ngembaliin barang, status = 3 udah dua2nya
        $invoice->save();

        for ($i=0; $i < $on_rent->count() ; $i++) {
          $product = Product::find($on_rent[$i]->id_product);
          $product->on_rent = $product->on_rent - $on_rent[$i]->prod_quantity;
          $product->save();
        }
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), 500);
      }

      return response()->json(['message' => 'success'], 200);
    }

    //pelunasan barang
    public function payFully(Request $request){
      try {
        $now = Carbon::now();
        $invoice = Invoice::find($request->id_invoice);
        $invoice->status =$invoice->status + 1; //kalo stattus = 1 udah lunas, status = 2 berarti udak ngembaliin barang, status = 3 udah dua2nya

        $new_invoice = Invoice::create([
          'id_invoice'=> 'ARTA-'.str_random(4),
          'invoice_date' => Carbon::now(),
          'ref_id' => $invoice->id_invoice,
          'rent_date'=> $invoice->rent_date,
          'deadline_date' => $invoice->deadline_date,
          'cust_name' => $invoice->cust_name,
          'cust_phone' => $invoice->cust_phone,
          'address' => $invoice->address,
          'total_price' => $invoice->total_price - $invoice->dp,
          'discount' => 0,
          'status' => 3,
          'dp' => $invoice->total_price - $invoice->dp,
          'admin' => 'Penjual Arta',
          'description' => 'Pelunasan untuk ID Nota: '. $invoice->id_invoice,
          'type' => 'sewa'
        ]);

        //tambahin ke tabel kas sebagai Pemasukan
        Kas::create([
          'description' => 'Pelunasan utk ID NOTA: '.$invoice->id_invoice .' | ID NOTA: '. $new_invoice->id_invoice,
          'price' => $invoice->total_price - $invoice->dp,
          'type' => 'pemasukan',
          'date' => $now
        ]);

        // $invoice->dp = $invoice->total_price;
        $invoice->save();

      } catch (\Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
      return response()->json(['message' => 'success', 'invoice' => $new_invoice], 200);

    }

    public function payFullySell(Request $request){
      try {
        $now = Carbon::now();
        $invoice = Invoice::find($request->id_invoice);
        $invoice->status =$invoice->status + 1; //kalo stattus = 1 udah lunas, status = 2 berarti udak ngembaliin barang, status = 3 udah dua2nya

        $new_invoice = Invoice::create([
          'id_invoice'=> 'ARTA-'.str_random(4),
          'invoice_date' => Carbon::now(),
          'ref_id' => $invoice->id_invoice,
          'rent_date'=> $invoice->rent_date,
          'deadline_date' => $invoice->deadline_date,
          'cust_name' => $invoice->cust_name,
          'cust_phone' => $invoice->cust_phone,
          'address' => $invoice->address,
          'total_price' => $invoice->total_price - $invoice->dp,
          'discount' => 0,
          'status' => 3,
          'dp' => $invoice->total_price - $invoice->dp,
          'admin' => 'Penjual Arta',
          'description' => 'Pelunasan untuk ID Nota: '. $invoice->id_invoice,
          'type' => 'jual'
        ]);

        //tambahin ke tabel kas sebagai Pemasukan
        Kas::create([
          'description' => 'Pelunasan utk ID NOTA: '.$invoice->id_invoice .' | ID NOTA: '. $new_invoice->id_invoice,
          'price' => $invoice->total_price - $invoice->dp,
          'type' => 'pemasukan',
          'date' => $now
        ]);

        // $invoice->dp = $invoice->total_price;
        $invoice->save();

      } catch (\Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
      return response()->json(['message' => 'success', 'invoice' => $new_invoice], 200);

    }

    public function transaksiJualPage(){
      $products = Product::where('deleted', 0)->where('type', 'jual')->get();
      return view('transaksi-jual-beli', ['products' => $products]);
    }

    public function sellProducts(Request $request){

            $ngutang = 0;
            $lunas = 1;
            try {
              $dp=$request->total_price_hidden;
              $discount = 0;
              if ($request->dp != null || $request->dp > 0) {
                $dp = $request->dp;
                $ngutang = 1;
                $lunas = 0;
              }
              if ($request->discount != null || $request->discount > 0) {
                $discount = $request->$discount;
              }

              $now =  Carbon::now();
              $invoice = Invoice::create([
                'id_invoice' => 'ARTA-'.str_random(4),
                'invoice_date' => $now, //timezone jakarta/.
                'rent_date' => $now,
                'deadline_date' => $now,
                'cust_name' => $request->cust_name,
                'address' => $request->address,
                'cust_phone' => $request->cust_phone,
                'dp' => $dp,
                'total_price' => $request->total_price_hidden,
                'status' => $lunas, //1 berarti udah lunas
                'admin' => 'Penjual Arta',
                'discount' => 0,
                'description' => $request->product_description,
                'type' => 'jual'
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
                $p->quantity = $p->quantity - $products[$i]->chose;
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
                'description' =>'PENJUALAN | '. $desc.' |ID NOTA: '. $invoice->id_invoice.' | '. $product_name,
                'price' => $pemasukan,
                'type' => 'pemasukan',
                'date' => $now
              ]);

            } catch (\Exception $e) {
              // return $e->getMessage();
              return response()->json($e->getMessage(), 500);

            }
            return response()->json(['message'=>'success', $invoice, $products], 201);
    }

}
