$(function() {
    $('a[href=#]').click(function (e) {
        e.preventDefault()
    });
	
    if (jQuery().datepicker) {
        $('.date-picker').datepicker();
    }
	
    $('#sidebar a.dropdown-toggle').click(function() {
        var submenu = $(this).next('.submenu');
        var arrow = $(this).children('.arrow');
        if (arrow.hasClass('fa-angle-right')) {
            arrow.addClass('anim-turn90');
        }
        else {
            arrow.addClass('anim-turn-90');
        }
        submenu.slideToggle(400, function(){
            if($(this).is(":hidden")) {
                arrow.attr('class', 'arrow fa fa-angle-right');
            } else {
                arrow.attr('class', 'arrow fa fa-angle-down');
            }
            arrow.removeClass('anim-turn90').removeClass('anim-turn-90');
        });
    });

});