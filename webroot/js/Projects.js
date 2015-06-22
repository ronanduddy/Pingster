$(function() {

    if (typeof members == 'undefined') {
        var members = {};
    }

    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) {
        return split( term ).pop();
    }

    $( "#ProjectMembers" )
        // don't navigate away from the field on tab when selecting an item
        .bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            source: function( request, response ) {
                $.getJSON( docRoot.concat("/Users/search.json"), {
                    term: extractLast( request.term )
                },
                function(data) {
                    response($.map(data,
                        function (value,key) {
                        return {
                            label : value,
                            value : key
                        }
                    }))
                });
            },
            search: function() {
                // custom minLength
                var term = extractLast( this.value );
                if ( term.length < 2 ) {
                    return false;
                }
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
                var terms = split( this.value );
                terms.pop();
                terms.push( ui.item.label );
                terms.push( "" );
                this.value = terms.join( ", " );

                members[ui.item.label] = ui.item.value;

                var ids = []
                for(var i= 0, total=terms.length; i<total; i++){
                    if(terms[i]){
                        ids.push(members[terms[i]]);
                    }
                }

                $( "#ProjectUserIds").val(ids.join(","));

                return false;
            }
        });

    $( "#ProjectMembers" ).on('change',function(){
        var ids = []
        var terms = this.value.split( /,\s*/ );
        for(var i= 0, total=terms.length; i<total; i++){
            if(terms[i]){
                ids.push(members[terms[i]]);
            }
        }
        $( "#ProjectUserIds").val(ids.join(","));
    });
});

$(document).ready(function() {

    var ids = $( "#ProjectUserIds").val();
    if(ids){
        var aIds = ids.split( /,\s*/ );
        var aUsers = []
        for(var i= 0, total=aIds.length; i<total; i++){
            aUsers = aIds[i]
        }
    }

});
