(function ($) {

    // BODY
    $body = $('body,html');

    // MODAL
    $('.modal-open').on('click', function () {
        let target = $(this).attr('data-modal');
        $('#' + target).removeClass('modal-exit');
        $('#' + target).addClass('modal-show');
        $body.addClass('noScroll');
    });


    // MODAL CLOSE
    $('.modal-close').on('click', function () {
        let target = $(this).attr('data-modal');
        $('#' + target).removeClass('modal-show');
        $('#' + target).addClass('modal-exit');
        if ($('.modal-show').length === 0) {
            setTimeout(function () {
                $body.removeClass('noScroll');
            }, 500);
        }
    });


    // CLICK EVENT OUTSIDE MODAL
    $('.modal').on('click', function (e) {
        if ($(e.target).is('.modal')) {
            $('.modal').removeClass('modal-show');
            $body.removeClass('noScroll');
        }
    });


    // ACCORDIAN
    $('.accordion').each(function () {

        if ($(this).hasClass('active')) {
            var panel = $(this).next('.panel');
            $(this).next('.panel').css('max-height', panel[0].scrollHeight + "px");

            $(this).find('.fa-plus').removeClass('fa-plus').addClass('fa-minus')
        }else{
            $(this).next('.panel').css('max-height', 0);
        }

        $('.accordion').on('click', function () {



            panel = $(this).next('.panel');
            $(this).addClass('active');
            if (parseFloat($(this).next('.panel').css('max-height'))) {
                $(this).next('.panel').css('max-height', 0);
                $(this).removeClass('active');
                $(this).find('.fa-minus').removeClass('fa-minus').addClass('fa-plus')
            } else {
                $(this).next('.panel').css('max-height', panel[0].scrollHeight + "px");
                $(this).find('.fa-plus').removeClass('fa-plus').addClass('fa-minus')
            }
        });
    });



}(jQuery))
