@extends('layouts.main')

@section('style')
  <style media="screen">
    .list-produk .card:hover{
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08);
    }
    .edit{
      color: orange;
    }
    .edit:hover{
      transform: scale(1.1);
    }
    .delete{
      color: red;
    }
    .delete:hover{
      transform: scale(1.1);
    }
  </style>
@endsection

@section('content')
  <header class="page-header mb-2">
    <div class="container-fluid">
      <h2>Inventaris
        <button class="btn btn-primary" type="button" name="button" style="float: right">Tambah Barang</button>
      </h2>
    </div>
  </header>

  <div class="container-fluid">
  <div class="alert alert-info">
    Berikut adalah list barang yang terdaftar di sistem.<br>
    Untuk <strong>edit</strong> klik tombol warna oren.<br>
    Untuk <strong>hapus</strong> klik tombol warna merah.
  </div>

  </div>
  <section class="list-produk">
    <div class="container-fluid">
      <form class="card card-sm">
         <div class="card-body row no-gutters align-items-center">
            <div class="col">
             <input class="form-control form-control-lg form-control-borderless" type="search" placeholder="Cari barang . . .">
            </div>
            <div class="col-auto">
              <button class="btn btn-lg btn-success" type="submit">Cari</button>
            </div>
         </div>
       </form>
      <div class="row">
        @for ($i = 0; $i < 10; $i++)
          <div class="col-sm-4 col-md-3">
            <div class="card">
              <div class="card-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <small>Rp 5000</small>
              </div>
              <div class="card-footer">
                <button type="button" name="button" class="btn"><i class="fa fa-pencil edit" aria-hidden="true"></i></button>
                <button type="button" class="btn" name="button">
                  <i class="fa fa-trash-o delete" aria-hidden="true"></i>

                </button>
              </div>
            </div>
          </div>
        @endfor
      </div>

    </div>
  </section>
@endsection

@section('script')
<script type="text/javascript">
  $("#inventaris").addClass("active")
</script>
@endsection
