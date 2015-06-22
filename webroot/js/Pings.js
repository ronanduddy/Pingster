$(function () {
    $( "#ProjectsCreateButton").on('click', function( event ) {
        event.preventDefault();

        var projectsCreateUrl = $(event.target).attr('href');
        var dialogProjectsCreate = $( "#dialogProjectsCreate" );

        dialogProjectsCreate
            .dialog({
                modal: true,
                width: '60%'
            })

            .load(projectsCreateUrl, function() {
                 $( "#addPingForm" ).on('submit', function(event) {
                    event.preventDefault();

                    var form = $(event.target);
                    var action = form.attr("action");
                    var formData = new FormData(form[0]);

                    $.ajax({
                        method: "POST",
                        url: action,
                        data: formData,
                        processData: false,
                        contentType: false
                    })
                    .done(function(data) {
                        dialogProjectsCreate.html(data.message);
                        console.log(data);
                    })
                    .fail(function(jqXhr) {
                        var data = $.parseJSON(jqXhr.responseText);
                        dialogProjectsCreate.html(data.message);
                    });
                });

                $( "#dialogProjectsCreate" ).dialog('open');
            });
    });
});
