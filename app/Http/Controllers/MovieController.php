<?php

namespace App\Http\Controllers;
use App\Usermovie;
use App\User;
use Auth;
use App\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(){
		
	
	$listas = Usermovie::all();
	$user= User::all();
		
	return view('home', ['listas'=> $listas, 
						  'title'=> 'Listas públicas ',
						  'users' => $user]); 
	}

	public function show($id){
		$usermovie= Usermovie::find($id);
		
		$pelis=Movie::where('lista',$usermovie->id)->get();

		$user=User::where('id', $usermovie->creador_id)->first();
		return view('lists.showlist',['pelis'=> $pelis, 'usermovie'=> $usermovie, 'user'=> $user]);
	}
	
	public function create(){
		return view('lists.createlist');
	}
	
	public function store(){
		$user = Auth::user();
		request()->validate([
			'nombre' => ['required', 'min:3'],
		]);
		
		$public = request('public') == "on" ? 1 : 0;
		
	    Usermovie::create([
           	'nombre' => request('nombre'),
			'creador_id' => auth()->id(),
			'public' => $public
        ]);

		return redirect('/home');
	}
	
	public function edit(Usermovie $usermovie){
	$auth_id =  Auth::id();
	
		if($auth_id==$usermovie->creador_id)
			return view('lists.editlist', ['usermovie'=> $usermovie]);
		else
			return redirect('/home');
						
	}
	
	public function update(Usermovie $usermovie){
	$auth_id =  Auth::id();
		
	if($auth_id==$usermovie->creador_id){
		$usermovie->nombre = request('nombre');
		request('public') == "on" ? 1 : 0;
		$usermovie->public = request('public') == "on" ? 1 : 0;
        $usermovie->save();
		
		return redirect()->route('lists.show', ['usermovie'=> $usermovie]);
	}
	else
		return redirect('/home');
	}
	
	public function destroy(Usermovie $usermovie){
		$auth_id =  Auth::id();
	
		$peli=Movie::where('lista',$usermovie->id)->get();
		
		if($auth_id==$usermovie->creador_id){
			foreach ($peli as $movie){
				$movie->delete();
			}
			
			$usermovie->delete();
			
			//Para ir otra vez a home
			$listas = Usermovie::all();
			$user= User::all();
			
			return view('home', ['listas'=> $listas, 
							  'title'=> 'Listas públicas ',
							  'users' => $user]);
		}
		else
			return redirect('/home');
	}
	

}
