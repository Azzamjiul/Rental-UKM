@extends('layouts.main')

@section('style')
  <style media="screen">
    .uppercase::first-letter {
        text-transform: capitalize;
    }
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
      Berikut adalah list barang yang terdaftar di sistem.<br>
      Untuk <strong>edit</strong> klik tombol warna oren.<br>
      Untuk <strong>hapus</strong> klik tombol warna merah.
    </div>
  </div>
  <section class="list-produk">
    <div class="container-fluid">
      <form class="card card-sm" autocomplete="off">
         <div class="card-body row no-gutters align-items-center">
            <div class="col">
             <input class="form-control form-control-lg form-control-borderless" type="search" placeholder="Cari barang . . ." name="keywords" required>
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
          <div class="col-sm-4 col-md-3 my-3">
            <div class="card card h-100">
              <div class="card-body">
              <h5 class="card-title uppercase">{{$p->name}}</h5>
<!--                 <h5 style="">{{$p->name}}</h5> -->
                <p class="card-text uppercase">
                  {{-- kalo deskripsinya panjang dikasi ... --}}
                  @php
                  if(strlen($p->description) > 40){
                    echo $string = substr($p->description, 0, 40) . "...";
                  }else {
                    echo $p->description;
                  }
                  @endphp
                </p>
                <small>Rp. {{$p->price}}</small>
                 <br><small>
                  Sisa stok: {{$p->quantity - $p->on_rent}}/{{$p->quantity}}
                </small><br>
                <small>Tipe barang: {{$p->type}}</small>
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
        <h5 class="modal-title titleMod">Barang baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" autocomplete="off" id="productForm">
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="" id="method">
          <input type="hidden" name="id_product" value="" id="id_product">
          <div class="form-group">
            <label for="product_name">Nama barang</label>
            <input type="text" class="form-control" required id="product_name" placeholder="Nama produk" name="product_name">
          </div>
          <div class="form-group">
            <label for="product_description">Keterangan barang</label>
            <textarea class="form-control" id="product_description" required placeholder="Keterangan barang" name="product_description"></textarea>
          </div>
          <div class="form-group" id="type_field">
            <label for="type">Tipe barang</label><br>
            <select class="" name="type" id="type">
              <option value="jual">Jual</option>
              <option value="sewa">Sewa</option>
            </select>
          </div>
          <div class="form-group">
            <label for="product_price">Harga jual/ sewa</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">Rp</div>
              </div>
              <input type="text" class="form-control angka" id="product_price" required placeholder="Harga sewa" name="product_price">
            </div>
          </div>
          <div class="form-group">
            <label for="product_quantity">Kuantitas</label>
            <input type="number" class="form-control" id="product_quantity" required placeholder="Jumlah barang" min="0" name="product_quantity">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  (function(b){var c={allowFloat:false,allowNegative:false};b.fn.numericInput=function(e){var f=b.extend({},c,e);var d=f.allowFloat;var g=f.allowNegative;this.keypress(function(j){var i=j.which;var h=b(this).val();if(i>0&&(i<48||i>57)){if(d==true&&i==46){if(g==true&&a(this)==0&&h.charAt(0)=="-"){return false}if(h.match(/[.]/)){return false}}else{if(g==true&&i==45){if(h.charAt(0)=="-"){return false}if(a(this)!=0){return false}}else{if(i==8){return true}else{return false}}}}else{if(i>0&&(i>=48&&i<=57)){if(g==true&&h.charAt(0)=="-"&&a(this)==0){return false}}}});return this};function a(d){if(d.selectionStart){return d.selectionStart}else{if(document.selection){d.focus();var f=document.selection.createRange();if(f==null){return 0}var e=d.createTextRange(),g=e.duplicate();e.moveToBookmark(f.getBookmark());g.setEndPoint("EndToStart",e);return g.text.length}}return 0}}(jQuery));

  $(function() {
     $(".angka").numericInput({ allowFloat: true, allowNegative: false });
  });

  $("#inventaris").addClass("active");

  $("#new_product").click( function() {
    $('input[name=product_name]').val('');
    $('input[name=product_price]').val('');
    $('input[name=product_quantity]').val('');
    $('textarea[name=product_description]').val('');
    $("#type_field").css('display', 'block');
    $('#productForm').attr('action', '{{route('add.new.product')}}');
    $(".modal.product").modal('show');
    $('form #method').val('POST');
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
    $("#type_field").css('display', 'none');
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
        $("#type").val(data.type);
        $(".modal.product").modal('show');
        $("input#id_product").val(data.id_product)
        $('#productForm').attr('action', '{{route('update.product')}}');
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
