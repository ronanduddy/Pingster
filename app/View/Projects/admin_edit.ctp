<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'Edit Project',
    'icon' => 'fa-archive',
));

// create form
echo $this->Form->create('Project', array(
    'action' => 'editPing',
    'type' => 'file'
));

// user.id required for model update (is hidden)
//echo $this->Form->input('User.id');
// Project.id required for model update (is hidden)
echo $this->Form->input('Project.id');

echo $this->Form->input('Project.kind', array('value' => 'ping', 'type' => 'hidden'));
echo $this->Form->input('Project.title');
?>
<div class="form-group required">
    <label class="control-label col-lg-4" for="ProjectDescription">Description</label>
    <div class="col-lg-8">
        <?php
        // for Project model:
        // description 
        echo $this->Form->textarea('Project.description', array(
            'class' => 'form-control',
            'style' => 'resize: vertical;',
            'rows' => '5',
            'maxlength' => '140'
        ));
        ?>  
    </div>
</div>
<?php
echo $this->Form->input('Project.status', array(
    'options' => array(
        'private' => 'Private',
        'public' => 'Public'
    ),
    'label' => 'Project status',
));

echo $this->Form->input('Project.community', array(
    'label' => 'Community',
    'type' => 'select',
    'options' => $communities,
    'empty' => 'Choose a community',
));

//            echo $this->Form->input('Tag.tag_content', array(
//                'label' => 'Tag',
//            ));
//        echo $this->Form->input('Asset');
//
//        echo $this->Form->input('ProjectsUser.user_role', array(
//            'options' => array(
//                'owner' => 'Owner',
//                'moderator' => 'Moderator',
//                'collaborator' => 'Collaborator',
//                'mentor' => 'Mentor',
//            ),
//            'label' => 'Role w/project',
//        ));
echo $this->Form->input('Project.image', array(
    'type' => 'file',
    'label' => 'Image',
    'class' => '',
    'required' => false
));
echo $this->Form->input('Project.image_url', array('type' => 'hidden'));

echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Projects', array('controller' => 'Projects', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->submit('Edit Project', array(
            'class' => 'btn btn-primary btn-flat',
            'div' => false,
        )),
        $this->Form->end(),
    )
));
