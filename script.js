jQuery(document).ready(function($) {
    $('.style-2 .cactus-post-item .cactus-post-title a').each(function() {
        if($(this).text().length > 70) {
            $(this).text($(this).text().substring(0,70)+"...");
        }
    });
    $('.block-articles .cactus-post-title a').each(function() {
        if($(this).text().length > 60) {
            $(this).text($(this).text().substring(0,60)+"...");
        }
    });


    $('.prev-next-slider').remove();

    $('.tab-label').on('click', function () {
        let currentTab = $(this).attr('data-tab');
        $('.tab-label').removeClass('active-label');
        $(this).addClass('active-label');
        $('.cactus-tabs .block-wrap').hide();
        $('.cactus-tabs').find('.block-'+currentTab).show();
    });

    $('.open-menu').on('click', function () {
        $('.modal-menu, .menu-overlay').addClass('active');
        $('body').addClass('no-scroll');
    });

    $('.close-menu').on('click', function () {
        $('.modal-menu, .menu-overlay').removeClass('active');
        $('body').removeClass('no-scroll');
    });


    // clean bell
    let myajax = `//${window.location.host}/wp-admin/admin-ajax.php`,
        paramObj = {
            action: 'clear_meta',
            url: myajax
        };

    function cleanBell() {
        $.ajax({
            url: myajax,
            action: 'clear_meta',
            data: paramObj,
            type: 'POST',
            success(data) {
                $('.bell_action .notify').text('0');
                console.log('Yaay');
            }
        });
    }

    $('body').on('click', '.bell_action', function H(e) {
        e.preventDefault();
        if(window.location.pathname === '/subscriptions/') {
            cleanBell();
        } else {
            cleanBell();
            setTimeout(function() {
                window.location.href = `${location.protocol}//${window.location.host}/subscriptions/`;
            }, 350);
        }
    });

});