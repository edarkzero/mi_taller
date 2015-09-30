$(document).ready(function (e) {
    $('#voucher-btn').click(function(event)
    {
        event.preventDefault();
        reloadBillPersonData('#voucher-wrapper',0);
    });

    $('#bp-submit-modal').click(function(event)
    {
        event.preventDefault();
        reloadBillPersonData('#bill-grid-wrapper',1);
    });

    $('#cancel-bp-submit-modal').click(function(event)
    {
        event.preventDefault();
        $.pjax.reload({container:'#bill-grid-wrapper'});
    });

    $('#voucher-wrapper').on('pjax:success', function(data, status, xhr, options)
    {
        $('#modal-voucher').modal('show');
    });

    $('#bill-grid-wrapper').on('pjax:success', function(data, status, xhr, options)
    {
        $('#modal-voucher').modal('hide');
    });

    $('#voucher-wrapper, #bill-grid-wrapper').on('pjax:error', function(xhr, textStatus, error, options)
    {
        $('#error-modal .modal-body').html(textStatus + ", " + errorThrown);
        $('#error-modal').modal('show');
    });
});

function reloadBillPersonData(wrapper,mode)
{
    var keys = $("#bill-grid").yiiGridView('getSelectedRows');
    $.pjax.reload({
        container:wrapper,
        type: 'POST',data:{selected:keys,mode: mode},
        replace: false
    });
}