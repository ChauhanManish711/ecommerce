@extends('..user.main')
@section('main')
<h2 class="text-center text-primary mt-4">Cart</h2>
@if($user_cart->count()>0)
<div class="text-center">
    <table class="table">
        <thead>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </thead>
        @foreach($user_cart as $cart)
            <tr>
                <td>{{$cart->name}}</td>
                <td>${{$cart->price}}</td>
                <td>{{$cart->pivot->quantity}}</td>
                <td>${{$cart->price * $cart->pivot->quantity}}</td>
                <td>
                    <button class="btn btn-secondary" id="remove_one" value="{{$cart->pivot->id}}">-</button> 
                   <button class="btn btn-success" id="add_one" value="{{$cart->pivot->id}}">+</button>
                   <button class="btn btn-danger" id="remove_all" value="{{$cart->pivot->id}}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </td>
            </tr>
        @endforeach
        <tr>
            <th></th>
            <th>Total</th>
            <th>{{$quantity_total}}</th>
            <th>${{$total_price}}</th>
        </tr>
    </table>    

@else
<table class="table">
    <tr>
        <td>No record found !</td>
    </tr>
</table>
</div>
@endif

@endsection
@section('pagescript')
@endsection