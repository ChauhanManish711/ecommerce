$(document).ready(function(){
    var product_id = $("#select_product").val();
    var brand_id = $("#select_brand").val();
    if(product_id && brand_id)
    {  
        $("#main_heading").html("Update Item");
        $("#category_container").show('slow');
        $("#brand_container").show('slow');
    }
    else{
        $("#main_heading").html("Add Items");
    $.ajax({
        type:'GET',
        url : "/get_products",
        success:function(response){
        console.log(response);
        $("#select_product").html("");
        $("#category_container").show('slow');
        $("#select_product").append("<option value=''>Choose Category</option>");
        $.each(response.products,function(key , product){
            productName = product.name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });
            $("#select_product").append("<option value="+product.id+">"+productName+"</option>");
        });
        },
        error:function(err){    
            console.log(err);
        }
    });  
    }
});
//choose product
function changeProduct(id){
    // var id = $(this).val();
    $("#brand_container").fadeOut();
    $.ajax({
        type:'GET',
        url : "/get_brands",
        data:{id:id},
        success:function(response){
        console.log(response);
        if(response.brands.length!='0')
        {
            $("#select_brand").html("");
            $("#brand_container").show('slow');
            $("#select_brand").append("<option value='' selected>Choose Brand</option>");
            $.each(response.brands, function(key , brand){
                brandName = brand.name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });
            $("#select_brand").append("<option value='"+brand.id+"'>"+brandName+"</option>");
            });  
        }
        },
        error:function(err){    
            console.log(err);
        }
    });
// });
}
//create product
$('#create_item').submit(function(e){
    e.preventDefault();
    var data =  new FormData(this);
    var url = $(this).attr('action');
    $('#submit').prop("disabled",true);
    $('.errors').html('');
    $.ajax({
        type:'POST',
        url:url,
        data:data,
        processData: false,
        contentType: false,
        success:function(response){
            // console.log(response.location);
            window.location = response.location;
        },
        error:function(err){
            $('#submit').prop("disabled",false);
            $(".errors").html("");
            console.log(err.responseJSON.errors);
            if(err.responseJSON.errors){
                var errors = err.responseJSON.errors;
                var product_id = false;
                $.each(errors ,function(key , value){
                    if(key == 'product_id'){
                        product_id = true;
                    }
                    if(product_id && key=='brand_id'){
                        return null;
                    }
                    else{
                    $("#"+key+"Err").text(value[0]);
                    }
                });
            }
        }
    })
});

$("#image").change(function(){
    const file = this.files[0];
    console.log(file);
    if (file) {
        let reader = new FileReader();
        reader.onload = function (event) {
            $("#imgPreview").attr("src", event.target.result);
            $("#image_preview").show("slow");
        };
        reader.readAsDataURL(file);
    }
});

