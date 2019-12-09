@extends('layouts.admin-header')
@section('css')
<style type="text/css" media="screen">
  .half-form{
    margin:0 20px;
    padding: 10px;
    float: left;
  }
  .image-movie{
    max-width: 200px;
  }
</style>
@endsection
@section('content')

<div class="container">



  <br><br>

  <br><br>
  <table class="table table-bordered" id="users-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Image</th>
        <th>Update</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>
</div>
<!-- modal add post -->
<div class="modal fade" id="addProduct">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Post</h4>
      </div>
      <div class="half-form">
       <div class="form-group">
        <label for="">Title</label>
        <input type="text" class="form-control" id="title" placeholder="Input field">
      </div>

      <div id="image_preview"></div>
      <div class="form-group">
        <label for="">Images</label>
        <input type="file" id="files" class="form-control" name="file" />
      </div>

      <div class="form-group">
        <label for="">Descripton</label>
        <textarea name="description" id="description" class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="">Content</label>
        <textarea name="content"></textarea>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" id="StoreBtn" class="btn btn-primary">Save changes</button>
    </div>
  </div>
</div>
</div>
{{-- edit product modal  --}}

<div class="modal fade" id="editPost">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="half-form">
       <div class="form-group">
        <label for="">Title</label>
        <input type="text" class="form-control" id="etitle" placeholder="Input field">
      </div>

      <div id="eimage_preview">

      </div>
      <div class="form-group">
        <label for="">Images</label>
        <input type="file" id="efiles" class="form-control" name="efiles" />
      </div>

      <div class="form-group">
        <label for="">Descripton</label>
        <textarea name="description" id="edescription"class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="">Content</label>
        <textarea name="econtent"></textarea>
      </div>
    </div>
    <input type="hidden" id="eid" name="eid">
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" id="UpdateBtn" class="btn btn-primary">Save changes</button>
    </div>
  </div>
</div>
</div>


@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'content' );
  CKEDITOR.replace( 'econtent' );
</script>
<script>
  $(function() {
    $('#users-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/admin/post/lists',
      columns: [
      { data: 'id', name: 'id' },
      { data: 'title', name: 'title' },
      { data: 'image', name: 'image' },
      { data: 'updated_at', name: 'updated_at' },
      { data: 'status', name: 'status' },
      { data: 'action', name: 'action' },
      ]
    });
  });
</script>
<script>
  CKEDITOR.replace( 'content' );
  CKEDITOR.replace( 'econtent' );
  CKEDITOR.editorConfig = function( config ) {
        // Define changes to default configuration here. For example:
        // config.language = 'fr';
        // config.uiColor = '#AADC6E';
        config.width = '400px';
      };
    </script>
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}
    
    <script type="text/javascript" charset="utf-8">
      
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        })
        $("#files").change(function(){
         $('#image_preview').html("");
         var total_file=document.getElementById("files").files.length;
         console.log(document.getElementById("files").files);
         for(var i=0;i<total_file;i++)
         {
          $('#image_preview').append("<img class'img-responsive img' style='width:50px' src='"+URL.createObjectURL(event.target.files[i])+"'>");
        }
      })




  // get data for form update
  function get(id) {
    $.ajax({
      type: "GET",
      url: "{{ asset('post/get') }}/"+id,
      success: function(response)
      {
        $('#eimage_preview').html("");
        CKEDITOR.instances.econtent.setData(response.content);
        $('#etitle').val(response.title);
        $('#edescription').val(response.description);
        $('#eid').val(response.id);
        html="<img src='"+response.image+"' class='img-responsive img' style='display:inline-block;width:50px'>";
        $('#eimage_preview').append(html);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  }
  function setStatus(id) {
    $.ajax({
      type: "get",
      url: "{{ asset('admin/post/status') }}/"+id,
      success: function(response)
      {
        toastr.success('Cap nhat thành công!');
        setTimeout(function () {
          location.reload();
        }, 500)

      },
      error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  }

    // Update function
      // Delete function
      function alDelete(id){
        swal({
          title: "Bạn có chắc muốn xóa?",
        // text: "Bạn sẽ không thể khôi phục lại bản ghi này!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",  
        cancelButtonText: "Không",
        confirmButtonText: "Có",
        // closeOnConfirm: false,
      },
      function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            type: "delete",
            url: "post/"+id,
            success: function(res)
            {
              if(!res.error) {
                toastr.success('Xóa thành công!');
                $('#product-'+id).remove();
                setTimeout(function () {
                  location.reload();
                }, 1000)
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              toastr.error(thrownError);
            }
          });
        } else {
          toastr.error("Thao tác xóa đã bị huỷ bỏ!");
        }
      });
      };

     
</script>

@endsection