/**
 * Script for login page
 * @version 1.0
 */
$(function () {
    // Login form submit
    $('#loginForm').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();
        $.post(url, data, function (response) {
            if (response.status == 'error') {
                $('#message').html(response.message).addClass('alert alert-danger');
            } else {
                $('#message').html(response.message).addClass('alert alert-success');
                window.location.href = response.redirect;
            }
        }, 'json');
    });
});