$(document).ready(function (e) {
    //$(f_price).maskMoney('unmasked')[0];
    //$(f_price).maskMoney('mask', x);
    $(f_price+","+f_tax+","+f_total).change(function(event)
    {
        calcPrices();
    });
});

function calcPrices()
{
    $.ajax(URL_PRICE,{
        method: 'POST',
        data:{
            p: {
                p_price: $(f_price).maskMoney('unmasked')[0],
                p_tax: $(f_tax).maskMoney('unmasked')[0],
                p_total: $(f_total).maskMoney('unmasked')[0]
            }
        },
        dataType: 'json',
        error: function(jqXHR,textStatus,errorThrow)
        {
            alert(textStatus+": "+errorThrow);
        },
        success: function(data)
        {
            $(f_price).maskMoney('mask', data.price);
            $(f_tax).maskMoney('mask', data.tax);
            $(f_total).maskMoney('mask',data.total);
            $("#price-total").val(data.total);
        }
    });
}