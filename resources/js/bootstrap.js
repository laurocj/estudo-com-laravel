// window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    require('daemonite-material/assets/js/index')
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

// window.axios = require('axios');

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

$('.modal').on('show.bs.modal', function (e) {
    var loadurl = $(e.relatedTarget).data('load-url');
    $(this).find('.modal-body').load(loadurl);
});

$('.modal').on('shown.bs.modal', function (e) {
    var modal = $(this);
    modal.find('form').on('submit',function(e) {
        var requestForm = $(this);
        if (requestForm.length) {
            e.preventDefault();
            e.isDefaultPrevented();
            requestForm[0].checkValidity();
            $.ajax({
                url: requestForm.attr('action'),
                type: "POST",
                data: new FormData(requestForm[0]),
                processData: false,
                contentType: false,
                beforeSend: function() {
                    requestForm.find('.btn-primary').html('Processing...');
                },
                success: function(data) {
                    $("body .container-fluid main").html(data);
                    modal.modal('hide');
                },
                error: function(data) {
                    $.each(data.responseJSON.errors,function(key,value){
                        $("[name='"+key+"']")
                            .addClass('is-invalid')
                            .parent()
                            .append('<div class="invalid-feedback">'+value+'</div>');
                    });
                }
            });
            return false;
        }
    });
});
