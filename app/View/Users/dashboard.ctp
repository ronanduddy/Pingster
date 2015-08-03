<?php
//debug($user);
//debug($current_user);
?>
<section class="content" style="text-align: center; padding-top: 5px;" >

<img src="/mvp/img/banner_promo.png" style="padding: 10px; text-align: center;"></img>
<section class="content" style="text-align: center">
 <div class="row">
    <div class="col-md-12" style="padding: 50px;">
        <?php echo $this->Element('getActivity');?>
    </div>

    <div class="col-md-6 col-md-offset-3">
        <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-bullhorn"></i>
                <h3 class="box-title">
                    The big idea…
                </h3>
            </div>
            <div class="box-body">
                <div class="callout callout-info">
                    <h4>Hello! Welcome to the first Pingster prototype!</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-solid">
            <div class="box-header">
                <i class="fa fa-search"></i>
                <h3 class="box-title">EXPLORE</h3>
            </div>
            <div class="box-body">
                <a href="#" class="thumbnail">
                    <?php echo $this->Html->image('explore_web.jpg', array('alt' => 'EXPLORE'));
                    ?>
                </a>
                <p>Pingster is all about ideas, start out by creating your first “Ping”.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-solid">
            <div class="box-header">
                <i class="fa fa-wrench"></i>
                <h3 class="box-title">BUILD</h3>
            </div>
            <div class="box-body">
                <a href="#" class="thumbnail">
                    <?php echo $this->Html->image('build_web.jpg', array('alt' => 'BUILD')); ?>
                </a>
                <p>Now you have your idea, you gotta try and make it.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-solid">
            <div class="box-header">
                <i class="fa fa-share"></i>
                <h3 class="box-title">SHARE</h3>
            </div>
            <div class="box-body">
                <a href="#" class="thumbnail">
                    <?php echo $this->Html->image('share_web.jpg', array('alt' => 'SHARE')); ?>
                </a>
                <p>Show how you made your digital creations!</p>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header">
                <i class="fa  fa-heart"></i>
                <h3 class="box-title">Help Us</h3>
            </div>
            <div class="box-body">

                <div class="callout callout-warning">
                    <i class="fa fa-info"></i>
                    <h4>Note</h4>
                    <p>This is a prototype and may not always work the way you want it to.
                        We need your help in making Pingster as awesome as it can be, you are our experimenters,
                        testers and critical eyes - if it is going wrong, tell us. If it doesn’t do what you want it to do, tell us.</p>
                </div>

              <?php echo $this->Html->link('Questionnaire', 'https://docs.google.com/forms/d/1iN6-lSHO5DhPd5N824VxWMG2ENvLa04HzTtqCwNz5Y8/viewform?usp=send_form', array('class' => 'btn btn-info btn-sm', 'target' => '_blank', 'title' => 'Form')); ?>
              <?php echo $this->Html->link('Pingster Forum', 'https://groups.google.com/forum/?hl=en#!forum/pingster-forum', array('class' => 'btn btn-success btn-sm', 'target' => '_blank', 'title' => 'Form')); ?>


                <p><a target="_blank" title="Pingster main site" href="https://www.pingster.org/">pingster.org</a></p>

            </div>
        </div>
    </div>

</section>