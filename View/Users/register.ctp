<div class="container">
    <div class="row">
        <div class="col-lg-5 col-lg-offset-3">
            <?php
            echo $this->Session->flash('auth', array('element' => 'Flashes/warning'));
            echo $this->Session->flash();
            echo $this->element('register');
            ?>
        </div>
    </div>
</div>