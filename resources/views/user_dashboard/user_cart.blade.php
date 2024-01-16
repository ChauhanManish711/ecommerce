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
                    <button class="btn btn-secondary remove_one" value="{{$cart->pivot->id}}"><i class="fa fa-minus" aria-hidden="true"></i></button> 
                   <button class="btn btn-success add_one" value="{{$cart->pivot->id}}"><i class="fa-solid fa-plus"></i></button>
                   <button class="btn btn-danger remove_all" value="{{$cart->pivot->id}}"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
<script>
    $(".remove_one").click(function()
    {
        var user_item_id = $(this).val();
        $.ajax({
            type: 'GET',
            url: "{{route('remove_item')}}",
            data:{user_item_id:user_item_id},
            success:function(data){
                console.log(data);
            },error:function(err)
            {
                console.log(err);
            }
        });
    });
</script>
@endsection