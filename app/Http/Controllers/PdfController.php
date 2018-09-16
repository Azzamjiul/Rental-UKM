<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Kas;
use App\Rent;
use App\Invoice;
use Carbon\Carbon;
use PDF;

class PdfController extends Controller
{
    public function index(){

    }

    public function getPdfKas($tahun, $bulan){
        if ($bulan=="all") {
            $kas = Kas::where(DB::raw('YEAR(date)'), '=', $tahun)->get();
            $pdf = PDF::loadView('pdf.kas',compact('kas','tahun'))->setPaper('a4');
        }
        else{
            $kas = Kas::where(DB::raw('MONTH(date)'), '=', $bulan)->where(DB::raw('YEAR(date)'), '=', $tahun)->get();
            $pdf = PDF::loadView('pdf.kas',compact('kas','bulan','tahun'))->setPaper('a4');
        }
            return $pdf->stream("Laporan Kas.pdf");
    }

    public function downloadPdfKas($tahun, $bulan){
        if ($bulan=="all") {
            $kas = Kas::where(DB::raw('YEAR(date)'), '=', $tahun)->get();
            $pdf = PDF::loadView('pdf.kas',compact('kas','tahun'))->setPaper('a4');
        }
        else{
            $kas = Kas::where(DB::raw('MONTH(date)'), '=', $bulan)->where(DB::raw('YEAR(date)'), '=', $tahun)->get();
            $pdf = PDF::loadView('pdf.kas',compact('kas','bulan','tahun'))->setPaper('a4');
        }

        return $pdf->download("Laporan Kas bulan $bulan $tahun.pdf");
    }

    public function getPdfInvoices($tahun, $bulan){
        if ($bulan=="all") {
            $report = DB::table('rent')
            ->leftJoin('invoice', 'rent.id_invoice', '=', 'invoice.id_invoice')
            ->leftJoin('product', 'rent.id_product', '=', 'product.id_product')
            ->select('invoice.rent_date', 'invoice.cust_name', 'invoice.id_invoice', 'invoice.total_price','invoice.address', 'invoice.type', 'rent.prod_quantity', 'product.name')
            ->where(DB::raw('YEAR(rent_date)'), '=', $tahun)
            ->get();

            $sum = DB::table('rent')
            ->leftJoin('invoice', 'rent.id_invoice', '=', 'invoice.id_invoice')
            ->leftJoin('product', 'rent.id_product', '=', 'product.id_product')
            ->select('invoice.id_invoice', DB::raw('count(invoice.id_invoice) as sum_invoice'))
            ->groupBy('invoice.id_invoice')
            ->where(DB::raw('YEAR(rent_date)'), '=', $tahun)
            ->get();

            $pdf = PDF::loadView('pdf.report',compact('report','tahun','sum'))->setPaper('a4');

        }
        else{
            $report = DB::table('rent')
            ->leftJoin('invoice', 'rent.id_invoice', '=', 'invoice.id_invoice')
            ->leftJoin('product', 'rent.id_product', '=', 'product.id_product')
            ->select('invoice.rent_date', 'invoice.cust_name', 'invoice.id_invoice', 'invoice.total_price','invoice.address','invoice.type','rent.prod_quantity', 'product.name')
            ->where(DB::raw('MONTH(rent_date)'), '=', $bulan)
            ->where(DB::raw('YEAR(rent_date)'), '=', $tahun)
            ->get();

            $sum = DB::table('rent')
            ->leftJoin('invoice', 'rent.id_invoice', '=', 'invoice.id_invoice')
            ->leftJoin('product', 'rent.id_product', '=', 'product.id_product')
            ->select('invoice.id_invoice', DB::raw('count(invoice.id_invoice) as sum_invoice'))
            ->groupBy('invoice.id_invoice')
            ->where(DB::raw('MONTH(rent_date)'), '=', $bulan)
            ->where(DB::raw('YEAR(rent_date)'), '=', $tahun)
            ->get();

            $pdf = PDF::loadView('pdf.report',compact('report','tahun','sum','bulan'))->setPaper('a4');
        }
        return $pdf->stream("Laporan Transaksi.pdf");
    }

