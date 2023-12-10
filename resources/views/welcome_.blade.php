@extends('layouts.main')
@section('section')
@if(Session::has('success'))
<h3 class="text-center text-success mt-2">{{Session::get('success')}}</h3>
@endif
<div class="container">
    <div class="row">
    @forelse ($movies as $movie)
        <div class="col-md-6 mt-3 text-center">
            Movie name : <a href="{{route('date',['movie_id'=>$movie->id])}}">{{$movie->movie_name}}</a> 
        </div>
    @empty     
    <h4>No Record Found !</h4> 
    @endforelse
</div>      
</div>
@endsection