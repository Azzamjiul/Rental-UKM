@extends('layouts.main')

@section('style')
  <style media="screen">
    .list-produk .card:hover{
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08);
    }
    .big-icon {
        font-size: 32px;
    }
  </style>
@endsection

@section('content')
  <header class="page-header mb-2">
    <div class="container-fluid">
      <h2>Report
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
      Report adalah laporan untuk melihat data pemasukan/pengeluaran serta data peminjaman.<br>
      <strong>Log</strong> adalah data arus pemasukan dan pengeluaran uang.<br>
      <strong>Transaksi</strong> adalah data peminjaman dan penjualan
    </div>
    <section class="list-produk">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-8 col-md-3">
            <div class="card" id="logs" style="cursor: pointer;">
              <div class="card-body text-center">
                <h5 class="d-none d-sm-block">LOG</h5>
                <h6 class="d-block d-sm-none">LOG</h6>
                <i class="big-icon fa fa-book"></i>
              </div>
            </div>
          </div>
          <div class="col-8 col-md-3">
            <div class="card" id="reports" style="cursor: pointer;">
              <div class="card-body text-center">
                <h5 class="d-none d-sm-block">TRANSAKSI</h5>
                <h6 class="d-block d-sm-none">TRANSAKSI</h6>
                <i class="big-icon fa fa-handshake-o"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <br>
  <div class="container-fluid">
  </div>
    <div class="modal fade" id="modalLog" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalCenterTitle">LOG</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                      Cara penggunaan
                      <ol>
                        <li>Pilih bulan dan tahun</li>
                        <li>Pilih ukuran kertas</li>
                        <li>Anda dapat hanya melihat maupun download file</li>
                        <li>Enjoy!</li>
                      </ol>
                    </div>
                    <div class="form-group">
                      <label for="bulanLog">Bulan</label>
                      <select class="custom-select" id="bulanLog" name="bulanLog">
                        <option selected value="all">Januari-Desember</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="tahunLog">Tahun</label>
                      <select class="custom-select" id="tahunLog" name="tahunLog">
                        <?php $yearNow = date("Y");
                          for ($i=2018; $i <=$yearNow ; $i++) { ?>
                            <option value=<?php echo $i ?>><?php echo $i ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="kertasLog">Ukuran Kertas</label>
                      <select class="custom-select" id="kertasLog" name="kertasLog">
                        <option selected value="a3">A3</option>
                        <option value="a4">A4</option>
                      </select>
                    </div>
                    <div align="center">
                      <a class="btn btn-outline-primary" role="button" id="seeLog"><i class="fa fa-eye"></i></a>
                      <a class="btn btn-outline-primary" role="button" id="downloadLog"><i class="fa fa-download"></i></a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalCenterTitle">REPORT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                      Cara penggunaan
                      <ol>
                        <li>Pilih bulan dan tahun</li>
                        <li>Pilih ukuran kertas</li>
                        <li>Anda dapat hanya melihat maupun download file</li>
                        <li>Enjoy!</li>
                      </ol>
                    </div>
                    <div class="form-group">
                      <label for="bulanReport">Bulan</label>
                      <select class="custom-select" id="bulanReport" name="bulanReport">
                        <option selected value="all">Januari-Desember</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="tahunReport">Tahun</label>
                      <select class="custom-select" id="tahunReport" name="tahunReport">
                        <?php $yearNow = date("Y");
                          for ($i=2018; $i <=$yearNow ; $i++) { ?>
                            <option value=<?php echo $i ?>><?php echo $i ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="kertasReport">Ukuran Kertas</label>
                      <select class="custom-select" id="kertasReport" name="kertasReport">
                        <option selected value="a3">A3</option>
                        <option value="a4">A4</option>
                      </select>
                    </div>
                    <div align="center">
                      <a class="btn btn-outline-primary" role="button" id="seeReport"><i class="fa fa-eye"></i></a>
                      <a class="btn btn-outline-primary" role="button" id="downloadReport"><i class="fa fa-download"></i></a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $("#report").addClass("active");

  });

  $("#logs").click( () => {
    $("#modalLog").modal('show');
  });

  $("#reports").click( () => {
    $("#modalReport").modal('show');
  });

  $("#seeLog").click( () => {
    var redirect= window.location.href+ "/kas/" + $("#tahunLog").val() + "/" + $("#bulanLog").val() + "/" + $("#kertasLog").val();
    window.open(redirect);
  });

  $("#downloadLog").click( () => {
    var redirect= window.location.href+ "/kas/download/" + $("#tahunLog").val() + "/" + $("#bulanLog").val() + "/" + $("#kertasLog").val();
    window.open(redirect);
  });

  $("#seeReport").click( () => {
    var redirect= window.location.href+ "/invoices/" + $("#tahunReport").val() + "/" + $("#bulanReport").val() + "/" + $("#kertasReport").val();
    window.open(redirect);
  });

  $("#downloadReport").click( () => {
    var redirect= window.location.href+ "/invoices/download/" + $("#tahunReport").val() + "/" + $("#bulanReport").val() + "/" + $("#kertasReport").val();
    window.open(redirect);
  });
</script>
@endsection
