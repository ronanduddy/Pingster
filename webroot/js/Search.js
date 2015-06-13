var webroot = window.location.protocol + '//' + window.location.hostname;

$(document).ready(function(){


    $("#searchterm").keyup(function(e){

        var q = $("#searchterm").val();

        if(q.length > 1) {

            $.getJSON(webroot + "/Projects/searchPings.json",
                {
                    term: q,
                },
                function (data) {
                    $("#ping_results").empty();
                    $.each(data, function (i, value) {
                        var ping = "<div class='masonryItem'>" +
                            "<div class='box box-primary'> <div class='box-header'><h4 class='box-title'>" +
                            "<a href='" + webroot + "/Projects/viewPing/" +
                            value.Project.id + "'>" + value.Project.title +
                            "</a></h4></div>" +
                           "</div>";
                        $("#ping_results").append(ping);
                    });
                }
            );

            $.getJSON(webroot + "/Projects/searchTeamUps.json",
                {
                    term: q,
                },
                function (data) {
                    $("#team_up_results").empty();
                    $.each(data, function (i, value) {
                        var team_up = "<div class='masonryItem'>" +
                        "<div class='box box-primary'> <div class='box-header'><h4 class='box-title'>" +
                        "<a href='" + webroot + "/Projects/viewTeamUp/" +
                        value.Project.id + "'>" + value.Project.title +
                        "</a></h4></div>" +
                        "</div>";

                        $("#team_up_results").append(team_up);
                    });
                }
            );

            $.getJSON(webroot + "/Users/search.json",
                {
                    term: q,
                },
                function (data) {
                    $("#user_results").empty();
                    $.each(data, function (i, value) {
                        var user =  "<div class='masonryItem'>" +
                            "<div class='box box-primary'> <div class='box-header'><h4 class='box-title'>" +
                            "<a href='" + webroot + "/Users/view/" +
                            i+ "'>" + value +
                            "</a></h4></div>" +
                            "</div>";

                        $("#user_results").append(user);
                    });
                }
            );
        }
    });


    var q = $("#searchterm").val();

    if(q.length > 1){
        $("#searchterm").trigger("keyup");$("#searchterm").trigger("keyup");
    }

});
