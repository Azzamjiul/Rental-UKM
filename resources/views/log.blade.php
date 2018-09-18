@extends('layouts.main')

@section('style')
  <style media="screen">
    .list-produk .card:hover{
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08);
    }
    .big-icon {
        font-size: 32px;
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
      <h2>Log
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
      Log adalah pencatatan untuk pemasukan dan pengeluaran.<br>
      <strong>Pemasukan</strong> untuk semua jenis pemasukan kecuali penyewaan, karena telah otomatis tercatat sebagai pemasukan.<br>
      <strong>Pengeluaran</strong> untuk semua jenis pengeluaran.
    </div>
    <section class="list-produk">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-8 col-md-3">
            <div class="card" id="pemasukan" style="cursor: pointer;">
              <div class="card-body text-center">
                <h5 class="d-none d-sm-block">PEMASUKAN</h5>
                <h6 class="d-block d-sm-none">PEMASUKAN</h6>
                <i class="big-icon fa fa-sign-in"></i>
              </div>
            </div>
          </div>
          <div class="col-8 col-md-3">
            <div class="card" id="pengeluaran" style="cursor: pointer;">
              <div class="card-body text-center">
                <h5 class="d-none d-sm-block">PENGELUARAN</h5>
                <h6 class="d-block d-sm-none">PENGELUARAN</h6>
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
  <form action="{{route('log.deleteKas')}}" method="post" id="formDelete">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" id="deleteKas" name="id_kas">
  </form>
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
                    <h5 class="modal-title type-kas text-capitalize" id="exampleModalCenterTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="editMasuk" autocomplete="off">
                  {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                      <label for="deskripsiEdit">Deskripsi</label>
                      <textarea class="form-control" id="deskripsiEdit" required name="deskripsiEdit"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="jumlahEdit">Jumlah</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp</div>
                        </div>
                        <input type="text" class="angka form-control" id="jumlahEdit" required name="jumlahEdit">
                      </div>
                    </div>
                    <input type="hidden" id="resMod" name="id_kas">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="submitEdit" class="btn btn-primary">Edit</button>
                </div>
              </form>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){

      $( '.angka').mask('0.000.000.000.000', {reverse: true});
      $("#masuk").submit(function(e){        
        $("#jumlahMasuk").val($("#jumlahMasuk").val().split('.').join(""))
        console.log($("#jumlahMasuk").val())

      })

      $("#keluar").submit(function(){
        $("#jumlahKeluar").val($("#jumlahKeluar").val().split('.').join(""))

      })

      $("#editMasuk").submit(function(){
        $("#jumlahEdit").val($("#jumlahEdit").val().split('.').join(""))

      })

      $("#log").addClass("active");


        var table1;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table1 = $('#tableLog').DataTable({
        stateSave: true,
        responsive: true,
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
            {data: "description", orderable: false, render: function(data, type, row){
              if(data.length > 30){
                return data.substring(0,38)+" . . .";
              }
              else{
                return data;
              }
            }},
            {data: "price", orderable: false, render: function(data, type, row){
              return 'Rp ' + data;
            }},
            {data: "date", render: function(data, type, row){
              var options = {hour:'numeric',minute:'numeric', year: 'numeric', month: 'long', day: 'numeric' };
              var today  = new Date(data);
              return today.toLocaleDateString("id", options);
              }
            },
            {data: "type", orderable: false, render: function(data, type, row){
                if (row.type == "pemasukan"){
                  return "<button class='btn btn-sm btn-success' style='cursor:context-menu;width:120px' disabled>Pemasukan</button>";
                }else if(row.type == "pengeluaran"){
                  return "<button class='btn btn-sm btn-info' style='cursor:context-menu;width:120px' disabled>Pengeluaran</button>";
                }
              },
            },
            {orderable: false, className : "text-center",render: function(data, type, row){
                // if ((row.description.replace(/ .*/,'')).toLowerCase()=="penjualan") {
                //   return ""
                // }
                // else{
                  return "<button type='button' name='button' class='btn edit dataMod' data-toggle='modal' data-target='#modalEdit' data-types="+row.type+" data-deskripsi='"+row.description+"' data-price="+row.price+" data-id="+row.id_kas+"><i class='fa fa-pencil edit' aria-hidden='true'></i></button>&nbsp;<button data-id="+row.id_kas+" class='btn delete' type='button'><i class='fa fa-trash-o delete' aria-hidden='true'></i></button>";
                // }
              }
            },
        ]
      });
  });

  $(document).on('click', '.dataMod', function(){
      var id = $(this).data('id');
      var type = $(this).data('types');
      var deskripsi = $(this).data('deskripsi');
      var price = $(this).data('price');
      $("#resMod").val(id);
      $(".type-kas").html(type);
      $("#deskripsiEdit").val(deskripsi);
      $("#jumlahEdit").val(price);
      $('#editMasuk').attr('action', '{{route('log.editKas')}}');
  });

  $(document).on('click', '.delete', function(){
    var id = $(this).data('id');
    $("#deleteKas").val(id);
    alertify.confirm('Warning', "Anda yakin akan menghapus catatan kas ini?<br><br><h6 class='text-danger'>nb:Catatan yang telah dihapus tidak dapat dikembalikan!</h6>",
      function(){
        $("#formDelete").submit();
      },
      function(){
    });
  })

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
