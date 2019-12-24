<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    
        $datas = Post::select('posts.*')->where('user_id',Auth::id())->orderBy('status', 'desc');
        return Datatables::of($datas)
        ->addColumn('action', function ($datas) {
            return'
            <button type="button" class="btn btn-xs btn-warning"data-toggle="modal" onclick="get('.$datas['id'].')" href="#editPost"><i class="fa fa-pencil" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-xs btn-danger" onclick="alDelete('.$datas['id'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>
            ';
            
        })
        ->editColumn('image', '<img src="{{$image}}" class="image-movie" />')
        ->editColumn('status',function($datas){
            if ($datas->status) {
                return'<input type="checkbox"  onchange="setStatus('.$datas['id'].')" checked disabled />';
            }
            return'<input type="checkbox" onchange="setStatus('.$datas['id'].')" disabled />';
        })
        ->setRowId('posts-{{$id}}')
        ->rawColumns(['action','image','status'])
        ->make(true);
}
public function data(){
        $movies = Post::select('posts.*')->where('status',1)->orderBy('updated_at', 'desc');
         return  response()->json(Datatables::of($movies));
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
        $image=$request->file('images');
        $data=$request->only(['title','description','content']);
        $data['slug']=str_slug($data['title']);
        $data['user_id']=Auth::id();
        $data['image']= 'http://'.request()->getHttpHost().'/images/post/'.time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images/post'), $data['image']);
        Post::create($data);
        return "true";
    
    }
    public function update(PostUpdateRequest $request) {
        $id=$request->only(['id']);
        $data=$request->only(['title','description','content']);
         if ($request->hasFile('image')) {
        $image=$request->file('image');
            $data['image']= 'http://'.request()->getHttpHost().'/images/post/'.time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/post'), $data['image']);
        }
        $boolean=Post::where('id',$id)->update($data);
            return "true";
    }
    public function delete($id){
        Post::find($id)->delete();
        return response()->json(true);
    }
}