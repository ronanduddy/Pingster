<?php
//debug($user);
//debug($current_user);
?>

<img src="/mvp/img/banner_promo.png" style="padding: 10px; text-align: center;"></img>
<section class="content" style="text-align: center">
    <h2 class="page-header">PINGSTER - THE PROTOTYPE</h2>
    <div class="row">

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
                        <p> You are one of the FIRST people to discover this new land…</p>
                        <p>So how to start??</p>
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
                        <?php echo $this->Html->image('explore_web.jpg', array('alt' => 'EXPLORE')); ?>
                    </a>
                    <p>Pingster is all about ideas, start out by creating your first “Ping”.</p>
                    <p>This can be an awesome idea or project you are working on. What might you make, do, create or imagine??</p>
                    <p>Give your project an epic name, add a picture to help others understand your master plan and begin your project!</p>
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
                    <p>Try something new or use your skills to start to make your idea happen. Don’t worry there are no wrong answers!</p>
                    <p>Be original, post your own awesome digital creations and projects, but remember that its not cool to pass of others work as your own.</p>
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
                    <p>Show how you made your digital creations, build onto others projects and discover new ways to make your ideas happen.</p>
                    <p>Do all this by sharing your ideas and skills with the community of Pingsters.</p>
                    <p>But remember to give credit to those who inspired you to do great things!</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-md-offset-3">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-bullhorn"></i>
                    <h3 class="box-title">
                        So in short
                    </h3>
                </div>
                <div class="box-body">
                    <div class="callout callout-info">
                        <h4>How to be awesome:</h4>
                        <ul>
                            <li>Ideas are just ideas - give it a go!</li>
                            <li>Sharing is caring… :)</li>
                            <li>Kindness like a boomerang, always comes back around.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-md-offset-3">
            <div class="box box-solid">
                <div class="box-header">
                    <i class="fa  fa-heart"></i>
                    <h3 class="box-title">Help Us</h3>
                </div>
                <div class="box-body">
                    <h4></h4>
                    <p>We have created two means to help Pingster; a Google Forum for discussion and feedback and an anonymous feedback questionnaire. Here are the links:</p>
                    <p>
                        <?php echo $this->Html->link('Pingster Forum', 'https://groups.google.com/forum/?hl=en#!forum/pingster-forum', array('class' => 'btn btn-success btn-sm', 'target' => '_blank', 'title' => 'Form')); ?>
                    </p>
                    <p>and</p>
                    <p>
                        <?php echo $this->Html->link('Questionnaire', 'https://docs.google.com/forms/d/1iN6-lSHO5DhPd5N824VxWMG2ENvLa04HzTtqCwNz5Y8/viewform?usp=send_form', array('class' => 'btn btn-info btn-sm', 'target' => '_blank', 'title' => 'Form')); ?>
                    </p>

                    <div class="callout callout-warning">
                        <i class="fa fa-info"></i>
                        <h4>Note</h4>
                        <p>This is a prototype and may not always work the way you want it to. 
                            We need your help in making Pingster as awesome as it can be, you are our experimenters, 
                            testers and critical eyes - if it is going wrong, tell us. If it doesn’t do what you want it to do, tell us.</p>
                    </div>
                    
                    <p><a target="_blank" title="Pingster main site" href="https://www.pingster.org/">pingster.org</a></p>
                    
                </div>
            </div>
        </div>

    </div>
</section>