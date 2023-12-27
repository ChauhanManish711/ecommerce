@extends('user.main')
@section('main')
    <p>Welcome , {{ucfirst(auth()->user()->name)}}</p>
    @if(isset($items))
   <div class="container">
    <div class="row">
        @foreach($items as $item)
            <div class="col-md-4 m-1" style="border:1px solid black;">
                <img src="{{asset('images/'.$item->image->image)}}" alt="Trulli" width="300" height="250"><br>
                Name : {{$item->name}} <br>
                Price : {{$item->price}}<br>
                <button class="btn btn-success">Add to cart</button>
            </div>
        @endforeach
    </div>
   </div>
    @endif
@endsection