$(document).ready(function (e) {
    $('.table-select-all tr').click(function(event)
    {
        GridViewToggleSelected(this,false);
    });

    $('.table-select-one tr').click(function(event)
    {
        var $all_tr = $('.table-select-one tr');

        $all_tr.each(function(index,tr)
        {
            GridViewToggleSelected(tr,true);
        });

        GridViewToggleSelected(this,false);
    });

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

function GridViewToggleSelected(elem,deselect)
{
    var $tr = $(elem);
    var $td = $tr.find('td:last-child input');

    if(!deselect) {
        var newStatus = !$td.prop('checked');
        $td.prop('checked', newStatus);
        $tr.toggleClass('success');
    }
    else {
        $td.prop('checked', false);
        $tr.removeClass('success');
    }
}