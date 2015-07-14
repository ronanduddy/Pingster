<!DOCTYPE html>
<html>
    <head>
        <title>
            Home &middot; Pingster! 
        </title>
        <?php
        // get header styles, scripts and meta
        echo $this->element('headerStylesScripts');
        ?>
        <style>
            .pink-main {
                background-color: #e8535d;
            }
            .orange-main {
                background-color: #ff9100;
            }
            .blue-main {
                background-color: #5ac6dc;
            }
            .containerHome{
                padding: 100px 0;
                text-align: center;
            }
            .pHome{
                margin-top: 30px;
                font-size: 2rem;
                margin-bottom: 3.75rem;
                font-weight: 300;
                line-height: 1.6;
                text-align: center;
                font-family: "proxima-nova","Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;
                width: 50%;
                float: none;
                margin-left: auto;
                margin-right: auto;
            }
            .footerHome{
                bottom: 0px;
                position: relative;
                height: 37px;
            }
        </style>
    </head>
    <body onload="setBGColor();">
        <div class="container containerHome">

            <?php echo $this->Session->flash('auth', array('element' => 'Flashes/warning')); ?>
            <?php echo $this->Session->flash(); ?>

            <?php echo $this->Html->image('pingster.png', array('alt' => 'Pingster')); ?>

            <p class="pHome">
                Welcome to <strong>Pingster</strong>, 
                a <strong>friendly</strong> place for kids to share their <strong>digital ideas</strong> and <strong>collaborate</strong> on projects!
            </p>

            <p>
                <button class="btn btn-default btn-lg" data-toggle="modal" data-target="#loginModal">Already a Member?</button>
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#signUpModal">Sign-Up Today</button>
            </p>

            <p>
                <i class="fa fa-fw fa-info"></i>
                Pingster is set to log you out automatically after a session length of one hour.
            </p>
            
            <!-- Login Modal -->
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h2 class="modal-title" id="myModalLabel">Hey!</h2>
                            <p class="text-muted">Nice to see you again.</p>
                        </div>
                        <div class="modal-body">
                            <p style="text-align:left;">Sign-in with your registered username and password:</p>
                            <?php echo $this->element('login'); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal fade -->

            <!-- SignUp Modal -->
            <div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpModal" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h2 class="modal-title" id="myModalLabel">Howdy!</h2>
                            <p class="text-muted">It's nice to meet you.</p>
                        </div>
                        <div class="modal-body">
                            <p style="text-align:left;">Enter your details below to join the Pingster community:</p>
                            <?php echo $this->element('register'); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal fade -->

            <?php
            // not much for the home page: View/Home/index
            echo $this->fetch('content');
            ?>

            <div class="footerHome">
                <p><a target="_blank" title="Pingster main site" href="https://www.pingster.org/">pingster.org</a></p>
                <p>&#9400; Pingster <?php echo h(date('Y')); ?></p>
            </div>

        </div><!-- /.container -->
    </body>
    <?php
    // get footer scripts
    echo $this->element('scripts');
    ?>
    <script type="text/javascript">
        // code by the amigostudios.co 
        function setBGColor() {
            var randomizer = Math.floor(Math.random() * 3);
            var cName = '';
            switch (randomizer) {
                case 0:
                    cName = 'pink-main';
                    break;
                case 1:
                    cName = 'blue-main';
                    break;
                case 2:
                    cName = 'orange-main';
                    break;
                default:
                    cName = 'pink-main';
            }
            document.getElementsByTagName('body')[0].className = cName;
        }
    </script>
</html>
