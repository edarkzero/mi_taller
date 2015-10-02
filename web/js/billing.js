var s2Size = null;
var s2Color = null;
var s2Damage = null;

var carSlideImg = '#car-slide .item img';
var carSlideMap = '#car-slide .item map';
var carSlideImgActive = '#car-slide .item.active img';
var carSlideMapActive = '#car-slide .item.active map';

var s_view_extension = '.png';
var default_car_selection = 'medium';
var default_car_full_selection = '7';

var s_extra_big = 5;
var s_big = 4;
var s_medium = 3;
var s_small = 2;
var bill_mode = 0;
var $last_area = null;
var was_selected_area = null;
var selected_car_full = null;
var modal_full_mode = false;
var ctrl_pressed = false;

var tiny_left_area = '';
var tiny_right_area = '';
var medium_left_area = '<area data-tabulator="' + s_small + '" shape="poly" coords="391,151,394,145,405,142,413,141,420,144,431,144,437,148,434,151,426,153,420,154,419,157,412,159,406,159,400,159,394,155,391,151" alt="" /><area data-tabulator="' + s_medium + '" shape="poly" coords="435,146,432,145,419,145,415,141,406,141,398,144,393,147,391,151,394,154,399,157,405,159,411,160,418,159,422,153,430,153,438,147,439,151,436,168,433,189,433,219,434,230,434,242,403,243,366,244,318,244,250,244,246,233,242,219,240,206,238,186,239,167,241,148,249,135,254,131,271,120,292,108,312,96,341,81,368,72,389,66,412,64,430,63,449,62,456,63,452,84,447,114,443,131,439,148" alt="" /><area data-tabulator="' + s_medium + '" shape="poly" coords="761,130,749,118,697,115,670,104,608,77,554,61,496,55,428,55,390,59,353,68,303,90,241,125,251,133,302,101,343,79,398,63,459,60,518,65,567,76,607,93,625,105,626,108,607,121,614,136" alt="" /><area data-tabulator="' + s_medium + '" shape="poly" coords="543,224,559,225,588,184,620,174,653,180,671,193,688,220,691,240,690,255,733,248,763,247,793,239,795,195,800,193,796,184,784,180,774,168,772,155,762,130,716,129,681,132,646,134,610,136,590,166,562,197,543,224" alt="" /><area data-tabulator="' + s_medium + '" shape="poly" coords="232,247,231,263,557,261,558,223,544,225,525,240,507,243,232,247" alt="" /><area data-tabulator="' + s_medium + '" shape="poly" coords="20,171,33,160,68,148,148,132,181,128,214,128,174,135,114,145,80,153,41,167,37,171" alt="" /><area data-tabulator="' + s_medium + '" shape="poly" coords="232,245,223,207,205,185,179,175,155,172,132,181,114,197,101,226,98,240,99,252,97,259,9,249,10,243,35,241,52,239,66,213,10,217,10,208,5,206,23,185,46,164,98,147,168,135,242,126,251,133,243,146,238,167,238,203,249,244" alt="" />';
var medium_right_area = '<area data-tabulator="' + s_big + '" shape="poly" coords="41,130,53,118,105,115,131,104,193,77,247,61,305,55,373,55,411,59,448,68,499,90,561,125,550,133,500,101,458,79,403,63,342,60,283,65,234,76,195,93,177,105,175,108,195,121,188,136" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="259,224,242,225,213,184,182,174,148,180,130,193,114,220,111,240,111,255,68,248,38,247,8,239,7,195,1,193,5,184,18,180,28,168,29,155,40,130,85,129,121,132,155,134,191,136,212,166,239,197,259,224" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="569,247,570,263,245,261,244,223,258,225,276,240,295,243,569,247" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="781,171,768,160,734,148,653,132,620,128,588,128,628,135,688,145,722,153,761,167,764,171" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="570,245,578,207,597,185,623,175,647,172,670,181,688,197,701,226,704,240,702,252,704,259,792,249,792,243,767,241,749,239,736,213,792,217,792,208,797,206,779,185,755,164,704,147,634,135,560,126,551,133,559,146,563,167,563,203,552,244" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="341,60,269,68,202,89,177,107,195,123,189,138,277,242,367,243,366,180,364,165,357,126,341,60" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="553,243,563,207,563,163,557,138,457,75,397,61,342,59,363,151,367,242,553,243" alt="" />';
var medium_front_area = '<area data-tabulator="' + s_big + '" shape="poly" coords="549,127,578,127,591,123,595,113,590,106,578,101,563,97,557,99,555,113,554,119,549,119,549,127"  alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="253,127,224,127,211,123,207,113,212,106,224,101,239,97,245,99,247,113,248,119,253,119,253,127"  alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="260,126,298,161,325,184,348,199,392,210,407,210,450,200,472,188,499,161,530,136,540,126,507,124,414,123,347,123,260,126"  alt="" />';
var big_left_area = '<area data-tabulator="' + s_big + '" shape="poly" coords="219,175,229,176,236,170,248,166,265,166,279,167,288,171,293,176,298,185,300,194,302,201,309,201,310,199,308,192,306,184,303,177,297,167,289,161,280,158,266,156,255,156,245,156,235,160,225,166" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="229,176,198,175,195,177,194,180,195,186,197,193,198,199,202,205,207,205,213,204,218,204" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="405,98,457,98,464,103,477,135,478,148,478,159,470,160,460,165,451,179,447,191,444,198,402,197,400,178,400,143,402,117" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="307,186,306,165,308,144,321,128,343,108,359,97,405,97,401,123,400,144,399,162,399,177,401,197,370,198,310,198" alt="" />';
var big_right_area = '<area data-tabulator="' + s_big + '" shape="poly" coords="582,175,572,176,565,170,553,166,536,166,522,167,514,171,508,176,503,185,501,194,500,201,492,201,491,199,493,192,496,184,499,177,504,167,512,161,521,158,535,156,546,156,556,156,566,160,576,166" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="572,176,603,175,606,177,607,180,606,186,604,193,603,199,599,205,594,205,588,204,583,204" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="396,98,344,98,338,103,324,135,323,148,323,159,331,160,341,165,350,179,354,191,357,198,399,197,402,178,402,143,399,117" alt="" /><area data-tabulator="' + s_big + '" shape="poly" coords="494,186,495,165,493,144,480,128,458,108,442,97,396,97,400,123,401,144,402,162,402,177,401,197,431,198,491,198" alt="" />';
var pickup_left_area = '';
var pickup_right_area = '';

