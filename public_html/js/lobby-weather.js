var doWeatherUpdate = function() {
    $.getJSON('/data/weather', function( data ) {
        $.each( data, function( index1, element1 ) {
            $.each( element1, function( index2, element2 ) {
                $.each( element2, function( index3, element3 ) {
                    if (/-icon/i.test(index3))
                        $('#'+index3).removeClass().addClass('wi '+element3);
                    else
                        $('#'+index3).text(element3);
                });
            });
        });
    });
};

$(document).ready(function() {
    
    // run it immediately
    doWeatherUpdate();

    // schedule weather update
    setInterval( function() {
        doWeatherUpdate();
        console.info( 'weather updated' );
    }, 900000 );

});
