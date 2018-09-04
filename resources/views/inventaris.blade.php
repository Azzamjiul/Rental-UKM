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
        <button class="btn btn-primary" type="button" name="button" style="float: right" id="new_product">Tambah Barang</button>
      </h2>
    </div>
  </header>

  <div class="container-fluid">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p>{{session('success')}}</p>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <p>{{session('error')}}</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  </div>



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
             <input class="form-control form-control-lg form-control-borderless" type="search" placeholder="Cari barang . . ." name="keywords">
            </div>
            <div class="col-auto">
              <button class="btn btn-lg btn-success" type="submit">Cari</button>
            </div>
         </div>
       </form>
       @if (!$products->total())
         <p>Tidak ada barang.</p>
        @else
          @if ($keywords == 'empty')
            <p>Total ada {{$products->total()}} barang</p>
          @else
            <p>Barang dengan deskripsi {{$keywords}} ada {{$products->total()}}</p>
          @endif
       @endif
      <div class="row">


        @foreach ($products as $p)
          <div class="col-sm-4 col-md-3">
            <div class="card">
              <div class="card-body">
                <h5>{{$p->name}}</h5>
                <p>
                  {{-- kalo deskripsinya panjang dikasi ... --}}
                  @php
                  if(strlen($p->description) > 50){
                    echo $string = substr($p->description, 0, 50) . "...";
                  }else {
                    echo $p->description;
                  }
                  @endphp
                </p>
                <small>Rp. {{$p->price}}</small>
                 <br><small>
                  Sisa stok: {{$p->quantity - $p->on_rent}}/{{$p->quantity}}
                </small>
              </div>
              <form class="" action="{{route('delete.product')}}" method="post" id="form-id-{{$p->id_product}}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id_product" value="{{$p->id_product}}">
              </form>
              <div class="card-footer">
                <button product-id="{{$p->id_product}}" type="button" name="button" class="edit btn"><i class="fa fa-pencil edit" aria-hidden="true"></i></button>
                <button product-id="{{$p->id_product}}" class="btn delete" type="button" name="button">
                  <i class="fa fa-trash-o delete" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
{{ $products->links() }}
    </div>
  </section>

  <div class="modal product fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Barang baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="" id="method">
          <input type="hidden" name="id_product" value="" id="id_product">
          <div class="form-group">
            <label for="product_name">Nama barang</label>
            <input type="text" class="form-control" required id="product_name" placeholder="Nama produk" name="product_name">
          </div>
          <div class="form-group">
            <label for="product_description">Deskripsi barang</label>
            <textarea class="form-control" id="product_description" required placeholder="Deskripsi barang" name="product_description"></textarea>
          </div>
          <?php // TODO: dikasi regex rupiah!! ?>
          <div class="form-group">
            <label for="product_price">Harga sewa</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">Rp</div>
              </div>
              <input type="text" class="form-control" id="product_price" required placeholder="Harga sewa" name="product_price">
            </div>
          </div>
          <div class="form-group">
            <label for="product_quantity">Kuantitas</label>
            <input type="number" class="form-control" id="product_quantity" required placeholder="Jumlah barang" min="0" name="product_quantity">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $("#inventaris").addClass("active");

  $("#new_product").click( function() {
    $('form').attr('action', '{{route('add.new.product')}}');
    $(".modal.product").modal('show');
  });

  $(".delete").click( function() {
    id_product = $(this).attr('product-id');
    console.log(id_product)
    alertify.confirm('Warning', "Anda yakin akan menghapus barang ini?",
      function(){
        $("#form-id-" + id_product).submit();
      },
      function(){
    });
  })

  //fetch data produk ketika mau edit
  $(".edit").click( function(){
    id_product = $(this).attr('product-id');
    $.ajax({
      url: '{{route('find.product')}}',
      dataType: 'json',
      method: 'get',
      data:{id_product},
      success: data => {
        $("#product_name").val(data.name);
        $("#product_price").val(data.price);
        $("#product_description").val(data.description);
        $("#product_quantity").val(data.quantity);
        $(".modal.product").modal('show');
        $("input#id_product").val(data.id_product)
        $('form').attr('action', '{{route('update.product')}}');
        $('form #method').val('PUT');
      },
      error: data => {
        newData = JSON.parse(data.responseText)
        alert(newData.message + ", file: " + newData.file
        + ", line: " + newData.line);
      }
    });
  });


</script>
@endsection