$(document).ready(function (e)
{
    $('.car-select-option').click(function (e)
    {
        var glue = '/';
        var $s_car_image = $(this).children();
        var s_car = $s_car_image.attr('data-car');
        selected_car_full = $s_car_image.attr('data-car-full');
        var $s_view_images = $(carSlideImg);
        $.each($s_view_images, function (index, s_view_image)
        {
            var $s_view_image = $(s_view_image);
            var s_view = $s_view_image.attr('data-view');
            var new_src = s_car + "-" + s_view + s_view_extension;
            var old_src = $s_view_image.prop('src');
            var string_parts = old_src.split(glue);
            var string_target = string_parts.length - 1;
            string_parts[string_target] = string_parts[string_target].replace(string_parts[string_target], new_src);
            $s_view_image.prop('src', string_parts.join(glue));
        });

        $('html, body').animate({
            scrollTop: $(".breadcrumb").offset().top
        }, 100);

        highlightControl(s_car);
    });

    $(document).on('click', 'area', function (e)
    {
        var $elem = $(this);
        $last_area = $elem;
        var isSelectedElem = isHighlighted($elem);
        highlightSelected($elem, !isSelectedElem);
        was_selected_area = false;

        if(!ctrl_pressed) {
            if (!isSelectedElem) {
                showPartModal($elem.attr('data-tabulator'), false);
            }

            else {
                storeChanges(1);
            }
        }
        else
        {
            alert('Probando, función en desarrollo.');
        }
    });

    $('#item-submit-modal').click(function (e)
    {
        e.preventDefault();
        storeChanges(0);
    });

    $('#bill-submit').click(function (e)
    {
        e.preventDefault();
        bill_mode = 0;

        if ($('#total-disp').html() != money_default_value)
            $('#bill-discount-modal').modal('show');
    });

    $('#bill-submit-print').click(function (e)
    {
        e.preventDefault();
        bill_mode = 1;

        if ($('#total-disp').html() != money_default_value)
            $('#bill-discount-modal').modal('show');
    });

    $('#discount-submit-modal').click(function (e)
    {
        e.preventDefault();
        storeBill();
    });

    $('#cancel-discount-submit-modal').click(function (e)
    {
        e.preventDefault();
        jQuery("#bill-discount-disp").maskMoney('mask', 0.00);
        storeBill();
    });

    $('#bill-discount-modal').on('show.bs.modal', function (e)
    {
        jQuery("#bill-discount-disp").maskMoney(maskMoney_5377137b);

        var val = parseFloat(jQuery("#bill-discount").val());
        jQuery("#bill-discount-disp").maskMoney('mask', val);
    });

    $('#part-detail-modal').on('hide.bs.modal', function (e)
    {
        if (!was_selected_area) {
            if (!modal_full_mode)
                highlightSelected($last_area, false);
            else
                highlightAll($('area'), false, false);
        }
    });

    $('#bill-type').change(function (event) {
        var bill_mode = $(this).val();

        $.pjax.reload({
            container:'#bill-grid-wrapper',
            type: 'POST',data:{bill_mode: bill_mode}
        });
    });

    highlightControl(default_car_selection);
});

