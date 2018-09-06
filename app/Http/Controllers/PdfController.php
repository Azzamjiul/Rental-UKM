<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Kas;
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
		    return $pdf->stream();
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
		    $report = Invoice::where(DB::raw('YEAR(date)'), '=', $tahun)->get();
		    $pdf = PDF::loadView('pdf.report',compact('report','tahun'))->setPaper('a4');
    	}
    	else{
		    $report = Invoice::where(DB::raw('MONTH(date)'), '=', $bulan)->where(DB::raw('YEAR(date)'), '=', $tahun)->get();
		    $pdf = PDF::loadView('pdf.report',compact('report','bulan','tahun'))->setPaper('a4');
    	}	
	    return $pdf->stream();
	}

    public function downloadPdfInvoices($tahun, $bulan){
    	if ($bulan=="all") {
		    $report = Invoice::where(DB::raw('YEAR(date)'), '=', $tahun)->get();
		    $pdf = PDF::loadView('pdf.report',compact('report','tahun'))->setPaper('a4');
    	}
    	else{
		    $report = Invoice::where(DB::raw('MONTH(date)'), '=', $bulan)->where(DB::raw('YEAR(date)'), '=', $tahun)->get();
		    $pdf = PDF::loadView('pdf.report',compact('report','bulan','tahun'))->setPaper('a4');
    	}
	
	    return $pdf->download("hehe.pdf");
	}

}
