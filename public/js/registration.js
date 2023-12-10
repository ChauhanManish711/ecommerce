$('#createUpdateUser').submit(function(e){
    e.preventDefault();
    var data =  new FormData(this);
    var url = $(this).attr('action');
    // $('.submit').prop("disabled",true);
    $('.errors').html('');
    $.ajax({
        type:'POST',
        url:url,
        data:data,
        processData: false,
        contentType: false,
        success:function(response){
            console.log(response);
            // var response = JSON.parse(response);
            $('.submit').prop("disabled",false);
            if(response.errors){
                $('.password').val('');
                $.each(response.errors,function(feildname,messages){  
                  $('#'+feildname+'Err').html(messages[0])
                })
            return;
            }
            if(response.error){
                $('#error').html(response.error);
            return;
            }
            if(response.location){
            window.location.href = response.location;
            }
        },
        error:function(err){
            console.log(err);
        }
    })
})