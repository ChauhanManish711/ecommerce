@extends('user.main')
@section('main')
    {{-- <p>Welcome , {{ucfirst(auth()->user()->name)}}</p> --}}
    @if(isset($items))
    <div class="container mt-2">
        <div class="row">
            <div class="col text-center">
                <h3 id="msg_success" class="text-success"></h3>
            </div>
        </div>
        <div class="row">
            @foreach($items as $item)
                <div class="col-md-4">
                    <img src="{{asset('images/'.$item->image->image)}}" alt="Trulli" width="280" height="230"><br>
                    Name : {{$item->name}} <br>
                    Price : {{$item->price}}<br>
                    <button class="btn btn-success addCart" value="{{$item->id}}">Add to cart</button>
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endsection
@section('pagescript')
<script>
    $('.addCart').on('click',function(){
        $(this).attr('disabled', true);
        var item_id = $(this).val();
        $.ajax({
            url: "{{route('add-to-cart')}}",
            type: "GET",
            data: {item_id : item_id},
            success: function(response){
                $('.addCart').attr('disabled', false);
                if(response.message == '1')
                {
                    $("#msg_success").text('A product is successfully added to cart.');
                }   
                else if(response.message == '2')
                {
                    $("#msg_success").text('This product is out of stock.');
                }
            }
        });
    });
</script>
@endsection