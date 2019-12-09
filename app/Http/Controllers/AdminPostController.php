<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Post;
class AdminPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
    	return view('admin.post');
    }
    public function anyData(){
    
        $datas = Post::select('posts.*')->orderBy('status', 'desc');
        return Datatables::of($datas)
        ->addColumn('action', function ($datas) {
            return'
            <button type="button" class="btn btn-xs btn-success"data-toggle="modal" onclick="get('.$datas['id'].')" href="#editPost"><i class="fa fa-eye" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-xs btn-danger" onclick="alDelete('.$datas['id'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>
            ';
            
        })
        ->editColumn('image', '<img src="{{$image}}" class="image-movie" />')
        ->editColumn('status',function($datas){
            if ($datas->status) {
                return'<input type="checkbox"  onchange="setStatus('.$datas['id'].')" checked/>';
            }
            return'<input type="checkbox" onchange="setStatus('.$datas['id'].')"/>';
        })
        ->setRowId('posts-{{$id}}')
        ->rawColumns(['action','image','status'])
        ->make(true);
}

    public function getPost($id){
        $data=Post::find($id);
        return response()->json($data);
    }
    public function delete($id){
        $data=Post::find($id)->delete();
        return response()->json($data);
    }

     public function setStatus($id){
        $data=Post::find($id);
        if ($data['status']==0) {
            $data['status']=1;
        }else {$data['status']==0;}
        $data->save();
        return response()->json($data);
    }
    
}