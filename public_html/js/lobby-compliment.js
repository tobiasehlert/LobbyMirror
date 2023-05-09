var doComplimentUpdate = function () {
    $.getJSON('/data/compliment', function (data) {
        $("#lw-bf-compliment").html(data);
    });
};

$(document).ready(function () {
    // run it immediately
    doComplimentUpdate();

    // schedule weather update
    setInterval(function () {
        doComplimentUpdate();
        console.info('compliment updated');
    }, 30000);
});
