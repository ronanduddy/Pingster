<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>

<script>
    var icons = ['fa-rocket', 'fa-bullseye', 'fa-heart', 'fa-bolt'];
    var colours = ['bg-red', 'bg-blue', 'bg-green', 'bg-black', 'bg-yellow']
    var days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    function getActivity(url){

         $.ajax({
            url: url,
            success: function(data) {

                $.each(data, function(i, value){

                    var icon = icons[Math.floor(Math.random()*icons.length)];
                    var colour = colours[Math.floor(Math.random()*colours.length)];
                    var time = new Date(value.Activity.time);
                    var email = value.User.email;
                    var gravatar_url = 'http://www.gravatar.com/avatar/' + CryptoJS.MD5(email);
                    var method = null;

                    if(value.Activity.method == "Update"){
                        method = "Updated";
                    }
                    if(value.Activity.method == "Create"){
                        method = "Created"
                    }

                    if(value.Project.id){

                        var kind = value.Project.kind;
                        var image_url = value.Project.image_url;
                        var id = value.Project.id;

                        if(kind == 'ping'){

                            action = "viewPing";
                        }
                        else if(kind == 'team_up'){

                            action = 'viewTeamUp';
                        }
                        var link = '/projects/' + action + '/' + id;
                        var title = value.Project.title;
                        var description = value.Project.description;
                    }

                    if(value.Comment.id){

                        var kind = "comment"
                        var id = value.Comment.id;

                        if(value.Comment.Project.kind == 'ping'){

                            action = "viewPing";
                        }
                        else if(value.Comment.Project.kind == 'team_up'){

                            action = 'viewTeamUp';
                        }

                        var link = '/projects/' + action + '/' + value.Comment.Project.id;
                        var title = 'A Comment'

                        var description = value.Comment.comment;
                    }



                    $(".timeline").append("<li class='col-lg-4 col-lg-offset-1'>" +
                        "<i class='fa " + icon + " " + colour + "'></i>" +
                        "<div class='box timeline-item'>" +
                        "<span class='time'><i class='fa fa-clock-o'></i> " + days[time.getDay()] + " " + time.getHours() + ":" + time.getMinutes() + "</span>" +
                        "<h3 class='timeline-header'>" +
                        "<div><img style='float:left; max-height: 60px;' src='" + gravatar_url + "'></div>" + "<a href='/users/view/" + value.User.id + "'> " +
                        value.User.username + "</a> " + method +  " <a href='" + link + "'>" + title + "</a></h3>" +
                        "<div class ='timeline-body'>" + description + "</div></div></li>"
                    );
                 });
            }
        });
    }

    $(document).ready(getActivity('/Activities/getAll.json'));
    $(document).ready(function(){
        $("#newsButton").click(function() {
            $(".timeline").html('');
            getActivity('/Activities/getAll.json');
        });
        $("#followersButton").click(function() {
            $(".timeline").html('');
            getActivity('/Activities/getFollowers.json');
        });
    });



</script>

<div>
    <a id="newsButton" href="#">News</a>
    <a id="followersButton" href="#">Followers</a>
</div>

<div class="timeline">

</div>


