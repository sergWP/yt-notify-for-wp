jQuery(document).ready(function($) {
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
