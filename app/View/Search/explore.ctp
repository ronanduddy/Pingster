<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<?php echo $this->Html->script('Search'); ?>
<div class="container">
    <form role="form">
        <div class="row">
            <div class="form-group">
                <label for="code">Search</label>
                <input id="searchterm" type="text" class="form-control input-lg"
                <?php
                    if(isset($_GET['term'])){
                        $strValue = "value='" . $_GET['term'] . "' ";
                        echo $strValue;
                    }
                ?> >
            </div>
        </div>
    </form>
</div>

<div class="container">

    <h3 class="box-title">Pings</h3>
    <div class="box box-primary"></div>
    <div id="ping_results">
    </div>
</div>

<div class="container">
    <h3 class="box-title">Team Ups</h3>
    <div class="box box-primary"></div>
    <div id="team_up_results">
    </div>
</div>

<div class="container">
    <h3 class="box-title">Users</h3>
    <div class="box box-primary"></div>
    <div id="user_results">
    </div>
</div>

