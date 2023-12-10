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