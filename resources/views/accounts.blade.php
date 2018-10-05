@extends('layouts.main')

@section('style')

@endsection


@section('content')
  <header class="page-header mb-3">
    <div class="container-fluid">
      <h2>Manajemen Akun</h2>
    </div>

  </header>

<div class="container-fluid">
  <div class="alert alert-info mt-4">
    <strong>Manajemen Akun</strong> adalah tempat mengatur akun sistem online.<br>
  </div>
  <div class="card">
    <div class="card-body">
      <button type="button" name="button" class="btn btn-primary mb-1" id="new_account" style="float: right">Tambah akun</button>
      <table  class="table table-striped">
        <thead>
          <th>No</th>

          <th>Nama</th>
          <th>Email</th>
          <th>Aksi</th>
        </thead>
        <tbody>

          @foreach ($accounts as $account)
            <tr>
              <td>{{$account->id}}</td>
              <td>{{$account->name}}</td>
              <td>{{$account->email}}</td>
              <td>
              <form class="" action="{{route('delete.user')}}" method="post" id="form-id-{{$account->id}}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id_account" value="{{$account->id}}">
              </form>
                <button type="button" name="button" class="btn btn-sm btn-info mr-2 edit" account-id="{{$account->id}}">Edit</button>
                @if(Auth::user()->id != $account->id )
                <button type="button" name="button" class="btn btn-sm btn-danger delete" account-id="{{$account->id}}">Hapus</button>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="title">Edit akun</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="" action="#" method="post" id="form_user">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="name">Nama: </label>
              <input class="form-control" type="text" name="name" value="" id="name" required>
            </div>
            <div class="form-group">
              <label for="email">Email: </label>
              <input class="form-control" type="email" name="email" value="" id="email" required>
            </div>
            <div class="form-group">
              <label for="password">Password: </label>
              <input class="form-control" type="password" name="password" value="" id="password">
            </div>

            <input type="hidden" id="user_id" name="user_id" value="">

        </div>
        <div class="modal-footer">
          <button type="submit" name="button" class="btn btn-success" id="save">Simpan</button>
          </form>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection


@section('script')
<script type="text/javascript">

  $(document).ready(function(){


    var method ,url;
    var table1 = $('table').DataTable({
    stateSave: true,
    language: {
      searchPlaceholder: "Cari akun ..."
    }
  });

    $(".edit").click(function(){
      user_id = $(this).attr('account-id');
      method = "PUT";
      $("#title").html("Edit Akun");
      url = "{{url('/update/user')}}";
      $.ajax({
        url: '{{url('/get/user')}}',
        data: {user_id},
        success: function(data){
          $("#name").val(data.name);
          $("#email").val(data.email);
          $("#user_id").val(data.id);
          $(".modal").modal('show');
        },
        error: function(){
          alertify.error("Server error. Cannot get user data.");
        }
      });
    });

    $("#new_account").click(function(){
      $("#form_user")[0].reset();
      $(".modal").modal('show');
      $("#title").html("Tambah Akun");
      method = "POST";
      url = "{{url('/new/user')}}";
    });

    $("#save").click(function(e){
      e.preventDefault();
      if (method == "POST") {
        password = $("#password").val();
        if (password.length == 0) {
          alert("Password tidak boleh kosong!");
          return false;
        }
      }
      $.ajax({
        method: method,
        url: url,
        data: $("#form_user").serialize(),
        success: function(data){
          if (method == "PUT") {
            alertify.success("Akun berhasil diedit!");
          }else{
            alertify.success("Akun berhasil dibuat!");
          }
          $(".modal").modal('hide');
          setTimeout(function(){
          window.location = "{{url('/accounts')}}";
        }, 1500);

        },
        error: function(data){
          alertify.error("Server error. Akun gagal dibuat!");
        }
      })
    });

    $(".delete").click( function() {
      id_account = $(this).attr('account-id');
      alertify.confirm('Warning', "Anda yakin akan menghapus akun ini?<br>Akun yang telah dihapus tidak dapat kembali!",
        function(){
          $("#form-id-" + id_account).submit();
        },
        function(){
      });
    })

  });

</script>
@endsection