    public function downloadPdfInvoices($tahun, $bulan){
        if ($bulan=="all") {
            $report = DB::table('rent')
            ->leftJoin('invoice', 'rent.id_invoice', '=', 'invoice.id_invoice')
            ->leftJoin('product', 'rent.id_product', '=', 'product.id_product')
            ->select('invoice.rent_date', 'invoice.cust_name', 'invoice.id_invoice', 'invoice.total_price','invoice.address', 'invoice.type','rent.prod_quantity', 'product.name')
            ->where(DB::raw('YEAR(rent_date)'), '=', $tahun)
            ->get();

            $sum = DB::table('rent')
            ->leftJoin('invoice', 'rent.id_invoice', '=', 'invoice.id_invoice')
            ->leftJoin('product', 'rent.id_product', '=', 'product.id_product')
            ->select('invoice.id_invoice', DB::raw('count(invoice.id_invoice) as sum_invoice'))
            ->groupBy('invoice.id_invoice')
            ->where(DB::raw('YEAR(rent_date)'), '=', $tahun)
            ->get();

            $pdf = PDF::loadView('pdf.report',compact('report','tahun','sum'))->setPaper('a4');

        }
        else{
            $report = DB::table('rent')
            ->leftJoin('invoice', 'rent.id_invoice', '=', 'invoice.id_invoice')
            ->leftJoin('product', 'rent.id_product', '=', 'product.id_product')
            ->select('invoice.rent_date', 'invoice.cust_name', 'invoice.id_invoice', 'invoice.total_price','invoice.address','invoice.type','rent.prod_quantity', 'product.name')
            ->where(DB::raw('MONTH(rent_date)'), '=', $bulan)
            ->where(DB::raw('YEAR(rent_date)'), '=', $tahun)
            ->get();

            $sum = DB::table('rent')
            ->leftJoin('invoice', 'rent.id_invoice', '=', 'invoice.id_invoice')
            ->leftJoin('product', 'rent.id_product', '=', 'product.id_product')
            ->select('invoice.id_invoice', DB::raw('count(invoice.id_invoice) as sum_invoice'))
            ->groupBy('invoice.id_invoice')
            ->where(DB::raw('MONTH(rent_date)'), '=', $bulan)
            ->where(DB::raw('YEAR(rent_date)'), '=', $tahun)
            ->get();

            $pdf = PDF::loadView('pdf.report',compact('report','tahun','sum','bulan'))->setPaper('a4');
        }

        return $pdf->download("Laporan Peminjaman bulan $bulan $tahun.pdf");
    }

    public function getPdfInvoice($id){
      $invoice = Invoice::find($id);
      $rents = Rent::where('id_invoice', $id)->get();
      $type = $invoice->type;

      $pdf = PDF::loadView('pdf.invoice', compact('invoice', 'rents', 'type'))->setPaper('a5');
      return $pdf->stream("Invoice $id.pdf");
    }

    public function getPdfInvoicePelunasan($id){
      $invoice = Invoice::find($id);
      $type = $invoice->type;
      $rents = Rent::where('id_invoice', $invoice->ref_id)->get();
      $pdf = PDF::loadView('pdf.invoice', ['invoice' => $invoice, 'rents' => $rents,  'type' => $type, 'new' => 1])->setPaper('a5');
      return $pdf->stream("Invoice Pelunasan sewa $id.pdf");
    }

    public function getPdfInvoicePelunasanJual($id){
      $invoice = Invoice::find($id);
      $type = $invoice->type;
      $rents = Rent::where('id_invoice', $invoice->ref_id)->get();
      $pdf = PDF::loadView('pdf.invoice', ['invoice' => $invoice, 'rents' => $rents,  'type' => $type, 'new' => 1])->setPaper('a5');
      return $pdf->stream("Invoice Pelunasan sewa $id.pdf");
    }

    public function downloadPdfInvoice($id){
      $invoice = Invoice::find($id);
      $rents = Rent::where('id_invoice', $id)->get();
      $type = $invoice->type;

      $pdf = PDF::loadView('pdf.invoice', compact('invoice', 'rents', 'type'))->setPaper('a5');
      return $pdf->download("Nota $invoice->description.pdf");
    }

    public function downloadPdfInvoicePelunasan($id){
      $invoice = Invoice::find($id);
      $type = $invoice->type;
      $rents = Rent::where('id_invoice', $invoice->ref_id)->get();
      $pdf = PDF::loadView('pdf.invoice', ['invoice' => $invoice, 'rents' => $rents,  'type' => $type, 'new' => 1])->setPaper('a5');
      return $pdf->download("Nota $invoice->description.pdf");
    }

    public function downloadPdfInvoicePelunasanJual($id){
      $invoice = Invoice::find($id);
      $type = $invoice->type;
      $rents = Rent::where('id_invoice', $invoice->ref_id)->get();
      $pdf = PDF::loadView('pdf.invoice', ['invoice' => $invoice, 'rents' => $rents,  'type' => $type, 'new' => 1])->setPaper('a5');
      return $pdf->download("Nota $invoice->description.pdf");
    }

}
