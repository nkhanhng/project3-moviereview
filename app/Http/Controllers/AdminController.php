<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
			<button type="button" class="btn btn-xs btn-warning"data-toggle="modal" onclick="getMovies('.$movie['id'].')" href="#editProduct"><i class="fa fa-pencil" aria-hidden="true"></i></button>
			<button type="button" class="btn btn-xs btn-danger" onclick="alDelete('.$movie['id'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
		}) 
		->editColumn('image',function(Movie $movie){
			return '<img src="'.$movie->image.'" class="image-movie" />';
		})
		->rawColumns(['action','image'])
		->setRowId('movies-{{$id}}')
		->make(true);
	}

	public function data(){
		$movies = Movie::select('movies.*')->orderBy('updated_at', 'desc');
		 return Datatables::of($movies);
	}

	public function get($id){
		
		return response()->json(Movie::find($id));
	}


	public function store(Request $request){

		$data = $this->getInfo($request->key);
		$store=[];
		$store['key'] = $data->id;
		$store['title'] = $data->title;
		$store['rate'] = $data->vote_average;
		$store['vote'] = $data->vote_count;
		$store['description'] = $data->overview;
		$store['image'] = $this->img.$data->poster_path;
		$store['user_id'] = Auth::id();
		Movie::create($store);
		return response()->json(true);
	}
	public function update(Request $request){
		$data=$request->all();
		Movie::find($data['id'])->update($data);
		return response()->json(true);
	}

	public function delete($id){
		Movie::find($id)->delete();
		return response()->json(true);
	}

	protected function getInfo($key){
		$url=  $this->server.$key.$this->api_key;
		$result = file_get_contents($url);
		if ($result === FALSE) {return 'false';}
		$result=str_replace('},]',"}]",$result);
		return json_decode($result);
	}

// use key 'http' even if you send the request to https://...

}
