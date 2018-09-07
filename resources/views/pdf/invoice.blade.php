<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
      .container{
        width: 50%;
      }

      p strong{
        font-size: 28px;
      }
      table.barang, th.barang, td.barang {
          border: 1px solid black;
          border-collapse: collapse;
      }
      .title{
        border-bottom: 1px solid black;
        border-left: 1px solid black;

      }
      th.barang, td.barang {
          padding: 15px;
          text-align: left;
      }

      .footer td, .footer th{
        padding-left: 15px;
        text-align: left;
        }

        td.kosong{
          background-color: grey;
        }

        body{
          justify-content: center;
          text-align: center;
        }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="header">
        <div class="col-1">
          <p>
            <strong>Arta</strong> Kesempurnaan Moment Anda <br>
            <hr>
            JL. PANDU DESA KAUMAN (DEPAN BALAI DESA) <br>
            KEC. KARANGREJO KAB. MAGETAN <br>
            (0351) 867170 | 085 790 367 773
            <hr>
          </p>
        </div>
      </div>
      <div class="body">
        ID NOTA: {{$invoice->id_invoice}}<br>
        {{date_format(date_create($invoice->invoice_date), 'd-m-Y H:i')}}
         <table class="barang" style="width: 100%">
          <thead>
            <th class="barang">BANYAK-NYA</th>
            <th class="barang">NAMA BARANG</th>
            <th class="barang">HARGA</th>
            <th class="barang">JUMLAH</th>
          </thead>
          <tbody>
            @foreach ($rents as $p)
              <tr>
                <td class="barang">{{$p->prod_quantity}}</td>
                <td class="barang">{{$p->product->name}}</td>
                <td class="barang">Rp {{$p->sum_price / $p->prod_quantity}}</td>
                <td class="barang">Rp {{$p->sum_price}}</td>

              </tr>
            @endforeach

            <tr>
              <tr>
                <td class="kosong"></td>
                <td class="kosong"></td>

                <td class="kosong"></td>
                <td class="kosong"></td>

              </tr>
            </tr>
            <tr>
              <td class=""></td>
              <td class=""></td>
              <td class="title" style="text-align: center"><strong>TOTAL HARGA</strong></td>
              <td class="barang">Rp {{$invoice->total_price}}</td>

            </tr>
            <tr>
              <td class=""></td>
              <td class=""></td>
              <td class="title" style="text-align: center"><strong>UANG MUKA</strong></td>
              <td class="barang">
                @php
                  if ($invoice->dp == $invoice->total_price)
                    echo "LUNAS";
                  else
                    echo $invoice->dp;

                @endphp

              </td>
            </tr>
            <tr>
              <td class=""></td>
              <td class=""></td>
              <td class="title" style="text-align: center"><strong>SISA</strong></td>
              <td class="barang">
                @php
                  if ($invoice->dp == $invoice->total_price) {
                    echo "LUNAS";
                  }else {
                    echo $invoice->total_price - $invoice->dp;
                  }
                @endphp

              </td>
            </tr>

          </tbody>
        </table>


      </div>
      <br>
      <div class="footer">

        <table class="" style="width: 100%">
          <thead>
            <th></th>
            <th></th>
          </thead>
          <tbody>
            <tr>
              <td>TERHITUNG MULAI: {{date_format(date_create($invoice->rent_date), 'd/m/Y')}}</td>
              <td>TERHITUNG SAMPAI: {{date_format(date_create($invoice->deadline_date), 'd/m/Y')}}</td>
            </tr>
            <tr>
            <td>{{$invoice->cust_name}}
              <br>PENYEWA</td>
            <td>Kauman, {{date_format(date_create($invoice->invoice_date), 'd-m-Y')}}</td>

            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
