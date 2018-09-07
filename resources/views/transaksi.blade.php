@extends('layouts.main')

@section('style')
<style media="screen">
  .card.in-cart-product{
    margin-bottom: 0;
    border-bottom: 1px solid #eef5f9;
  }
  .card:hover{
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08);
  }
</style>
@endsection

@section('content')
<header class="page-header mb-3">
  <div class="container-fluid">
    <h2>Transaksi Sewa</h2>
  </div>

</header>

<section class="point-of-sale">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-7">
        <h3>Pilihan Barang</h3>
        <div class="card">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">NAMA</th>
                <th scope="col">HARGA</th>
                <th scope="col">STOK</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $p)
                <tr>
                  <td id="product-name-id-{{$p->id_product}}">{{$p->name}}</td>
                  <td id="product-price-id-{{$p->id_product}}">Rp {{$p->price}}</td>
                  <td id="product-quantity-id-{{$p->id_product}}">{{$p->quantity - $p->on_rent}}</td>
                  <td>
                    <input type="number" name="" value="1" min="1" max="{{$p->quantity - $p->on_rent}}" id="product-chosen-id-{{$p->id_product}}">
                    <button type="submit" name="button" class="btn add-to-cart" product-id={{$p->id_product}}><i class="fa fa-shopping-cart" aria-hidden="true"></i></button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
      <div class="col-md-5">
        <h3>Keranjang</h3>
        <div class="cart">
          <div class="card">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">NAMA BARANG</th>
                  <th scope="col">JUMLAH BARANG</th>
                </tr>
              </thead>
              <tbody>





              </tbody>
            </table>
            <div class="card-body">
              <h4 id="total_price">Total: Rp 0</h4>
              <hr>
                <form id="myForm">
                  <div class="form-group">
                    <label for="nama_penyewa">Nama penyewa</label>
                    <input type="text" class="form-control" id="nama_penyewa" placeholder="Nama penyewa" required name="cust_name">
                  </div>
                  <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control" id="address" placeholder="Alamat penyewa" name="address" required></textarea>
                  </div>
                  <div class="form-group">
                    <label for="address">No. Telepon</label>
                    <textarea class="form-control" id="cust_phone" placeholder="No. Telepon" name="cust_phone" required></textarea>
                  </div>
                  <div class="form-group">
                    <label for="start_date">Terhitung mulai</label>
                    <input type="date" class="form-control" id="start_date" required name="start_date">
                  </div>
                  <div class="form-group">
                    <label for="end_date">Terhitung sampai</label>
                    <input type="date" class="form-control" id="end_date" required name="end_date">
                  </div>
                  <div class="form-group">
                    <label for="dp">Uang muka</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Rp</div>
                      </div>
                      <input type="text" class="form-control" id="dp" placeholder="Uang muka" name="dp">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="cash">Tunai</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Rp</div>
                      </div>
                      <input type="text" class="form-control" id="cash" placeholder="Tunai" required name="cash">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="discount">Diskon</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Rp</div>
                      </div>
                      <input type="text" class="form-control" id="discount" placeholder="Opsional" name="discount">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="product_description">Keterangan</label>
                    <textarea class="form-control" id="product_description" placeholder="Opsional" name="product_description"></textarea>
                  </div>

                <button class="btn btn-primary" type="submit" name="button">Lanjutkan</button>

                <input type="hidden" name="total_price_hidden" value="" id="total_price_hidden">
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="container-fluid">
  <div class="modal fade after-transaction" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
  </div>
</div>

</div>


@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){

    var selected_products = [];
    var selected_products_objects = [];

    function Product(){
      this.name= '';
      this.id_product= '';
      this.price = '';
      this.chose = 0;
    }

    // var product = {
    //   id_product: '',
    //   price: '',
    //   chose: 0
    // };

    var total_price = 0;

    function searchProducts(id_prod, quantity){
      for (var i = 0; i < selected_products_objects.length; i++) {
        if (selected_products_objects[i].id_product == id_prod) {
          selected_products_objects[i].chose += quantity;
          return;
          // return selected_products_objects;
        }
      }
    }

    $(".add-to-cart").click(function(){
      id_product = $(this).attr('product-id');
      quantity = $("#product-quantity-id-" + id_product).text();
      quantity_chosen = $("#product-chosen-id-" + id_product).val();
      product_name = $("#product-name-id-" + id_product).text();

      if (parseInt(quantity_chosen) > $("#product-chosen-id-" + id_product).attr('max')) {
        // console.log("max is " + $("#product-chosen-id-" + id_product).attr('max'))
        return false;
      }

      product_name =  $("#product-name-id-" + id_product).text()

      $("#product-quantity-id-" + id_product).text(parseInt(quantity) - parseInt(quantity_chosen));
      $("#product-chosen-id-" + id_product).attr('max', parseInt(quantity) - parseInt(quantity_chosen));

      price = parseInt($("#product-price-id-" + id_product).text().slice(2)) * parseInt(quantity_chosen);
      total_price+=price;

      //cek udah ada di cart belum?
      if (selected_products.includes(id_product)) {
        // console.log("1")
        searchProducts(id_product, parseInt(quantity_chosen));
        // product.chose += parseInt(quantity_chosen);
        incart_quantity = $("#in-cart-quantity-product-"+id_product).text();
        $("#in-cart-quantity-product-"+id_product).text(parseInt(incart_quantity) + parseInt(quantity_chosen));
        console.log("udah pernah")
      }else {
        selected_products.push(id_product);

        product = new Product();
        product.id_product = id_product;
        product.name = product_name;
        product.chose += parseInt(quantity_chosen);
        product.price = $("#product-price-id-" + id_product).text().slice(2);
        selected_products_objects.push(product);
        // console.log("quantity chosen ", quantity_chosen)

        html = '<tr>'+
          '<td>'+product_name+'</td>'+
          '<td id="in-cart-quantity-product-'+id_product+'">'+quantity_chosen+'</td>'+
        '</tr>';

        $(".cart tbody").append(html);

      }
      var	reverse = total_price.toString().split('').reverse().join(''),
      	ribuan 	= reverse.match(/\d{1,3}/g);
      	ribuan	= ribuan.join('.').split('').reverse().join('');

      $("#product-chosen-id-" + id_product).val(1)
      $("#total_price").text("Total: Rp " + ribuan);
      $("#total_price_hidden").val(total_price);
      console.log(selected_products_objects);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("form").submit(e => {
      e.preventDefault();
      //cek bayar uang muka
      var myForm = document.getElementById('myForm');
      formData = new FormData(myForm);

      formData.append('products', JSON.stringify(selected_products_objects));

      $.ajax({
          url: '{{route('new.transaction')}}',
          method: "POST",
          processData: false,
          contentType: false,
          data: formData,
          dataType: 'JSON',
          success: data => {
              if (data.message == "success") {
                $(".after-transaction").modal('show');
              }
          },
          error: data => {

          }
      });

    });



  });
</script>
@endsection
