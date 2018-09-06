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
                <center><h2>Buku Besar HISTORIS TRANSAKSI</h2></center>  
            </div>
            <br>
            <table class="tg">
              <tr>
                <th class="tg-3wr7">Nama<br></th>
                <th class="tg-3wr7">Alamat<br></th>
                <th class="tg-3wr7">Tanggal Pesanan<br></th>
                <th class="tg-3wr7">Macam/Jumlah Pesanan<br></th>
                <th class="tg-3wr7">Keterangan<br></th>
              </tr>
              @foreach ($report as $u)
              <tr>
                <td class="tg-rv4w" width="15%" align="center">{{ $u->cust_name }}</td>
                <td class="tg-rv4w" width="15%" align="center">{{ $u->address }}</td>
                <td class="tg-rv4w" width="15%">{{ $u->rent_date }}</td>
                <td class="tg-rv4w" width="15%" align="right">Rp.{{ $u->price }} ,-</td>
              </tr>
              @endforeach
            </table>
        </body>
    </head>
</html>