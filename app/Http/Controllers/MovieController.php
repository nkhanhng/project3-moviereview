<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Movie;
use App\Rate;
use Yajra\Datatables\Datatables;

class MovieController extends Controller
{

	private $server = 'https://api.themoviedb.org/3/movie/';
	private $api_key = '?api_key=016a4db513f662a17a97292a0d99df49&language=en-US';
	private $img='https://image.tmdb.org/t/p/w220_and_h330_face/';

	public function index(){
		return view('user.index');
	}
	public function list(){
		$movies = Movie::select('movies.*')->where('user_id',Auth::id());
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
                return'<input type="checkbox"  onchange="setStatus('.$datas['id'].')" checked disabled />';
            }
            return'<input type="checkbox" onchange="setStatus('.$datas['id'].')" disabled />';
        })
		->rawColumns(['action','image','status'])
		->setRowId('movies-{{$id}}')
		->make(true);
	}

	public function data(){
		$movies = Movie::select('movies.*')->where('status',1)->orderBy('status', 'desc');
		 return  response()->json(Datatables::of($movies));
	}

	public function get($id){
		$movie= Rate::where('movie_id',$id)->rates;
		return response()->json($movie);
	}

	public function setRate(Request $request){
		if (Auth::check()) {
            $setRate = $request->only(['score','movie_id','comment']);
			$data= Movie::find($setRate['movie_id']);
			$data['rate'] = ($data['rate']*$data['vote']+$setRate['score'])/($data['vote']+1);
			$data['vote'] =  $data['vote']+1;
			$data->save();
			$setRate['user_id']=$Auth::id();
			Rate::create($setRate);
			return "success";
        }
        return 'error';
	}

	public function store(Request $request){

		$data = $this->getInfo($request->key);
		if ($data==false) {
			return response($content = 'key is not exist', $status = 500);
		}
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
		if ($result === FALSE) {return false;}
		$result=str_replace('},]',"}]",$result);
		return json_decode($result);
	}

// use key 'http' even if you send the request to https://...

}
