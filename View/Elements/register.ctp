<style>
    form .required label:after {
        color: #e32;
        content: '*';
        display:inline;
    }
</style>

<?php
// create form
echo $this->Form->create('User', array(
    'action' => 'register',
));

// for users model:
// email 
echo $this->Form->input('User.email', array(
    'placeholder' => 'Your email',
));

// for User model:
// age
echo $this->Form->input('User.age', array(
    'placeholder' => 'Your age',
));

// for user model:
// username 
echo $this->Form->input('User.username', array(
    'placeholder' => 'Your username',
));

// for user model:
// user group_id 
echo $this->Form->hidden('User.group_id', array(
    'value' => 8, // for pingster
));

// for user model:
// password
echo $this->Form->input('User.password', array(
    'placeholder' => 'Your password',
    'type' => 'password',
));

// for user model:
// confirm password
echo $this->Form->input('User.password_confirm', array(
    'placeholder' => 'Confirm your password',
    'title' => 'Confirm password',
    'type' => 'password',
    'label' => 'Confirm password',
));

?>

<div class="form-group-required">
    <label for="tos" class="control-label col-lg-4">
        Agree With Our <a href="/privacypolicy" target="_blank">Privacy Policy</a> And <a href="/termsandconditions" target="_blank">Terms And Conditions</a>?
    </label>
    <div class="col-lg-8">
        <input type="hidden" name="data[User][tos]" id="tos_" value="0">
        <div class="icheckbox_minimal" aria-checked="false" aria-disabled="false" style="position: relative;">
            <input type="checkbox" name="data[User][tos]" class="form-control" value="1" id="tos" style="opacity: 0;">
        </div>
    </div>
</div>

<?php
// submit
echo $this->Form->submit('Sign me up!', array(
    'class' => 'btn btn-lg btn-primary btn-block'
));



// end
echo $this->Form->end();

echo $this->Html->link('Already a member?', array('controller' => 'Users', 'action' => 'login'), array('title' => 'Login!'));