$(document).bind("keyup keydown", function (e)
{
    if (e.ctrlKey) {
        ctrl_pressed = true;
    }
});

function highlightControl(s_car)
{
    $(carSlideImg).each(function (index, elem)
    {
        var $elem = $(elem);
        var s_view = $elem.attr('data-view');
        var s_map = '#map-' + s_view;

        if (eval("typeof("+s_car + '_' + s_view + "_area) != \"undefined\"")) {
            $(s_map).html(eval(s_car + '_' + s_view + "_area"));
            $elem.maphilight({strokeColor: '#009688', strokeOpacity: 1, strokeWidth: 1});
        }
    });
}

function isHighlighted($elem)
{
    var hData = $elem.data('maphilight') || {};
    return hData.alwaysOn;
}

function highlightSelected($elem, state)
{
    var hData = $elem.data('maphilight') || {};
    hData.alwaysOn = state;
    $elem.data('maphilight', hData).trigger('alwaysOn.maphilight');
}

function highlightOnlySelected($clickedElem, $areaElements)
{
    $areaElements.each(function ()
    {
        highlightSelected($(this), $(this).is($clickedElem));
    });
}

function highlightAll($areaElements, state, store)
{
    if (selected_car_full == null)
        selected_car_full = default_car_full_selection;
    was_selected_area = false;

    if (store) {
        if (state) {
            showPartModal(selected_car_full, true);
        }
        else
            storeChanges(1);
    }

    $areaElements.each(function (index, data)
    {
        highlightSelected($(this), state);
    });
}

function storeChanges(mode)
{
    var q = null;
    was_selected_area = true;

    q = $('#item-form-modal').serialize() + "&mode=" + mode;

    $.ajax('store-changes', {
        data: q,
        dataType: 'json',
        method: 'POST',
        success: function (data)
        {
            $('#part-detail-modal').modal('hide');

            if (!data.error) {
                $('#total-disp').html(data.total);
            }
            else {
                if (!modal_full_mode)
                    highlightSelected($last_area, false);

                $('#error-modal .modal-body').html(data.message);
                $('#error-modal').modal('show');
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#error-modal .modal-body').html(textStatus + ", " + errorThrown);
            $('#error-modal').modal('show');
        }
    });
}

function storeBill()
{
    var data = $('#vehicle-details').serialize();
    data += '&mode='+bill_mode+'&discount='+$('#bill-discount-disp').maskMoney('unmasked')[0];

    $.ajax('create', {
        data: data,
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
}

function showPartModal(selectedSize, modalMode)
{
    modal_full_mode = modalMode;
    $('#part-detail-modal').modal('show');
    jQuery.when(jQuery('#carpart-size_id').select2(window[$('#carpart-size_id').attr('data-krajee-select2')]));
    jQuery.when(jQuery('#carpart-color_id').select2(window[$('#carpart-color_id').attr('data-krajee-select2')]));
    jQuery.when(jQuery('#carpart-damage_id').select2(window[$('#carpart-damage_id').attr('data-krajee-select2')]));
    $('#carpart-size_id').val(selectedSize).trigger('change');
}