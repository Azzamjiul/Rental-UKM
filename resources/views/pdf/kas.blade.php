<style type="text/css">
    .uppercase::first-letter {
        text-transform: capitalize;
    }
</style>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Laporan KAS</title>
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
                <center><h2>Buku Besar Pemasukan dan Pengeluaran<br>
                  <?php if(isset($bulan)){ echo date('F', mktime(0, 0, 0, $bulan, 10)); } ?> {{$tahun}}
                </h2></center>  
            </div>
            <br>
            <table class="tg">
              <tr>
                <th class="tg-3wr7">Waktu<br></th>
                <th class="tg-3wr7">Deskripsi<br></th>
                <th class="tg-3wr7">Pemasukan<br></th>
                <th class="tg-3wr7">Pengeluaran<br></th>
              </tr>
              @foreach ($kas as $u)
              <tr>
                <td class="tg-rv4w" width="15%" align="center">{{ Carbon\Carbon::parse($u->date)->format('d M Y') }}</td>
                <td class="tg-rv4w uppercase" width="55%">{{ $u->description }}</td>
                @if($u->type=="pemasukan")
                  <td class="tg-rv4w" width="15%" align="right">{{ $u->price }} </td>
                  <td class="tg-rv4w" width="15%" align="center"> - </td>                  
                @else
                  <td class="tg-rv4w" width="15%" align="center"> - </td>                  
                  <td class="tg-rv4w" width="15%" align="right">{{ $u->price }} </td>
                @endif
              </tr>
              @endforeach
            </table>
        </body>
    </head>
</html>