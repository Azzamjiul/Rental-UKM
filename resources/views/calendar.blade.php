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
      <div class="col-12 col-md-8">
<!--         <div class="table-responsive"> -->
          <div id="calendar"></div>
<!--         </div> -->
      </div>
    </div>
  </div>
    <div class="modal fade" id="events-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
<script src="{{asset('vendor/bower-components/underscore/underscore-min.js')}}"></script>
<script src="{{asset('vendor/bower-components/bootstrap-calendar/js/language/id-ID.js')}}"></script>
<script src="{{asset('vendor/bower-components/bootstrap-calendar/js/calendar.js')}}"></script>
<script type="text/javascript">
  var calendar = $('#calendar').calendar({
    tmpl_path: "/rental-ukm/public/vendor/bower-components/bootstrap-calendar/tmpls/",
    events_source: "{{route('get.calendar.events')}}",
    modal : "#events-modal", 
    modal_type : "ajax", 
    modal_title : function (e) { 
      return e.title 
    },
  });


  $(document).ready(function(){


  });

    $(document).on('click', '#tanggal', function(){

    });

</script>
@endsection
