<style type="text/css">
    .uppercase::first-letter {
        text-transform: capitalize;
    }
</style>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Laporan TRANSAKASI</title>
        <body>
            <style type="text/css">
                .tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;width: 100%; }
                .tg td{font-family:Arial;font-size:12px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
                .tg th{font-family:Arial;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
                .tg .tg-3wr7{font-weight:bold;font-size:12px;font-family:"Arial", Helvetica, sans-serif !important;;text-align:center}
                .tg .tg-ti5e{font-size:10px;font-family:"Arial", Helvetica, sans-serif !important;;text-align:center}
                .tg .tg-rv4w{font-size:10px;font-family:"Arial", Helvetica, sans-serif !important;}
                .container{
                  width: 100%;
                }
            </style>
            <div class="container">
              <div class="header">
                <div class="col-1">
                  <p style="text-align: center; font-size: 12px">
                    <strong>Arta</strong> Kesempurnaan Moment Anda <br>
                    <hr>
                  </p>
                  <p style="text-align: center; font-size: 10px">
                    JL. PANDU DESA KAUMAN (DEPAN BALAI DESA) <br>
                    KEC. KARANGREJO KAB. MAGETAN <br>
                    (0351) 867170 | 085 790 367 773
                    <hr>
                  </p>
                </div>
              </div>
            </div>
            <div style="font-family:Arial; font-size:12px;">
                <center><h2>Buku Besar HISTORIS TRANSAKSI<br>
                    <?php if(isset($bulan)){ echo date('F', mktime(0, 0, 0, $bulan, 10)); } ?> {{$tahun}}
                </h2></center>  
            </div>
            <br>
            <table class="tg">
              <tr>
                <th class="tg-3wr7">No<br></th>
                <th class="tg-3wr7">Nama<br></th>
                <th class="tg-3wr7">Alamat<br></th>
                <th class="tg-3wr7">Tgl Transaksi<br></th>
                <th class="tg-3wr7">Macam/Jml Barang<br></th>
                <th class="tg-3wr7">Tipe<br></th>
                <th class="tg-3wr7">Total<br></th>                
              </tr>
              <?php $no=1; $index=0;?>
              @for($i=0 ; $i < count($sum) ; $i++)
              <?php $temp=$index; ?>
              <tr>
                <td class="tg-rv4w" width="5%">{{ $no++ }}</td>
                <td class="tg-rv4w uppercase" width="15%">{{ $report[$temp]->cust_name }}</td>
                <td class="tg-rv4w uppercase" width="30%">{{ $report[$temp]->address }}</td>
                <td class="tg-rv4w" width="13%">{{ Carbon\Carbon::parse($report[$temp]->rent_date)->format('d M Y') }}</td>
                <td class="tg-rv4w uppercase" width="20%">
                  @for($j=0 ; $j < $sum[$i]->sum_invoice ; $j++)
                    - {{$report[$index]->name}} / {{$report[$index++]->prod_quantity}} <br>
                  @endfor
                </td>
                <td class="tg-rv4w" width="7%" align="left" style="text-transform: capitalize;">{{ $report[$temp]->type }} </
                <td class="tg-rv4w" width="10%" align="right">{{ $report[$temp]->total_price }} </td>
              </tr>
              @endfor
            </table>
        </body>
    </head>
</html>