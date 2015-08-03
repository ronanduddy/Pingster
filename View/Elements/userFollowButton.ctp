<?php
$followButton = '';
foreach($user['Follower'] as $follower){
    if($follower['id'] = $current_user['id']){
        $followButton = '<i id="followUser" class="btn btn-success fa fa-user-times">Unfollow</i>';
        break;
    }
}

$followButton = !empty($followButton) ? $followButton : '<i id="followUser" class="btn btn-success fa fa-user-plus">Follow</i>';

echo $followButton ?>

<script>
var user_id = <?php echo $user["User"]["id"]; ?>;
$(document).ready(function(){
    $("#followUser").click(function() {
        $("#followUser").attr("disabled", true);
        $.ajax({
            url: "/UsersFollowers/follow.json",
            data: {user_id: user_id},
            success: function(data) {

                if(data == 2){
                    $("#followUser").html('Unfollow').removeClass('fa-user-plus').addClass('fa-user-times');
                }
                else if(data == 1){
                    $("#followUser").html('Follow').removeClass('fa-user-times').addClass('fa-user-plus');
                }

                $("#followUser").attr("disabled", false);

            }
        });
    });

});
</script>