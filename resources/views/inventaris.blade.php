@extends('layouts.main')

@section('style')
  <style media="screen">
    .list-produk .card:hover{
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08);
    }
  </style>
@endsection

@section('content')
  <header class="page-header">
    <div class="container-fluid">
      <h2 class="no-margin-bottom">Inventaris</h2>
    </div>
  </header>

  <section class="list-produk">
    <div class="container-fluid">
      <form class="card card-sm">
         <div class="card-body row no-gutters align-items-center">
            <div class="col">
             <input class="form-control form-control-lg form-control-borderless" type="search" placeholder="Cari barang . . .">
            </div>
            <div class="col-auto">
              <button class="btn btn-lg btn-success" type="submit">Search</button>
            </div>
         </div>
       </form>
      <div class="row">
        @for ($i = 0; $i < 10; $i++)
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                hello
              </div>
              <div class="card-footer">
                Rp 5000
              </div>
            </div>
          </div>
        @endfor
      </div>

    </div>
  </section>
@endsection
