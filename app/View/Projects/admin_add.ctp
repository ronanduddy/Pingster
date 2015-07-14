<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'Add Project',
    'icon' => 'fa-archive',
));

echo $this->Form->create('Project', array(
    'action' => 'add',
    'type' => 'file'
));

//            echo $this->Form->input('Project.kind', array(
//                'options' => array(
//                    'ping' => 'Ping',
//                    'team_up' => 'Team Up'
//                ),
//                'label' => 'Project kind',
//            ));
// for User model:
// for hidden input to contain user.id for user-project join/link table
echo $this->Form->input('User.id', array('value' => $user['id']));

// for project model:            
// hidden input to contain project type/kind
echo $this->Form->input('Project.kind', array('value' => 'ping', 'type' => 'hidden'));

// for project model:
// title
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
// for Project model:
// status
echo $this->Form->input('Project.status', array(
    'options' => array(
        'private' => 'Private',
        'public' => 'Public'
    ),
    'label' => 'Project status',
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
// for Project model:
// image
echo $this->Form->input('Project.image', array(
    'type' => 'file',
    'label' => 'Image',
    'class' => '',
    'required' => true,
));

// for Project model:
// image_url
echo $this->Form->input('Project.image_url', array('type' => 'hidden', 'required' => true,));

echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Projects', array('controller' => 'Projects', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->submit('Add Project', array(
            'class' => 'btn btn-primary btn-flat',
            'div' => false,
        )),
        $this->Form->end()
    )
));