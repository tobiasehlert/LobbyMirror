var doWeatherUpdate = function (uid) {
    $.getJSON('/data/weather/' + uid, function (data) {
        $.each(data, function (index1, element1) {
            $.each(element1, function (index2, element2) {
                $.each(element2, function (index3, element3) {
                    if (/-icon/i.test(index3))
                        $('#' + index3).removeClass().addClass('wi ' + element3);
                    else
                        $('#' + index3).text(element3);
                });
            });
        });
    });
};

$(document).ready(function () {
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.search);
        return (results !== null) ? results[1] || 0 : false;
    }

    // run it immediately
    doWeatherUpdate($.urlParam('uid'));

    // schedule weather update
    setInterval(function () {
        doWeatherUpdate($.urlParam('uid'));
        console.info('weather updated');
    }, 900000);

});
