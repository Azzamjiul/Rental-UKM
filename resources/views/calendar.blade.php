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
      <h2>Cek Kalender
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
      <strong>Cek Kalender</strong> untuk melihat dan sebagai <strong>reminder</strong> tentang batas akhir peminjaman.<br>
    </div>
  </div>
  <br>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">

        <div class="row justify-content-center">
          <div class="col-3" align="center">
              <button type="button" id="navPrev" class="btn btn-info">Sebelumnya</button>
          </div>
          <div class="col-6" align="center">
            <h2 id="nameMonth"></h2>
            <h5 id="yearDate"></h5>
          </div>
          <div class="col-3" align="center">
              <button type="button" id="navNext" class="btn btn-info">Selanjutnya</button>
          </div>
        </div><br>
        {{-- <button type="button" id="navMonth" class="btn btn-warning">Back</button> --}}
        <div class="row justify-content-center">
          <div class="col-12 col-md-8">
    <!--         <div class="table-responsive"> -->
              <div id="calendar"></div>
      </div>
    </div>
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
<script src="{{asset('vendor/bower-components/bootstrap-calendar/js/calendar.js')}}"></script>
<script type="text/javascript">

  $("#calendars").addClass("active");

  var calendar = $('#calendar').calendar({
    tmpl_path:"{{asset('vendor/bower-components/bootstrap-calendar/tmpls')}}"+"/",
    events_source: "{{route('get.calendar.events')}}",
    modal : "#events-modal",
    modal_type : "iframe",
    modal_title: function(event) {
      return "Rincian";
    }
  });

  var d = new Date();
  var n = d.getMonth();
  var temp = d.getMonth();
  var temp2 = d.getFullYear();
  var y = d.getFullYear();

  const monthNames = ["JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI",
    "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"
  ];

  $("#nameMonth").html(monthNames[n]);
  $("#yearDate").html(y);

  $(document).on('click', '#navMonth', function(){
    calendar.view('month');
  });

  $(document).on('click', '#navPrev', function(){
    if (n-1<temp && y == temp2) {
      return;
    }
    if (n==0) {
      n=11;
      y=y-1;
      $("#yearDate").html(y);
    }
    else{
      n=n-1;
    }
    $("#nameMonth").html(monthNames[n]);

    calendar.navigate('prev');
  });

  $(document).on('click', '#navNext', function(){
    if (n==11) {
      n=0;
      y=y+1;
      $("#yearDate").html(y);
    }
    else{
      n=n+1;
    }
    $("#nameMonth").html(monthNames[n]);
    calendar.navigate('next');
  });

</script>
@endsection
