@extends('layouts.main')

@section('style')

@endsection


@section('content')
  <header class="page-header mb-3">
    <div class="container-fluid">
      <h2>Pengembalian Barang</h2>
    </div>

  </header>

<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <table  class="table table-striped">
        <thead>
          <th>No</th>

          <th>ID Nota</th>
          <th>Tanggal Peminjaman</th>
          <th>Tanggal Pengembalian</th>
          <th>Nama Penyewa</th>
          <th>NO HP Penyewa</th>
          <th>Aksi</th>
        </thead>
        <tbody>
          <tr>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="modal info fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Barang yang dipinjam</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul id="list-products">

        </ul>
        <strong id="status"></strong>
      </div>
    </div>
  </div>
</div>

<div class="modal invoice fade" tabindex="-1" role="dialog">
<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content ">
    <div class="modal-header">
      <h5 class="modal-title">Barang yang dipinjam</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <h3>Transaksi Pemesanan Berhasil!</h3>
      <a href="#" class="btn btn-success see-invoice" target="_blank">Klik untuk melihat nota!</a>
    </div>
  </div>
</div>
</div>
</div>
@endsection


@section('script')
<script type="text/javascript">

$(document).ready(function(){

    table1 = $('table').DataTable({
    stateSave: true,
    responsive: true,
    language: {
      searchPlaceholder: "Cari data"
    },
    ajax: "{{route('on.rent.invoices')}}",
    columns:[
      {
        render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {data: 'id_invoice'},
      {data: 'rent_date', render: function(data, type, row){
        var options = {year: 'numeric', month: 'long', day: 'numeric' };
        var today  = new Date(data);
        return today.toLocaleDateString("id", options);
        }},
      {data: 'deadline_date', render: function(data, type, row){
        var options = {year: 'numeric', month: 'long', day: 'numeric' };
        var today  = new Date(data);
        return today.toLocaleDateString("id", options);
        }},
      {data: 'cust_name'},
      {data: 'cust_phone'},
      {render: function(data, type, row){
        button = '';
        button2 = '';
        lunas = 'belum'
        barang_sudah_kembali = '';
        if (row.dp == row.total_price) {
          button2 = 'disabled'
        }
        if (row.status == 1) {
          button = 'disabled'
          lunas = 'sudah'
        }
        if (row.status == 2) {
          barang_sudah_kembali = 'disabled';
        }
        return '<button type="button"name="button" class="btn btn-info mr-1 see" id-invoice='+row.id_invoice+'>Info</button><button type="button" name="button" '+barang_sudah_kembali+' class="btn btn-success return mr-1" id-invoice='+row.id_invoice+'>Kembalikan Barang</button><button type="button" name="button" class="btn btn-primary mr-1 pay" '+button2+' '+button+' id-invoice='+row.id_invoice+' lunas='+lunas+'>Lunaskan</button>';
      }}
    ]
    });

    //cari barang yang dipinjam
    $(document).on('click', '.see', function(){
      html_content = '';
      id_invoice = $(this).attr('id-invoice');
      console.log("see")
      $.ajax({
        url: '{{route('get.items.on.rent')}}',
        data: {id_invoice},
        success: data => {
          console.log(data)

          for (var i = 0; i < data[0].length; i++) {
            html_content += "<li>"+ data[0][i].prod_quantity +"x " +data[0][i].product.name+"</li>";
          }
          if (data.lunas == 1) {
            $("#status").text("LUNAS")
          }else {
            var	reverse = (data[1].total_price-data[1].dp).toString().split('').reverse().join(''),
              ribuan 	= reverse.match(/\d{1,3}/g);
              ribuan	= ribuan.join('.').split('').reverse().join('');
            $("#status").text("BELUM LUNAS | SISA Rp " + ribuan)

          }
          $("#list-products").html(html_content);
          $(".modal.info").modal('show')

        },
        error: data => {
          console.log(data)
        }
      })

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.return', function(){
      id_invoice = $(this).attr('id-invoice');
      alertify.confirm('Warning', "Mohon untuk mengecek kelengkapan barang. Apa sudah lengkap?",
        function(){
          $.ajax({
            url: "{{route('return.products')}}",
            method: "PUT",
            data: {id_invoice},
            success: data => {
              alertify.success("Barang berhasil dikembalikan!")
              table1.ajax.reload( null, false )
            },
            error: data => {
              alert("Server Error");
              console.log(data)
            }
          });
        },
        function(){
      });
    });

    $(document).on('click', '.pay', function(){
      id_invoice = $(this).attr('id-invoice');

      $.ajax({
        url: '{{route('pay.fully')}}',
        data: {id_invoice},
        method: "PUT",
        success: data => {
          table1.ajax.reload( null, false )
          var url = '{{url('/lihat/nota-baru')}}/' + data.invoice.id_invoice;
          $(".see-invoice").attr('href', url);
          $(".invoice").modal('show');
        },
        error: data => {
          console.log(data);
          alert("Server Error")
        }
      })
    })

});

</script>
@endsection
