@extends('layouts.main')

@section('style')
  <style media="screen">
    .card:hover{
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
      <h2>Cek ketersediaan barang
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
      <strong>Cek Barang</strong> untuk mengecek ketersediaan barang saat akan melayani peminjaman / penjualan.<br>
      harap mengecek ketersediaan barang sebelum ke menu transaksi!
    </div>
  </div>
  <br>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-10 col-md-4">
        <div class="card" id="pemasukan">
          <div class="card-body text-center">
            <h5 class="d-none d-sm-block">PILIH TANGGAL</h5>
            <h6 class="d-block d-sm-none">PILIH TANGGAL</h6>
            <input type="date" class="form-control" id="cek_tanggal" required name="cek_tanggal">
            <button name="button" class="btn"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-10 col-md-10">
        <div class="table-responsive">
          <table id="tableBarang" class="table table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Stok</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>        
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();
          if(dd<10){
            dd='0'+dd
          } 
          if(mm<10){
            mm='0'+mm
          } 

        today = yyyy+'-'+mm+'-'+dd;
        document.getElementById("cek_tanggal").setAttribute("min", today);

        var table1;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table1 = $('#tableBarang').DataTable({
        stateSave: true,
        language: {
          searchPlaceholder: "Cari barang"
        },
        ajax: "{{route('get.gods')}}",
        columns:[
            {
               "data": "id_product",
              render: function (data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            {data: "name", orderable: false},
            {render:function(data,type,row){
              return row.quantity-row.on_rent;
              }
            }
          ]
      });
  });


</script>
@endsection
