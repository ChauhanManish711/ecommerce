@extends('layouts.main')
@section('section')
<div class="text-center">
    <input type="hidden" id="movie_id" value="{{$movie_id}}">
<input type="text" id="datepicker" name="datetimes"/>
</div>
<div id="main_slot" style="display:none" class="mt-4">
<div class="row slots_row mt-3">
    <h2 class="text-center select_slot_heading text-primary">Select Slot</h2>
    <div class="col slots mt-1 text-center">
    </div>
</div>
</div>
<div id="main_seat" class="container w-50 mt-4" style="display:none">
    <h2 class="text-center select_seat_heading text-success">Select Seat</h2>
    <form id="myBooking" action="{{route('booking')}}" method="POST">
    @csrf
    <input type="hidden" id="movie_date_slot_id" name="movie_date_slot_id">
    <div class="row seats">
    </div>
    </form>
</div>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Include jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

$(document).ready(function() {
  $(function() {
    $("#datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0,  // Disallow past dates
        maxDate: '+1w'  // Allow selecting dates within the next week
    });
  });
});

 //on date pick
$("#datepicker").change(function(){
    var date = $(this).val();
    var movie_id = $('#movie_id').val();
    $('.slots').html('');
    $('.seats').html('');
    $('.select_slot_heading').hide();
    $.ajax({
        type: 'GET',
        url: "{{route('slots')}}",
        data:{movie_id:movie_id , date:date},
        success:function(response){
            console.log(response.data);
            $("#main_slot").show();
    $('.select_slot_heading').show();
            $.each(response.data, function (index, value) { 
                    console.log(value);
                    $(".slots").append('<button class="mx-2 slot_time" style="background-color:blue; color:white" value="'+value.id+'">'+value.slot+'</button>');
            });
        }
    });
})

//on select slot
$('.slots').on('click','.slot_time',function(){
    $(".seats").html('');
    $(".select_seat_heading").hide();
    var slotTime = $(this);
    $(".slot_time").css('background-color','blue');
    slotTime.css('background-color','green');
    var id = $(this).val();
    $('#movie_date_slot_id').val(id); 
    localStorage.setItem('movie_date_slot_id',id);
    $(this).prop('disabled',true);
         $.ajax({
            type: 'GET',
            url: "{{route('seats')}}",
            data:{movie_date_slot_id:id},
            success:function(response){
                $(".select_seat_heading").show();
                $("#main_seat").show();
                slotTime.prop('disabled',false);
                console.log(response.data);
                // return;
                // var store =array();
                $.each(response.data, function (index, value) { 
                    if(value.status==1){
                     $(".seats").append('<div class="col-md-4 my-2"><button class="btn btn-primary  disabled mx-1 seats_time" >'+value.seat_name  +'</button></div>');                   
                    }
                    else{
                     $(".seats").append('<div class="col-md-4 my-2"><button type="button" class="btn btn-success mx-1 " >'+ value.seat_name  +' &nbsp;<input type="checkbox" name="seat[]" value="'+value.seat_name+'"></button></div>');  
                    }
                });
        $('.seats').append("<div class='col-md-12 mt-5 book_seat text-center' ><button type='submit' style='color: white;background-color: green;padding: 16px;'>Book Seat</button></div>")
        // console.log(store);
}
});

//on select seat
// $('.seats').on('click','.seats_time',function(){
//         var id = $(this).val();
//         $(this).prop('disabled',true);
//         $.ajax({
//             type: 'GET',
//             url: "{{route('booking')}}",
//             data:{seat:id},
//             success:function(response){
//                 console.log(response);
//                 if(response.data){
//                     alert('Your Seat is successfully booked');
//                 }
//                 if(response.route){
//                     window.location.href = response.route;
//                 }
//             }
//         });
});

</script>
@endsection