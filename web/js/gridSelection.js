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

function GridViewGetSelected(id)
{
    var keys = $(id).yiiGridView('getSelectedRows');

    /*$.ajax('create', {
        data: {selected:keys},
        dataType: 'json',
        method: 'POST',
        success: function (data)
        {
            $('#error-modal .modal-body').html(data.message);
            $('#error-modal').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#error-modal .modal-body').html(textStatus + ", " + errorThrown);
            $('#error-modal').modal('show');
        }
    });*/

    $('#modal-assignment').modal('show');
}