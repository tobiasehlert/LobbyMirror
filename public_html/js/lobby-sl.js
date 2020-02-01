var doSlUpdate = function( column ) {
    $.getJSON('/data/sl/'+column, function( data ) {
//        if ( data !== 'false' ) {
            $("#lw-sl-departures-"+column).empty();
            var SLhtml = $("#lw-sl-departures-"+column);
            SLhtml = '';
            $.each( data['lw-sl-departures'], function( index1, element1 ) {
                SLhtml = SLhtml+'<div id="lw-sl-departures-info-siteid-'+element1['lw-sl-departures-info']['lw-sl-departures-info-siteid']+'" class="row '+index1+' lw-sl-departures-topmargin">';
                SLhtml = SLhtml+'<h4 id="lw-sl-departures-'+element1['lw-sl-departures-info']['lw-sl-departures-info-siteid']+'">'+element1['lw-sl-departures-info']['lw-sl-departures-info-name']+'</h4>';
                $.each( element1['lw-sl-departures-data'], function( index2, element2 ) {
                    $.each( element2, function( index3, element3 ) {
                        if (/-type/i.test(index3)) {
                            SLhtml = SLhtml+'<div class="col-md-12" >';
                            SLhtml = SLhtml+'<h5 id="'+index3+'">'+element3+'</h5>';
                        }
                    });
                    $.each( element2, function( index3, element3 ) {

                        if (/-type/i.test(index3)) {}
                        else {
                            SLhtml = SLhtml+'<div id="'+index3+'"><h6>';
                            $.each( element3, function( index4, element4 ) {
                                var extraclass;
                                if (/-DisplayTime/i.test(index4))
                                    var extraclass = 'class="lw-sl-floatright"';
                                else
                                    var extraclass = '';
                                SLhtml = SLhtml+'<span id="'+index4+'" '+extraclass+'>'+element4+'</span> ';
                            });
                            SLhtml = SLhtml+'</h6></div><!-- #'+index3+' -->';
                        }

                    });
                    SLhtml = SLhtml+'</div>';
                });
                SLhtml = SLhtml+'</div><!-- #lw-sl-departures-info-siteid-'+element1['lw-sl-departures-info']['lw-sl-departures-info-siteid']+' -->';
            });
            $("#lw-sl-departures-"+column).append(SLhtml);
//        }
    });
};

$(document).ready(function() {
    
    // run it immediately
    doSlUpdate( '1' );
    doSlUpdate( '2' );

    // schedule weather update
    setInterval( function() {
        doSlUpdate( '1' );
        doSlUpdate( '2' );
        console.info( 'sl updated' );
    }, 60000 );

});
