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
      <strong>Cek Barang</strong> untuk mengecek ketersediaan barang saat akan melayani penyewaan.<br>
      harap mengecek ketersediaan barang sebelum ke menu transaksi!<br>
      list hanya untuk produk yang disewakan!
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
            <label for="">Tanggal awal: </label>
            <input type="date" class="form-control" id="cek_tanggal1" required name="cek_tanggal">
            <label for="">Tanggal akhir: </label>
            <input type="date" class="form-control" id="cek_tanggal2" required name="cek_tanggal">
            <a name="tanggal" href="" role="button" class="btn" id="tanggal"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){

    $("#check").addClass("active");


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
        document.getElementById("cek_tanggal1").setAttribute("min", today);
        document.getElementById("cek_tanggal2").setAttribute("min", today);

  });

    $(document).on('click', '#tanggal', function(){
      if (!$('#cek_tanggal1').val().length) {
        alert("Tanggal tidak boleh kosong!")
        return false;
      }
      if (!$('#cek_tanggal2').val().length) {
        alert("Tanggal tidak boleh kosong!")
        return false;
      }
      var url2 = '{{url('/cek/inventaris/list')}}/' + $('#cek_tanggal1').val() +"/" +$('#cek_tanggal2').val();
      $("#tanggal").attr('href', url2);
    });

</script>
@endsection
