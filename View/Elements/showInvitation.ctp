<div class="col-lg-6">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-envelope-o"></i>
            <h3 class="box-title">
            Join this team up!
            </h3>
        </div>
        <div class="box-body">
            <form action="/Projects/invitationResponse" method="Post">
                <button type="submit" name="response" value="yes" class="btn btn-info">Yes</button>
                <button type="submit" name="response" value="no" class="btn btn-warning">No</button>
                <input type="hidden" name="project_id" value="<?php echo $project['Project']['id']; ?>"></input>
            </form>
        </div>
    </div>
</div>