<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use Yajra\Datatables\Datatables;
use App\Post;
class PostController extends Controller
{
    public function index(){
    	return view('posts.index',);
    }
    public function anyData(){
    
        $datas = Post::select('posts.*');
        return Datatables::of($datas)
        ->addColumn('action', function ($datas) {
            return'
            <button type="button" class="btn btn-xs btn-warning"data-toggle="modal" onclick="get('.$datas['id'].')" href="#editPost"><i class="fa fa-pencil" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-xs btn-danger" onclick="alDelete('.$datas['id'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>
            ';
            
        })
        ->editColumn('image', '<img src="{{$image}}"/>')
        ->setRowId('posts-{{$id}}')
        ->editColumn('origin_cost', '{{ number_format($origin_cost)}}')
        // ->rawColumns(['action'])
        ->make(true);
}

    public function getPost($id){
        $data=Post::find($id);
        return response()->json($data);
    }
    public function destroy($id){
        $data=Post::find($id)->delete();
        return response()->json($data);
    }
    
    public function store(PostRequest $request) {
        $image=$request->only(['image']);
        $data=$request->only(['title','description','content']);
        $data['slug']=str_slug($data['title']);
        $data['user_id']=Auth::id();
        $data['iamge']= 'http://'.request()->getHttpHost().'/images/post/'.time().$key.'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images/post'), $imageName);
        Post::create($data);
        return "true";
    
    }
    public function updatePost(PostUpdateRequest $request) {
        $id=$request->only(['id']);
        $image=$request->only(['image']);
        $data=$request->only(['title','description','content']);
         if (!isempty($request['images'])) {
            $data['iamge']= 'http://'.request()->getHttpHost().'/images/post/'.time().$key.'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/post'), $imageName);
        }
        $boolean=Post::where('id',$id)->update($data);
            return "true";
    }
}