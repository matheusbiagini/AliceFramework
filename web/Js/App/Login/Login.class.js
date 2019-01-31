function Login() {
    this.signIn = function(email, password) {

        var buttonContent = $('#buttonSignIn').html();
        $('#buttonSignIn').html(language.translate('LOADING'));

        $.ajax({
            type: 'POST',
            url: url('auth'),
            data: {email : email, password : password } ,
        }).done(function (response) {
            if (response.success == true) {
                location.href = url('dashboard');
                return;
            }

            if (response.success == false) {
                $('#contentLoginAuth').effect( "shake" );
                $('#buttonSignIn').html(buttonContent);
                return;
            }
        });
    },

    this.forgotPassword = function(email) {
        var buttonContent = $('#buttonSignIn').html();
        $('#buttonSignIn').html(language.translate('LOADING'));

        $.ajax({
            type: 'POST',
            url: url('sendForgotPassword'),
            data: {email : email} ,
        }).done(function (response) {
            if (response.success == true) {
                alert(language.translate('PASSWORD_REQUEST_SENT_TO_SUCCESS'));
                location.href = url('login');
                return;
            }

            if (response.success == false) {
                $('#contentLoginAuth').effect( "shake" );
                $('#buttonSignIn').html(buttonContent);
                return;
            }
        });
    }
}

var login = new Login();