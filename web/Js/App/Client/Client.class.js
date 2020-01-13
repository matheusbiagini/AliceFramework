function Client() {

    this.clientList = function(reset) {
        var divContent = '#clientBodyList';
        var autoScroll = $('#autoScrollPagination').val();

        if (autoScroll == 'true') {
            loading.start();
            $.ajax({
                type: 'GET',
                url: url('adminClientsListPagination'),
                data: {filter: $('#filterClient').val(), page: $('#autoScrollPage').val()},
            }).done(function (response) {
                if (reset) {
                    $(divContent).html(response);
                } else {
                    $(divContent).append(response);
                }
                loading.stop();
            });
        }

        var pageNext = eval($('#autoScrollPage').val()) + 1;

        $('#autoScrollPage').val(pageNext);
    },

    this.deleteClient = function (clientToken) {
        var confirmar = confirm(language.translate('CONFIRM_DELETE'));

        if (confirmar) {
            loading.start();
            $.ajax({
                type: 'POST',
                url: url('adminClientDelete'),
                data: { client: clientToken },
            }).done(function (response) {
                if (response.success == true) {
                    location.href = url('adminClientsList');
                } else {
                    alert(language.translate('ERROR_TRY_AGAIN'));
                }
                loading.stop();
            });
        }
    },

    this.sendCertificateByEmail = function (certificateToken) {
        var confirmar = confirm(language.translate('CONFIRM_SEND_EMAIL'));

        if (confirmar) {
            loading.start();
            $.ajax({
                type: 'POST',
                url: url('sendCertificateByEmail'),
                data: { certificate: certificateToken },
            }).done(function (response) {
                if (response.success == true) {
                    alert(language.translate('SEND_EMAIL_SUCCESS'));
                } else {
                    alert(language.translate('ERROR_TRY_AGAIN'));
                }
                loading.stop();
            });
        }
    },

    this.alterEmailClient = function (clientToken) {
        var confirmar = confirm(language.translate('CONFIRM_ALTER_DATA'));

        if (confirmar) {
            loading.start();
            $.ajax({
                type: 'POST',
                url: url('adminClientAlterEmail'),
                data: { client: clientToken, email: $('#clientEmail').val() },
            }).done(function (response) {
                if (response.success == true) {
                    location.href = url('adminClientsList');
                } else {
                    alert(language.translate('ERROR_TRY_AGAIN'));
                }
                loading.stop();
            });
        }
    },

    this.resetPassword = function (clientToken) {
        var confirmar = confirm(language.translate('CONFIRM_RESET_PASSWORD_CLIENT'));

        if (confirmar) {
            loading.start();
            $.ajax({
                type: 'POST',
                url: url('adminClientResetPassword'),
                data: { client: clientToken },
            }).done(function (response) {
                if (response.success == true) {
                    alert(language.translate('RESET_PASSWORD_SUCCESSFULLY'));
                } else {
                    alert(language.translate('ERROR_TRY_AGAIN'));
                }
                loading.stop();
            });
        }
    }
}

var client = new Client();