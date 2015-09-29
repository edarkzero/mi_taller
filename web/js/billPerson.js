$(document).ready(function (e) {
    $('#voucher-btn').click(function(event)
    {
        event.preventDefault();
        var keys = $("#bill-grid").yiiGridView('getSelectedRows');
        $.pjax.reload({
            container:'#bill-grid-wrapper',
            type: 'POST',data:{selected:keys},
            replace: false
        });
    });
});