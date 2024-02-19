@extends('..user.main')
@section('main')
<div class="text-center">
    @if(Session::has('success'))
        <h3 class="text-success">{{Session::get('success')}}</h3>
    @endif
</div>
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
            <tr class="parent_row">
                <td>{{$cart->name}}</td>
                <td class="price">${{$cart->price}}</td>
                <td class="quantity">{{$cart->pivot->quantity}}</td>
                <td class="subTotal">${{$cart->price * $cart->pivot->quantity}}</td>
                <td>
                    <button class="btn btn-secondary remove_one" value="{{$cart->id}}"><i class="fa fa-minus" aria-hidden="true"></i></button> 
                   <button class="btn btn-success add_one" value="{{$cart->id}}"><i class="fa-solid fa-plus"></i></button>
                   <a href="{{route('delete_cart',['item'=>$cart->id])}}" class="btn btn-danger remove_all" value="{{$cart->id}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
        @endforeach
        <tr>
            <th></th>
            <th>Total</th>
            <th id="quantity_total">{{$quantity_total}}</th>
            <th id="total_price">${{$total_price}}</th>
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