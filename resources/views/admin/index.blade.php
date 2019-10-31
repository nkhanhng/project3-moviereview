@extends('layouts.admin-header')
@section('css')
<style type="text/css" media="screen">
  .paginate_button{
    color: #fff;
    background-color: #e68f35;
    border-color: #d43f3a;
    padding: 6px;
    border-radius: 5px;
    margin: 2px;
  }
  .image-movie{
    max-width: 200px;
  }
</style>

<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
@endsection
@section('content')

<div class="container" style="width:100%">
  <h2>Categories</h2>
  <br />

  <a href="#"  class="btn btn-info" data-toggle="modal" data-target="#create">+ Add </a>
  <br><br>
  <table id="users-table" class="table table-striped">
    <thead class="flg">
      <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Title</th>
        <th>Rate</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>
</div>
<div class="modal fade" id="editProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Cập Nhật Thông Tin Danh Mục</h5>
      </div>
      <div class="modal-body">
        <form method="user" role="form" id="editUser" style="width:100%">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-sm-2" for="name">Key Movies:</label>
            <input type="text" class="form-control" id="ekey" placeholder="Enter name" name="key">
          </div>
          <input type="hidden" name="eid" id="eid">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="UpdateBtn" class="btn btn-primary">Save changes</button>
          </div> 
        </form>
      </div>

    </div>
  </div>
</div>


<!-- Modal add -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edituser">Thêm Danh Mục</h5>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="addUser" style=" width:100%">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-sm-2" for="name">Key:</label>
            <input type="text" class="form-control" id="key" placeholder="Enter name" name="key">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="StoreBtn" class="btn btn-primary">Save changes</button>
          </div> 
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')

{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}
<script type="text/javascript" charset="utf-8">
  $(function () {
    $.ajaxSetup({

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    //Load Data to table
   var tables= $('#users-table').DataTable({
      processing: true,
      serverSide: true,
      order: [[ 2, "desc" ]],
      ajax: '{!! route('list.key') !!}',
      columns: [
      { data: 'id', name: 'id' },
      { data: 'image', name: 'image' },
      { data: 'title', name: 'title' },
      { data: 'rate', name: 'rate' },
      { data: 'action', name: 'action' },
      ]
    });



// Store new data

$('#StoreBtn').on('click',function(e){
  e.preventDefault();
  $.ajax({
    type:'post',
    url:"{{asset('admin/movie/store')}}",
    data:{
      key:$('#key').val()
    },
    success:function(response){
     console.log(response);
     setTimeout(function () {toastr.success('Has been added')},1000);
                // var data = JSON.parse(response).data;
                tables.ajax.reload(null, false);
                $('#create').modal('hide');

              }, error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(xhr.responseJSON.message);
              },

            })
});



})


  // delete post

  $(document).on('click','.btn-danger',function(){
    var id=$(this).data('id');
    var btn=$(this);
    $.ajax({
      type:'delete',
      url:'categories/'+id,
      success:function(response){
        btn.parent().parent().remove();
        toastr.success(response.message);
      }
    });
  });

  // get data for form update

      // Update function
      $('#UpdateBtn').on('click',function(e){
        e.preventDefault();
        var id=$('#eid').val();
        console.log(id);
        $.ajax({
          type:'post',
          url: "{{ asset('admin/categories/update') }}",
          data:{
            name:$('#ename').val(),
            parent_id:$('#eparent_id').val(),
            sort_order:$('#esort_order').val(),
            id:$('#eid').val(),
          },
          success: function(response){
            setTimeout(function () {
              toastr.success(response.name+'has been added');

            },1000);

            $('#editProduct').modal('hide');
          }, error: function (xhr, ajaxOptions, thrownError) {
            if (!checkNull(xhr.responseJSON.errors)) {
              console.log(xhr.responseJSON.errors);
              $('p#sperrors').remove();
              if(!checkNull(xhr.responseJSON.errors.name))
              {
                for (var i = 0; i < xhr.responseJSON.errors.name.length; i++) {
                  var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.name[i]+'</p>';

                  $(html).insertAfter('#name');
                }
              };
              if(!checkNull(xhr.responseJSON.errors.sort_order))
              {
                for (var i = 0; i < xhr.responseJSON.errors.sort_order.length; i++) {
                  var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.sort_order[i]+'</p>';
                  console.log(html);
                  $(html).insertAfter('#sort_order');
                }
              };
            }
            toastr.error(xhr.responseJSON.message);

          },

        })
      });
      function getProduct(id) {
        console.log(id);
        // $('#editPost').modal('show');

        $.ajax({
          type: "GET",
          url: "categories/edit/" + id,

          success: function(response)
          { console.log(response);
            $('#ename').val(response.name);
            $('#eparent_id').val(response.parent_id);
            $('#esort_order').val(response.sort_order);
            $('#eid').val(response.id);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });

      }

      // Delete function
      function alDelete(id){
        console.log(id);
        var path = "/admin/movie/" + id;
        swal({
          title: "Are you sure?",
        // text: "Bạn sẽ không thể khôi phục lại bản ghi này!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No",
        confirmButtonText: "Yes",
        // closeOnConfirm: false,
      },
      function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            type: "delete",
            url: path,
            success: function(res)
            {
              if(!res.error) {
                toastr.success('Delete to success!');
                $('#movies-'+id).remove();
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              toastr.error(thrownError);
            }
          });
        } else {
          toastr.error("The delete operation has been aborted!");
        }
      });
      };
      function checkNull(value){
        return (value == null || value === '');
      }
    </script>
    @endsection
