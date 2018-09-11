<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">

    body{
      font-size: 11px;
    }
      .container{
        width: 100%;
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
          <tr>
            <th class="barang">BANYAK-NYA</th>
            <th class="barang">NAMA BARANG</th>
            <th class="barang">HARGA</th>
            <th class="barang">JUMLAH</th>
          </tr>
          <tbody>
            @foreach ($rents as $p)
              <tr>
                <td class="barang">{{$p->prod_quantity}}</td>
                <td class="barang">{{$p->product->name}}</td>
                <td class="barang">Rp {{number_format(($p->sum_price / $p->prod_quantity),2,',','.')}}</td>
                <td class="barang">Rp {{number_format(($p->sum_price),2,',','.')}}</td>

              </tr>
            @endforeach

              <tr>
                <td class="kosong"></td>
                <td class="kosong"></td>

                <td class="kosong"></td>
                <td class="kosong"></td>

              </tr>
              <tr>
                <td class=""> Keterangan: {{$invoice->description}}</td>
                <td class=""></td>
                <td class="title" style="text-align: center"><strong>DISKON</strong></td>
                <td class="barang">
                  @php
                    if ($invoice->discount != 0) {
                      echo "Rp ".number_format(($invoice->discount),2,',','.');
                    }
                    else {
                      echo "-";
                    }
                  @endphp

                </td>
              </tr>

            <tr>
              <td class=""></td>
              <td class=""></td>
              <td class="title" style="text-align: center"><strong>TOTAL HARGA</strong></td>
              <td class="barang">Rp {{number_format(($invoice->total_price),2,',','.')}}</td>

            </tr>
            <tr>
              <td class=""></td>
              <td class=""></td>
              <td class="title" style="text-align: center"><strong>UANG MUKA</strong></td>
              <td class="barang">
                @php
                if (!isset($new)) {
                  if ($invoice->dp == $invoice->total_price)
                    echo "LUNAS";
                  else
                    echo "Rp ".number_format(($invoice->dp),2,',','.');
                }          
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
                    echo "Rp ".  number_format(($invoice->total_price - $invoice->dp),2,',','.');
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
          <tr>
            <th></th>
            <th></th>
          </tr>
          <tbody>
            @if ($type == 'sewa')
              @if (!isset($new))
                <tr>
                  <td>TERHITUNG MULAI: {{date_format(date_create($invoice->rent_date), 'd/m/Y')}}</td>
                  <td>TERHITUNG SAMPAI: {{date_format(date_create($invoice->deadline_date), 'd/m/Y')}}</td>
                </tr>
              @endif
            @endif

            <tr>
            <td>{{$invoice->cust_name}}
              <br><br>Penyewa </td>
            <td><br><br>Kauman, {{date_format(date_create($invoice->invoice_date), 'd-m-Y')}}</td>

            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
