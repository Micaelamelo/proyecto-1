@extends('layout')

@section('title', "Lista {$usermovie->id}")

@section('content')

<div id="main">
	<h3> Lista #{{ $usermovie->nombre }}<small class="text-muted"> creada por{{$usermovie->creador_id}}</small> 

	@if ( Auth::id()==$usermovie->creador_id)
	
	  <a align="right" href="{{ url("/listas/{$usermovie->id}/addmovie") }}"  class="btn icon-btn btn-success">+ Pelicula</a>

	@endif 
	
</h3>
</div>

	<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
	   <th scope="col"></th>
      <th scope="col">Nombre</th>
      <th scope="col">Director</th>
	   <th scope="col"></th>
	   <th scope="col">#</th>
    </tr>
  </thead>
  <tbody>
   @forelse ($pelis as $movie)
    <tr>
      <th scope="row"></th>
	  <td> <li>{{ $movie->id }}</li> </td>
      <td> <li>{{ $movie->titulo }}</li> </td>
      <td><li>{{ $movie->director }}</li></td>
	  <td>
		<form action="{{ route('movies.delete', ['usermovie'=> $usermovie->id, 
												'movie'=> $movie->id])}}" method="POST">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}
			<button type="submit">Eliminar</button>
		</form>
	  </td>
	   <td>
	  	<a href="{{ route('movies.edit',  ['usermovie'=> $usermovie->id, 
												'movie'=> $movie->id]) }}">Editar</a>
		</td>
    </tr>
  </tbody>
  
  @empty
        
			<li>No hay pelis registradas.</li>
        @endforelse
</table>

@endsection