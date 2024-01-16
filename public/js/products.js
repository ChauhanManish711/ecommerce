$(document).ready(documentReady(null,null,null));

function documentReady(brand_id,search,page){
    var brand_id = brand_id;
    var search = search;
    var page = page;
    $.ajax({
        type:'GET',
        url : '/items',
        data:{brand_id:brand_id , search:search,page:page},
        success:function(response){
            // console.log(response);
            // var specific_product = $("#specific_product option:selected").text();
            // $("#record_listing_heading").html('All '+specific_product+'');
            $("#record_listing_body").html("");
            $("#record_listing_container").hide();
            // $("#record_listing_container").show('slow');
            $("#record_listing_container").show();
            $("#pagination").html("");
            if(response.data.data.length>0){
            //for pagination
            $.each(response.data.data,function(key ,value){
                console.log(response.data.data);
                $("#record_listing_body").
                append
                ("<tr><td>"+value.name.charAt(0).toUpperCase() + value.name.slice(1)+"</td><td>"
                +value.product_name+"</td><td>"+value.price+
                "</td><td>"+value.quantity+"</td><td><button class='btn btn-success view_item' value="+value.id+
                ">View</button> <a class='btn btn-primary edit_item' href='/edit_item/"+value.id+"'>Edit</a> <a href='/delete_item/"+value.id+"' class='btn btn-danger trash_item' value='"+value.id+"'>Delete</a></td></tr>")
            });
            //for pagination
            $.each(response.data.links,function(key , value){
                if(key != 0 && key!= Number(response.data.links.length) - 1)
                {
                    $("#pagination").append("<button class='btn-primary paginate'style='padding:8px;width:4%;' value='"+key+"'>"+key+"</button>");
                }  
            });
            }
            else
            {
                $("#record_listing_body").append
                ("<br><tr><td></td><td>No item found</td></tr>")
            }
        },
        error:function(err){    
            console.log(err);
        }
    });
};
//pagination event
$("#pagination").click('.paginate',function(e){
    //get url
    var page = e.target.value;
    //get product id
    var brand_id = $("#brands").val();
    var search = $("#search_item").val();
    documentReady(brand_id,search,page)
    // // $.ajax({
        // //     type:'GET',
        // //     url:url,
        // //     data:{brand_id:brand_id,search:search},
        // //     success:function(response){
        // //         console.log(response);
        // //        //for pagination
        // //        $("#record_listing_body").html("");
        // //        $("#record_listing_container").hide();
        // //        $("#record_listing_container").show('slow');
        // //         $.each(response.data.data,function(key ,value){
        // //             $("#record_listing_body").append
        // //             ("<tr><td>"+value.name+"</td><td>"+value.product_name+"</td><td>"+value.price+"</td><td><button class='btn btn-success' id='view'>View</button></td></tr>")
        // //         });
        // //     },
        // //     error:function(err){
        // //         console.log(err);
        // //     }
    // })
});

//brands
$("#specific_product").change(function(){
    $("#brands").hide();
    var id = $(this).val();
    if(id=="")
    {
        return;
    }
    $.ajax({
        type:'GET',
        url : "/get_brands",
        data:{id:id},
        success:function(response){
        console.log(response);
        if(response.brands.length!='0')
        {
            $("#brands").html("");
            $("#brands").append("<option value='' selected>Choose Brand</option>");
            $.each(response.brands, function(key , brand){
                brandName = brand.name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });
            $("#brands").append("<option value='"+brand.id+"'>"+brandName+"</option>");
            });  
            $("#brands").show('slow');
        }
        },
        error:function(err){    
            console.log(err);
        }
    });
});

$("#brands").change(function(){
    var brand_id = $(this).val();
    var search = $("#search_item").val();
    documentReady(brand_id,search);
});

//serach item
$("#search_item").keyup(function()
{
    var search = $("#search_item").val();
    var brand_id = $("#brands").val();
    documentReady(brand_id,search,null);
});

$(document).on('click', '.view_item', function() {
    // Your code here
    var item_id = $(this).val();
    $.ajax({
        type:'GET',
        url : '/get_item',
        data:{item_id:item_id},
        success:function(response){
            console.log(response);
            $("#item_model").modal('show');
            $("#item_modelTitle").text(response.item.name); 
            $("#model_image").html("<img src='images/"+response.image+"' width='150' height='250'>");
            $("#description").html("<span>"+response.item.name+"</span><br>");
            $("#description").append("<b>Price: </b><span>"+response.item.price+"</span><br>");
            $("#description").append("<b>Desciption: </b><span>"+response.item.description+"</span>");
        },
        error:function(err){    
            console.log(err);
        }
    });
});

//
$(document).on('click','.trash_item',function(){
var item_id = $(this).val();
$.ajax({
    type:'GET',
    url:'delete_item',
    data:{item_id:item_id},
    success:function(response){
        if(response.redirect)
        {
            window.location = response.redirect;
        }
    },
    error:function(err){
        
    }
});
});
//edit
