$(function () {

    // hide placeholder on form
    $('[placeholder]').focus(function () {

        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placeholder', '');

    }).blur(function () {

        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    // hide the error message when focus at the input feild on log in page

    $('input').focus(function () {
        $('.alert').slideUp();
    });

    // add asterisk

    $('input').each(function () {

        if (($(this).attr('required')) === 'required') {

            $(this).after('<span class="astr">*</span>');
        }

    });

    var passField = $('.password');

    // show the eye of the pass when the input is focus

    passField.focus(function () {

        $('.show_pass').fadeIn();
    }).blur(function () {

        $('.show_pass').fadeOut();
    });

    // convert pass firld to text field on hover

    $('.show_pass').hover(function () {
        'use strict';
        passField.attr('type', 'text');

    }, function () {
        'use strict';
        passField.attr('type', 'password');

    });

    $('.confirm').click(function () {
        return confirm(' Are You Sure ?');
    });
});