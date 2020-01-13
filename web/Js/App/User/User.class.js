function User() {
    this.save = function() {
        var buttonContent = $('#btn-save').html();
        $('#btn-save').html(language.translate('LOADING'));

        var userData = {
            userId : $('#userId').val(),
            userName : $('#userName').val(),
            userEmail : $('#userEmail').val(),
            userPassword : $('#userPassword').val(),
            userProfile : $('#userProfile').val(),
            userStatus : $('#userStatus').val(),
            a: $('#a').val()
        };

        $.ajax({
            type: 'POST',
            url: url('adminUserSave'),
            data: userData ,
        }).done(function (response) {
            if (response.success == true) {
                location.href = url('adminDashboard');
                return;
            }
            if (response.success == false) {
                $('#formUserContent').effect( "shake" );
                $('#contentModalErrors').html(response.errors);
                $('#modalErrors').modal();
                $('#btn-save').html(buttonContent);
                return;
            }
        });
    },

    this.changePassword = function() {
        var buttonContent = $('#btn-save').html();
        $('#btn-save').html(language.translate('LOADING'));

        var userData = {
            userId : $('#userId').val(),
            userPassword : $('#userPassword').val(),
            userOldPassword: $('#userOldPassword').val()
        };

        $.ajax({
            type: 'POST',
            url: url('adminChangePasswordSave'),
            data: userData ,
        }).done(function (response) {
            if (response.success == true) {
                location.href = url('adminDashboard');
                return;
            }
            if (response.success == false) {
                $('#formUserContent').effect( "shake" );
                $('#contentModalErrors').html(response.errors);
                $('#modalErrors').modal();
                $('#btn-save').html(buttonContent);
                return;
            }
        });
    },

    this.usersList = function(reset) {
        var divContent = '#userBodyList';
        var autoScroll = $('#autoScrollPagination').val();
        if (autoScroll == 'true') {
            loading.start();

            $.ajax({
                type: 'GET',
                url: url('adminUsersListPagination'),
                data: {filter: $('#filterUser').val(), page: $('#autoScrollPage').val()},
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

    this.deleteUser = function (userToken) {
        var confirmar = confirm(language.translate('CONFIRM_DELETE'));

        if (confirmar) {
            loading.start();
            $.ajax({
                type: 'POST',
                url: url('adminUserDelete'),
                data: { user: userToken },
            }).done(function (response) {
                if (response.success == true) {
                    location.href = url('adminUsersList');
                } else {
                    alert(language.translate('ERROR_TRY_AGAIN'));
                }
                loading.stop();
            });
        }
    }
}

var user = new User();