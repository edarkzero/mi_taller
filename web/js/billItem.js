$(document).ready(function (e) {
    $('#item-submit-modal').click(function(event)
    {
        var item_keys = $('#item-grid').yiiGridView('getSelectedRows');
        var bill_keys = $('#bill-grid').yiiGridView('getSelectedRows');

        $.ajax('index', {
            data: {iks: item_keys, bks: bill_keys,assign_mode:1},
            dataType: 'json',
            method: 'POST',
            success: function (data)
            {
                $('#error-modal .modal-body').html(data.message);
                $('#error-modal').modal('show');
                window.location.replace("index");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $('#error-modal .modal-body').html(textStatus + ", " + errorThrown);
                $('#error-modal').modal('show');
            }
        });
    });

    $('#cancel-item-submit-modal').click(function(event)
    {

    });

    $('#select-button').click(function(event)
    {
        event.preventDefault();
        var keys = $("#bill-grid").yiiGridView('getSelectedRows');
        $.pjax.reload({
            container:'#item-grid-wrapper',
            type: 'GET',data:{selected:keys[0]},
            replace: false
        });
    });

    $('#item-grid-wrapper').on('pjax:success', function(data, status, xhr, options)
    {
        $('#modal-assignment').modal('show');
    });

    $('#item-grid-wrapper').on('pjax:error', function(xhr, textStatus, error, options)
    {
        $('#error-modal .modal-body').html(textStatus + ", " + errorThrown);
        $('#error-modal').modal('show');
    });
});