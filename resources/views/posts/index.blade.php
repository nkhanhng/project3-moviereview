@extends('layouts.user-header')
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
  <a class="btn btn-primary" data-toggle="modal" href='#addProduct'>+Add</a>

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
                              ajax: '{!! route('posts.data') !!}',
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
      $(function () {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $("#files").change(function(){
         $('#image_preview').html("");
         var total_file=document.getElementById("files").files.length;
         console.log(document.getElementById("files").files);
         for(var i=0;i<total_file;i++)
         {
          $('#image_preview').append("<img class'img-responsive img' style='width:50px' src='"+URL.createObjectURL(event.target.files[i])+"'>");
        }
      });



        $('#StoreBtn').on('click',function(e){
          e.preventDefault();
          var content = CKEDITOR.instances.content.getData();
          var files = document.getElementById('files').files[0];
          
          var newPost = new FormData();
          newPost.append('title',$('#title').val());
          newPost.append('description',$('#description').val());
          newPost.append('content',content);
          
            newPost.append('images',files);
          $.ajax({
            type:'post',
            url:"post/store",
            data:newPost,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false,
            success:function(response){
             console.log(response);
             setTimeout(function () {
               toastr.success('has been added');
                  // window.location.href="";
                },1000);

                  location.reload();
                // var data = JSON.parse(response).data;
                
              }, error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                toastr.errors(xhr);
          },
        })
        });


$('#UpdateBtn').on('click',function(e){
  e.preventDefault();
  var econtent = CKEDITOR.instances.econtent.getData();
  var efiles = document.getElementById('efiles').files[0];
  var updatePost = new FormData();
  updatePost.append('id',$('#eid').val());
  updatePost.append('title',$('#etitle').val());
  updatePost.append('description',$('#edescription').val());
  updatePost.append('content',econtent);
  updatePost.append('image',efiles);
   $.ajax({
    type:'post',
    url: "{{asset('post/update')}}",
    data:updatePost,
    dataType:'json',
    async:false,
    processData: false,
    contentType: false,
    success: function(response){
      console.log(response);
        // var result = JSON.parse(response);
        setTimeout(function () {
          toastr.success(response.name+'has been update');
          // window.location.href="";
        },1000);

        location.reload();
     
      },  error: function (xhr, ajaxOptions, thrownError) {
        $("p.sperrors").replaceWith("");
        if (!checkNull(xhr.responseJSON)) {
          if(!checkNull(xhr.responseJSON.errors.name))
          { 
            for (var i = 0; i < xhr.responseJSON.errors.name.length; i++) {
              var html='<p class="sperrors" style="color:red">'+xhr.responseJSON.errors.name[i]+'</p>';
              $(html).insertAfter('#ename');
            }
          };
          if(!checkNull(xhr.responseJSON.errors.content))
          {
            for (var i = 0; i < xhr.responseJSON.errors.content.length; i++) {
              var html='<p class="sperrors" style="color:red">'+xhr.responseJSON.errors.content[i]+'</p>';
              $(html).insertAfter('#econtentdiv');
            }
          };
          if(!checkNull(xhr.responseJSON.errors.description))
          {
            for (var i = 0; i < xhr.responseJSON.errors.description.length; i++) {
              var html='<p  class="sperrors" style="color:red">'+xhr.responseJSON.errors.description[i]+'</p>';
              $(html).insertAfter('#edescription');
            }
          };
          if(!checkNull(xhr.responseJSON.errors.sale_cost))
          {
            for (var i = 0; i < xhr.responseJSON.errors.sale_cost.length; i++) {
              var html='<p class="sperrors" style="color:red">'+xhr.responseJSON.errors.sale_cost[i]+'</p>';
              $(html).insertAfter('#etag');
            }
          };
        };
      },
    })
});
})
function plusData(id) {$.ajax({
  type: "GET",
  url: "product/plus/"+id,
  success: function(response)
  {
    console.log(response);     
  },
  error: function (xhr, ajaxOptions, thrownError) {
    toastr.error(thrownError);
  }
});
}
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
      function wareHousingDelete(id){
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
            url: "wareHousingDelete/"+id,
            success: function(res)
            {
              if(!res.error) {
                toastr.success('Xóa thành công!');
                $('#wareHousing-'+id).remove();
                  //setTimeout(function () {
                    //location.reload();
                  //}, 1000)
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
      function checkNull(value){
        return (value == null || value === '');
      }
      function getReason(id){
        $.ajax({
          type: "post",
          url: "",
          success: function(response)
          {
            console.log(response);
            if (response.notice==null) {
              $("p#reason").append("Admin Không Để Lại Lý Do");
              console.log('test');
            }else{
              $("p#reason").append(response.notice);
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        })
      }
      $('#sale_cost').on('keypress', function(e){
  return e.metaKey || // cmd/ctrl
    e.which <= 0 || // arrow keys
    e.which == 8 || // delete key
    /[0-9]/.test(String.fromCharCode(e.which)); // numbers
  })
      $('#esale_cost').on('keypress', function(e){
  return e.metaKey || // cmd/ctrl
    e.which <= 0 || // arrow keys
    e.which == 8 || // delete key
    /[0-9]/.test(String.fromCharCode(e.which)); // numbers
  })
      $('#origin_cost').on('keypress', function(e){
  return e.metaKey || // cmd/ctrl
    e.which <= 0 || // arrow keys
    e.which == 8 || // delete key
    /[0-9]/.test(String.fromCharCode(e.which)); // numbers
  })
      $('#eorigin_cost').on('keypress', function(e){
  return e.metaKey || // cmd/ctrl
    e.which <= 0 || // arrow keys
    e.which == 8 || // delete key
    /[0-9]/.test(String.fromCharCode(e.which)); // numbers
  })
      $('#quantity').on('keypress', function(e){
  return e.metaKey || // cmd/ctrl
    e.which <= 0 || // arrow keys
    e.which == 8 || // delete key
    /[0-9]/.test(String.fromCharCode(e.which)); // numbers
  })
</script>

@endsection