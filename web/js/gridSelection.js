$(document).ready(function (e) {
    $(document).on('click','.table-select-all tr',function(event)
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

    if (!deselect) {
        var newStatus = !$td.prop('checked');
        $td.prop('checked', newStatus);
        $tr.toggleClass('success');
    }
    else {
        $td.prop('checked', false);
        $tr.removeClass('success');
    }
}