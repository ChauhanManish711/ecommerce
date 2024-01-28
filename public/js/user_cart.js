//remove item from cart
$(".remove_one").click(function()
{
    var item_id = $(this).val();
    var current_row =$(this);
    var quantity = current_row.parents('.parent_row').find('.quantity');
    var subTotal = current_row.parents('.parent_row').find('.subTotal');
    $.ajax({
        type: 'GET',
        url: "/remove-item",
        data:{item_id:item_id},
        success:function(response){
            console.log(response.data);
            if(response.location)
            {
                window.location = response.location;
            }
            if(response.data)
            {
                alert('Successfully remove.');
                $("#total_price").text("$"+response.data.price_total);
                $("#quantity_total").text(response.data.quantity_total);
                quantity.text(response.data.quantity);
                subTotal.text("$"+response.data.subtotal);
            }
        },error:function(err)
        {
            console.log(err);
        }
    });
});

//add item from cart
$(".add_one").click(function(){
    var item_id = $(this).val();
    $.ajax({
        type:'GET',
        url:'/add-to-cart',
        data:{item_id:item_id},
        success:function(response){
            console.log(response);
            if(response.message == '2')
            {
                alert('Item is out of stock.');
            }else if(response.message == '1')
            {
             alert('Successfully added');
            window.location = window.location.href;
            }
        },error:function(err){
            console.log(err);
        }
    });
});