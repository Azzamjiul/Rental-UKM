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
            </style>
  
            <div style="font-family:Arial; font-size:12px;">
                <center><h2>Buku Besar HISTORIS TRANSAKSI<br>
                    <?php if(isset($bulan)){ echo date('F', mktime(0, 0, 0, $bulan, 10)); } ?> {{$tahun}}
                </h2></center>  
            </div>
            <br>
            <table class="tg">
              <tr>
                <th class="tg-3wr7">Nama<br></th>
                <th class="tg-3wr7">Alamat<br></th>
                <th class="tg-3wr7">Tanggal Pesanan<br></th>
                <th class="tg-3wr7">Macam/Jumlah Pesanan<br></th>
                <th class="tg-3wr7">Total<br></th>                
              </tr>
              <?php $index=0; ?>
              @for($i=0 ; $i < count($sum) ; $i++)
              <?php $temp=$index; ?>
              <tr>
                <td class="tg-rv4w uppercase" width="15%" align="center">{{ $report[$temp]->cust_name }}</td>
                <td class="tg-rv4w uppercase" width="30%" align="center">{{ $report[$temp]->address }}</td>
                <td class="tg-rv4w" width="15%">{{ Carbon\Carbon::parse($report[$temp]->rent_date)->format('d M Y') }}</td>
                <td class="tg-rv4w uppercase" width="25%">
                  @for($j=0 ; $j < $sum[$i]->sum_invoice ; $j++)
                    - {{$report[$index]->name}} / {{$report[$index++]->prod_quantity}} <br>
                  @endfor
                </td>
                <td class="tg-rv4w" width="15%" align="right">{{ $report[$temp]->total_price }} </td>
              </tr>
              @endfor
            </table>
        </body>
    </head>
</html>
SELECT invoice.id_invoice, COUNT(invoice.id_invoice)
FROM invoice
LEFt JOIN rent ON invoice.id_invoice = rent.id_invoice
group by invoice.id_invoice;