@extends('layouts.main')

@section('style')
  <style media="screen">
    .list-produk .card:hover{
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08);
    }
    .big-icon {
        font-size: 32px;
    }
    .see{
      color: orange;
      background-color: #eeeceb;
    }
    .see:hover{
      transform: scale(1.1);
    }
  </style>
@endsection

@section('content')
  <header class="page-header mb-2">
    <div class="container-fluid">
      <h2>Historis
      </h2>
    </div>
  </header>

  <div class="container-fluid">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
        <p>{{session('success')}}</p>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
        <p>{{session('error')}}</p>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif


  </div>

  <div class="container-fluid">
    <div class="alert alert-info mt-4">
      <strong>Historis</strong> adalah data Peminjaman dan Penjualan.<br>
    </div>
  </div>
  <br>
  <div class="container-fluid">
    <div class="table-responsive">
      <table id="tableHistoris" class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Waktu</th>
            <th>Total</th>
            <th>Lihat</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
      (function(b){var c={allowFloat:false,allowNegative:false};b.fn.numericInput=function(e){var f=b.extend({},c,e);var d=f.allowFloat;var g=f.allowNegative;this.keypress(function(j){var i=j.which;var h=b(this).val();if(i>0&&(i<48||i>57)){if(d==true&&i==46){if(g==true&&a(this)==0&&h.charAt(0)=="-"){return false}if(h.match(/[.]/)){return false}}else{if(g==true&&i==45){if(h.charAt(0)=="-"){return false}if(a(this)!=0){return false}}else{if(i==8){return true}else{return false}}}}else{if(i>0&&(i>=48&&i<=57)){if(g==true&&h.charAt(0)=="-"&&a(this)==0){return false}}}});return this};function a(d){if(d.selectionStart){return d.selectionStart}else{if(document.selection){d.focus();var f=document.selection.createRange();if(f==null){return 0}var e=d.createTextRange(),g=e.duplicate();e.moveToBookmark(f.getBookmark());g.setEndPoint("EndToStart",e);return g.text.length}}return 0}}(jQuery));

      $(function() {
         $(".angka").numericInput({ allowFloat: true, allowNegative: false });
      });

        var table1;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table1 = $('#tableHistoris').DataTable({
        stateSave: true,
        language: {
          searchPlaceholder: "Cari data"
        },
        ajax: "{{route('get.history')}}",
        columns:[
            {
               "data": "id",
              render: function (data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            {data: "cust_name", orderable: false},
            {data: "rent_date", render: function(data, type, row){
              var options = {year: 'numeric', month: 'long', day: 'numeric' };
              var today  = new Date(data);
              return today.toLocaleDateString("id", options);
              }
            },
            {data: "total_price", className : "text-right"},
            {orderable: false, className : "text-center",render: function(data, type, row){
                return "<a class='btn btn-sm see' target='_blank' href='lihat/nota/"+row.id_invoice+"' role='button'><i class='fa fa-eye see' aria-hidden='true'></i></a>";
              }
            },
        ]
      });
  });


</script>
@endsection
