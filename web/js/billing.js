var carSlideImg = '#car-slide .item img';
var carSlideMap = '#car-slide .item map';
var carSlideImgActive = '#car-slide .item.active img';
var carSlideMapActive = '#car-slide .item.active map';

var s_view_extension = '.png';
var default_car_selection = 'sedan';

var sedan_left_area = '<area data-part="door" data-tabulator="'+Math.random()+'" shape="poly" coords="761,130,749,118,697,115,670,104,608,77,554,61,496,55,428,55,390,59,353,68,303,90,241,125,251,133,302,101,343,79,398,63,459,60,518,65,567,76,607,93,625,105,626,108,607,121,614,136"  alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="543,224,559,225,588,184,620,174,653,180,671,193,688,220,691,240,690,255,733,248,763,247,793,239,795,195,800,193,796,184,784,180,774,168,772,155,762,130,716,129,681,132,646,134,610,136,590,166,562,197,543,224"  alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="232,247,231,263,557,261,558,223,544,225,525,240,507,243,232,247"  alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="20,171,33,160,68,148,148,132,181,128,214,128,174,135,114,145,80,153,41,167,37,171"  alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="232,245,223,207,205,185,179,175,155,172,132,181,114,197,101,226,98,240,99,252,97,259,9,249,10,243,35,241,52,239,66,213,10,217,10,208,5,206,23,185,46,164,98,147,168,135,242,126,251,133,243,146,238,167,238,203,249,244"  alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="461,60,533,68,599,89,625,107,606,123,612,138,525,242,435,243,435,180,437,165,444,126,461,60"  alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="249,243,238,207,238,163,244,138,344,75,404,61,459,59,438,151,435,242,249,243"  alt="" />';
var sedan_right_area = '<area data-tabulator="'+Math.random()+'" shape="poly" coords="41,130,53,118,105,115,131,104,193,77,247,61,305,55,373,55,411,59,448,68,499,90,561,125,550,133,500,101,458,79,403,63,342,60,283,65,234,76,195,93,177,105,175,108,195,121,188,136" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="259,224,242,225,213,184,182,174,148,180,130,193,114,220,111,240,111,255,68,248,38,247,8,239,7,195,1,193,5,184,18,180,28,168,29,155,40,130,85,129,121,132,155,134,191,136,212,166,239,197,259,224" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="569,247,570,263,245,261,244,223,258,225,276,240,295,243,569,247" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="781,171,768,160,734,148,653,132,620,128,588,128,628,135,688,145,722,153,761,167,764,171" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="570,245,578,207,597,185,623,175,647,172,670,181,688,197,701,226,704,240,702,252,704,259,792,249,792,243,767,241,749,239,736,213,792,217,792,208,797,206,779,185,755,164,704,147,634,135,560,126,551,133,559,146,563,167,563,203,552,244" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="341,60,269,68,202,89,177,107,195,123,189,138,277,242,367,243,366,180,364,165,357,126,341,60" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="553,243,563,207,563,163,557,138,457,75,397,61,342,59,363,151,367,242,553,243" alt="" />';
var wagon_left_area = '<area data-tabulator="'+Math.random()+'" shape="poly" coords="219,175,229,176,236,170,248,166,265,166,279,167,288,171,293,176,298,185,300,194,302,201,309,201,310,199,308,192,306,184,303,177,297,167,289,161,280,158,266,156,255,156,245,156,235,160,225,166" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="229,176,198,175,195,177,194,180,195,186,197,193,198,199,202,205,207,205,213,204,218,204" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="405,98,457,98,464,103,477,135,478,148,478,159,470,160,460,165,451,179,447,191,444,198,402,197,400,178,400,143,402,117" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="307,186,306,165,308,144,321,128,343,108,359,97,405,97,401,123,400,144,399,162,399,177,401,197,370,198,310,198" alt="" />';
var wagon_right_area = '<area data-tabulator="'+Math.random()+'" shape="poly" coords="582,175,572,176,565,170,553,166,536,166,522,167,514,171,508,176,503,185,501,194,500,201,492,201,491,199,493,192,496,184,499,177,504,167,512,161,521,158,535,156,546,156,556,156,566,160,576,166" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="572,176,603,175,606,177,607,180,606,186,604,193,603,199,599,205,594,205,588,204,583,204" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="396,98,344,98,338,103,324,135,323,148,323,159,331,160,341,165,350,179,354,191,357,198,399,197,402,178,402,143,399,117" alt="" /><area data-tabulator="'+Math.random()+'" shape="poly" coords="494,186,495,165,493,144,480,128,458,108,442,97,396,97,400,123,401,144,402,162,402,177,401,197,431,198,491,198" alt="" />';

$(document).ready(function (e)
{
    $('.car-select-option').click(function (e)
    {
        var glue = '/';
        var $s_car_image = $(this).children();
        var s_car = $s_car_image.attr('data-car');
        var $s_view_images = $(carSlideImg);
        $.each($s_view_images, function (index, s_view_image)
        {
            $s_view_image = $(s_view_image);
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

    $(document).on('click','area',function(e)
    {
        var $elem = $(this);
        var isSelectedElem = isHighlighted($elem);
        highlightSelected($elem,!isSelectedElem);

        if(!isSelectedElem) {
            $('#part-detail-modal').modal('show');
            //$('#part-detail-modal .modal-body').html('Tabulator: ' + $elem.attr('data-tabulator') + ", Part: " + $elem.attr('data-part'));
        }
    });

    highlightControl(default_car_selection);
});

function highlightControl(s_car)
{
    $(carSlideImg).each(function (index, elem)
    {
        var $elem = $(elem);
        var s_view = $elem.attr('data-view');
        var s_map = '#map-'+s_view;

        if (typeof eval(s_car + '_' + s_view + "_area") !== 'undefined') {
            $(s_map).html(eval(s_car + '_' + s_view + "_area"));
            $elem.maphilight({strokeColor: '#009688',strokeOpacity: 1,strokeWidth: 1});
        }
    });
}

function isHighlighted($elem)
{
    var hData = $elem.data('maphilight') || {};
    return hData.alwaysOn;
}

function highlightSelected($elem,state)
{
    var hData = $elem.data('maphilight') || {};
    hData.alwaysOn = state;
    $elem.data('maphilight', hData).trigger('alwaysOn.maphilight');
}

function highlightOnlySelected($clickedElem,$areaElements)
{
    $areaElements.each(function()
    {
        highlightSelected($(this),$(this).is($clickedElem));
    });
}

function highlightAll($areaElements,state)
{
    $areaElements.each(function()
    {
        highlightSelected($(this),state);
    });
}