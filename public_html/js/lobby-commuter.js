var doCommuterUpdate = function (uid) {
    $.getJSON('/data/commuter/' + uid, function (data) {
        $("#lw-commuter-departures").empty();
        var CommuterHtml = $("#lw-commuter-departures");
        CommuterHtml = '';
        $.each(data['lw-commuter-departures'], function (index1, element1) {
            CommuterHtml = CommuterHtml + '<div id="lw-commuter-departures-info-siteid-' + element1['lw-commuter-departures-info']['lw-commuter-departures-info-siteid'] + '" class="row ' + index1 + ' lw-commuter-departures-topmargin">';
            CommuterHtml = CommuterHtml + '<h4 id="lw-commuter-departures-' + element1['lw-commuter-departures-info']['lw-commuter-departures-info-siteid'] + '">' + element1['lw-commuter-departures-info']['lw-commuter-departures-info-name'] + '</h4>';
            $.each(element1['lw-commuter-departures-data'], function (index2, element2) {
                $.each(element2, function (index3, element3) {
                    if (/-type/i.test(index3)) {
                        CommuterHtml = CommuterHtml + '<div class="col-md-12" >';
                        CommuterHtml = CommuterHtml + '<h5 id="' + index3 + '">' + element3 + '</h5>';
                    }
                });
                $.each(element2, function (index3, element3) {

                    if (/-type/i.test(index3)) { }
                    else {
                        CommuterHtml = CommuterHtml + '<div id="' + index3 + '"><h6>';
                        $.each(element3, function (index4, element4) {
                            var extraclass;
                            if (/-DisplayTime/i.test(index4))
                                var extraclass = 'class="lw-commuter-floatright"';
                            else
                                var extraclass = '';
                            CommuterHtml = CommuterHtml + '<span id="' + index4 + '" ' + extraclass + '>' + element4 + '</span> ';
                        });
                        CommuterHtml = CommuterHtml + '</h6></div><!-- #' + index3 + ' -->';
                    }

                });
                CommuterHtml = CommuterHtml + '</div>';
            });
            CommuterHtml = CommuterHtml + '</div><!-- #lw-commuter-departures-info-siteid-' + element1['lw-commuter-departures-info']['lw-commuter-departures-info-siteid'] + ' -->';
        });
        // replace the html
        $("#lw-commuter-departures-1").html(CommuterHtml);
    });
};

$(document).ready(function () {
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.search);
        return (results !== null) ? results[1] || 0 : false;
    }

    // run it immediately
    doCommuterUpdate($.urlParam('uid'));

    // schedule weather update
    setInterval(function () {
        doCommuterUpdate($.urlParam('uid'));
        console.info('commuter updated');
    }, 60000);

});
