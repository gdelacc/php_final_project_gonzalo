console.log('Obuda cars JS loaded!!');

$( document ).ready(function() {

    //Register mode hide/Show
    $('#register-link').on('click', function () {
        $('.login-form.register').toggleClass('hide');
        $('.login-form.login').toggleClass('hide');
    });

    //Check if both pass are the same!
    $('#register-form').submit(function () {
        var pass1 = $('#pass1').val();
        var pass2 = $('#pass2').val();

        // Check if empty of not
        if (pass1  != pass2) {
            $('#div-register-message').removeClass("hide");
            $('#span-register-message').text("Passwords do NOT match!!");

            return false;
        }
    });

});