<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php echo h(ucfirst($this->params['action'])) . ' &middot; Pingster'; ?>
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
            .footerLoginSignUp{
                bottom: 0px;
                position: relative;
                height: 37px;
                text-align: center;
                padding-top: 30px;
            } 
            .containerLoginSignUp{
                padding-top: 100px;
            }
        </style>
    </head>
    <body onload="setBGColor();">
        <div class="container containerLoginSignUp">
            <h1 style="text-align:center;"><?php echo h(ucfirst($this->params['action'])); ?></h1>

            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        </div>

        <div class="footerLoginSignUp">
            <p><a target="_blank" title="Pingster main site" href="https://www.pingster.org/">pingster.org</a></p>
            <p>&#9400; Copyright Pingster <?php echo h(date('Y')); ?></p>
        </div>

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
