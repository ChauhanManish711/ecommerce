$(document).ready(function() {
    var progressText = $('#progress').text();
    if(progressText)
    {
        // console.log($('#progress').text());
        var progress = $("#progress").text();
        if(progress<100)
        {
            $("#test_jobs").hide();
            window.setTimeout(function(){
                // Move to a new location or you can do something else
                window.location.href = window.location;
            }, 1000); 
        }
        if(progress==100)
        {
            setTimeout(function(){
            window.location.href = '/all_activities';
            },2000);
        }
    }
});
$('#logout').click(function(){
    $('#logoutModal').modal('show');
});
$('.user_profile').click(function(){
    // $('#user_profile').modal('show');
    $('#user_image').html("");
    var id = $(this).val();
    $.ajax({
        type:'GET',
        url : "/user-profile",
        data:{id:id},
        success:function(response){
            $('#userModalLongTitle').text(""+response.user.name+"")
            $("#user_profile").modal('show');
            $('#name').text(response.user.name)
            $('#email').text(response.user.email)
            $("#user_image").html("<img src=images/"+response.user_image.image+"  style = 'border-radius: 50%;'  width='200' height='200'>")
        },
        error:function(err){    
            console.log(err);
        }
    });
});

$("#addRole").click(function(){
    $("#rolesModal").modal('show');
});
$("#choose_permission").hover(function(){
    $(this).css('cursor','pointer');
});
$("#choose_permission").click(function(){
    $("#select_permission").toggle();
});
$("#roles").on('change',function(){
    if($(this).val() == '6')
    {
        $("#image_row").hide();
    }
    else{
        $("#image_row").show();
    }
});
$(".permissions").hover(function(){
    $('.permissions').css("cursor", "pointer");
    $(this).css("background-color", "blue");
    $(this).css("color", "white");
});
$(".permissions").mouseleave(function(){
    $(this).css("background-color", "lightblue");
    $(this).css("color", "");
});
$("#checkbox").change(function(){
        if(this.checked)
        {
            $('.checkbox').prop('checked', true);
        }
        else{
            $('.checkbox').prop('checked', false);
        }

});