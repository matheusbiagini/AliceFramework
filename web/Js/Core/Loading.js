function Loading() {
    this.start = function () {
        $('#overlayLoading').show();
        $('#divLoading').show();
    },

    this.stop = function () {
        $('#overlayLoading').hide();
        $('#divLoading').hide();
    }
}

var loading = new Loading();