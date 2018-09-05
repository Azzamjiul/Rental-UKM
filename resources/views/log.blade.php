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
      <h2>Log
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
      Log adalah pencatatan untuk pemasukan dan pengeluaran.<br>
      <strong>Pemasukan</strong> untuk semua jenis pemasukan kecuali penyewaan, karena telah otomatis tercatat sebagai pemasukan.<br>
      <strong>Pengeluaran</strong> untuk semua jenis pengeluaran.
    </div>
    <section class="list-produk">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-6 col-md-3">
            <div class="card" id="pemasukan" style="cursor: pointer;">
              <div class="card-body text-center">
                <h5>PEMASUKAN</h5>
                <i class="big-icon fa fa-sign-in"></i>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card" id="pengeluaran" style="cursor: pointer;">
              <div class="card-body text-center">
                <h5>PENGELUARAN</h5>
                <i class="big-icon fa fa-sign-out"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <br>
  <div class="container-fluid">
    <p>Data Pemasukan dan Pengeluaran</p>
    <div class="table-responsive">
      <table id="tableLog" class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Deskripsi</th>
            <th>Jumlah</th>
            <th>Waktu</th>
            <th>Jenis</th>
            <th>Edit</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
    <div class="modal fade" id="modalPemasukan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Pemasukan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="masuk" autocomplete="off">
                  {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                      <label for="deskripsiMasuk">Deskripsi</label>
                      <textarea class="form-control" id="deskripsiMasuk" required name="deskripsiMasuk"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="jumlahMasuk">Jumlah Pemasukan</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp</div>
                        </div>
                        <input type="text" class="angka form-control" id="jumlahMasuk" required name="jumlahMasuk">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPengeluaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Pengeluaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="keluar" autocomplete="off">
                  {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                      <label for="deskripsiKeluar">Deskripsi</label>
                      <textarea class="form-control" id="deskripsiKeluar" required name="deskripsiKeluar"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="jumlahKeluar">Jumlah Pengeluaran</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp</div>
                        </div>
                        <input type="text" class="angka form-control" id="jumlahKeluar" required name="jumlahKeluar">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="masuk" autocomplete="off">
                  {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                      <label for="deskripsiMasuk">Deskripsi</label>
                      <textarea class="form-control" id="deskripsiMasuk" required name="deskripsiMasuk"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="jumlahMasuk">Jumlah Pemasukan</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp</div>
                        </div>
                        <input type="text" class="angka form-control" id="jumlahMasuk" required name="jumlahMasuk">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
      (function(b){var c={allowFloat:false,allowNegative:false};b.fn.numericInput=function(e){var f=b.extend({},c,e);var d=f.allowFloat;var g=f.allowNegative;this.keypress(function(j){var i=j.which;var h=b(this).val();if(i>0&&(i<48||i>57)){if(d==true&&i==46){if(g==true&&a(this)==0&&h.charAt(0)=="-"){return false}if(h.match(/[.]/)){return false}}else{if(g==true&&i==45){if(h.charAt(0)=="-"){return false}if(a(this)!=0){return false}}else{if(i==8){return true}else{return false}}}}else{if(i>0&&(i>=48&&i<=57)){if(g==true&&h.charAt(0)=="-"&&a(this)==0){return false}}}});return this};function a(d){if(d.selectionStart){return d.selectionStart}else{if(document.selection){d.focus();var f=document.selection.createRange();if(f==null){return 0}var e=d.createTextRange(),g=e.duplicate();e.moveToBookmark(f.getBookmark());g.setEndPoint("EndToStart",e);return g.text.length}}return 0}}(jQuery));

      $(function() {
         $(".angka").numericInput({ allowFloat: true, allowNegative: false });
      });

        var table1;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table1 = $('#tableLog').DataTable({
        stateSave: true,
        language: {
          searchPlaceholder: "Cari data"
        },
        ajax: "{{route('get.kas')}}",
        columns:[
            {
               "data": "id",
              render: function (data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            {data: "description", orderable: false},
            {data: "price", orderable: false},
            {data: "date", render: function(data, type, row){
              var options = {hour:'numeric',minute:'numeric', year: 'numeric', month: 'long', day: 'numeric' };
              var today  = new Date(data);
              return today.toLocaleDateString("id", options);
              }
            },
            {data: "type", orderable: false, render: function(data, type, row){
                if (row.type == "pemasukan"){
                  return "<button class='btn btn-sm btn-success' style='cursor:context-menu;width:120px' disabled>Pemasukan</button>";
                }else{
                  return "<button class='btn btn-sm btn-info' style='cursor:context-menu;width:120px' disabled>Pengeluaran</button>";
                }
              },
            },
            {render: function(data, type, row){
              return "<button type='button' name='button' class='btn dataMod' data-toggle='modal' data-target='#modalEdit' data-id="+row.id_kas+"><i class='fa fa-pencil edit' aria-hidden='true'></i></button>";
              }
            },
        ]
      });
  });

  $(".dataMod").click(function() {
      var pesan = $(this).data('id');
      $("#resMod").html(pesan);
  });

  $("#pemasukan").click( () => {
    $('#masuk').attr('action', '{{route('log.pemasukan')}}');
    $("#modalPemasukan").modal('show');
  });

  $("#pengeluaran").click( () => {
    $('#keluar').attr('action', '{{route('log.pengeluaran')}}');
    $("#modalPengeluaran").modal('show');
  });
</script>
@endsection
