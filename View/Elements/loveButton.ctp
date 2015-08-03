<!--JSON endpoint includes details on user who've liked, could extend this at some point to show this !-->

<i id="loveProject" class="btn btn-success fa fa-heart-o"></i>
<script>
var project_id = <?php echo $project["Project"]["id"]; ?>;
$(document).ready(function(){
    $.ajax({
        url: "/Projects/getLoves.json",
        data: {project_id: project_id},
        success: function(data) {
            var length = Object.keys(data).length;
            $("#loveProject").html(" " + length)
        }
    });
    $("#loveProject").click(function() {
        $("#loveProject").attr("disabled", true);
        $.ajax({
            url: "/Projects/loveProject.json",
            data: {project_id: project_id},
            success: function(data) {
                var length = Object.keys(data).length;
                $("#loveProject").html(" " + length).attr("disabled", false);

            }
        });
    });

});
</script>