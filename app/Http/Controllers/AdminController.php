<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Movie;
use Yajra\Datatables\Datatables;
class AdminController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }
private $server = 'https://api.themoviedb.org/3/movie/';
	private $api_key = '?api_key=016a4db513f662a17a97292a0d99df49&language=en-US';
	private $img='https://image.tmdb.org/t/p/w220_and_h330_face/';

	public function index(){
		return view('admin.index');
	}
	public function list(){
		$movies = Movie::select('movies.*');
		return Datatables::of($movies)
		->addColumn('action', function ($movie) {
			return'
			<button type="button" class="btn btn-xs btn-danger" onclick="alDelete('.$movie['id'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
		}) 
		->editColumn('image',function(Movie $movie){
			return '<img src="'.$movie->image.'" class="image-movie" />';
		})
		->editColumn('status',function($datas){
            if ($datas->status) {
                return'<input type="checkbox"  onchange="setStatus('.$datas['id'].')" checked/>';
            }
            return'<input type="checkbox" onchange="setStatus('.$datas['id'].')"/>';
        })
		->rawColumns(['action','image','status'])
		->setRowId('movies-{{$id}}')
		->make(true);
	}

	public function data(){
		$movies = Movie::select('movies.*')->orderBy('stauts', 'desc');
		 return  response()->json(Datatables::of($movies));
	}
	public function status(Request $request){
		$id = $request->id;
		$data= Movie::find($id);
		if ($data->status) {
			$data->status=0;
		}else{
			$data->status=1;
		}
		$data->save();
		return "true";
	}

	public function get($id){
		
		return response()->json(Movie::find($id));
	}


	public function delete($id){
		Movie::find($id)->delete();
		return response()->json(true);
	}

// use key 'http' even if you send the request to https://...

}
