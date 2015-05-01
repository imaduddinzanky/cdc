/* Smooth scrolling para anclas */
$(document).on('click','a.smooth', function(e){
    e.preventDefault();
    var $link = $(this);
    var anchor = $link.attr('href');
    $('html, body').stop().animate({
        scrollTop: $(anchor).offset().top
    }, 1000);
});

(function($) {
    $(document).ready(function() {
      $.slidebars();
    });
}) (jQuery);

// Syntax Enable
SyntaxHighlighter.all();

jQuery(document).ready(function () {
    $('.nav').on('click mousedown mouseup touchstart touchmove', 'a.has_children', function () {
        if ( $(this).next('ul').hasClass('open_t') && !$(this).parents('ul').hasClass('open_t')) {
            $('.open_t').removeClass('open_t');
            return false;
        }
        $('.open_t').not($(this).parents('ul')).removeClass('open_t');
        $(this).next('ul').addClass('open_t');
        return false;
    });
    $(document).on('click', ':not(.has_children, .has_children *)', function() {
        if( $('.open_t').length > 0 ) {
            $('.open_t').removeClass('open_t');
            $('.open_t').parent().removeClass('open');
            return false;
        }
    });

    // hide #back-top first
    $("#back-top").hide();

    // fade in #back-top
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#back-top').fadeIn();
            } else {
                $('#back-top').fadeOut();
            }
        });

        // scroll body to 0px on click
        $('#back-top a').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
    });

});

// WOW Activate
new WOW().init();

jQuery(document).ready(function() { // makes sure the whole site is loaded
    $('#status').fadeOut(); // will first fade out the loading animation
    $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
    $('body').delay(350).css({'overflow':'visible'});

    $('.delete-child').on('click', function(e){
        var td = $(this).parents('td');
        var name = $(this).attr('data-target');
        td.find('input[type=hidden]').each(function(){
            if ($(this).attr('name') == name)
            {
                $(this).val(1);
            }
        });
        td.parents('tr').hide();
        e.preventDefault();
    });

    // full-width-checkbox
    $("[name='full-width-checkbox']").bootstrapSwitch();

    if ($('textarea').length)
    {
        $('textarea').wysihtml5({
            toolbar: {
              fa: true
            },
            "html": true
        });
    }

    $(".switch").bootstrapSwitch({
        onSwitchChange : function()
        {
          if ($('input[name=student_id]').length)
          {
            $('div.for-student').toggle();
          }
        }
    });

    if ($('.input-date').length){
        $('.input-date').datepicker({format: 'yyyy/mm/dd'}).on('changeDate', function(ev){
            $(this).datepicker('hide');
        });
    }

    //chosen
    if ($('.chosen').length){
        $('.chosen-input').chosen();
    }

});


function initializeFileInput(input,options)
{
  input.fileinput(
    options
  );
}
