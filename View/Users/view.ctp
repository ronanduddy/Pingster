<?php //debug($assets);       ?>
<div class="col-lg-6">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-user"></i>
            <h3 class="box-title"><?php echo $user['User']['username'] ?></h3>
        </div>
        <div class="box-body">

            <?php
            echo sprintf('<h4>Current Ping Power</h4> <p>%s</p>', h($user['User']['ping_power']));

            if ($current_user['id'] == $user['User']['id'] || $current_user['Group']['name'] == 'admin') {
                echo sprintf('<h4>Email</h4> <p>%s</p>', h($user['User']['email']));
                echo sprintf('<h4>Age</h4> <p>%s</p>', h($user['User']['age']));
            }

            echo sprintf('<h4>Username</h4> <p>%s</p>', h($user['User']['username']));
            echo sprintf('<h4>Is member of the group</h4> <p>%s</p>', h(ucfirst($user['Group']['name'])));

            echo sprintf('<h4>Dojo</h4> <p>%s</p>', h($user['User']['school']));
            echo sprintf('<h4>Account Created</h4> <p>%s</p>', h($user['User']['created']));
            echo sprintf('<h4>Account Modified</h4> <p>%s</p>', h($user['User']['modified']));
            ?>

        </div>
        <div class="box-footer" style="text-align: right">            
            <div class="btn-group">
                <?php
                if ($current_user['id'] == $user['User']['id'] || $current_user['Group']['name'] == 'admin') {
                    echo $this->Html->link('Edit Profile', array('controller' => 'users', 'action' => 'edit', $user['User']['id']), array('title' => 'Edit your profile', 'class' => 'btn btn-default'));
                    echo $this->Form->postLink(__('Delete Account'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $user['User']['id']));
                }
                ?>             
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-cloud"></i>
            <h3 class="box-title">Assets</h3>
        </div>
        <div class="box-body">
            <div class="callout callout-info">
                <h4>Note</h4>
                <p>This is a list of the assets you have in Pingster.</p>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('id'); ?></th>
                            <th><?php echo $this->Paginator->sort('asset'); ?></th>
                            <th><?php echo $this->Paginator->sort('asset_url'); ?></th>
                            <th><?php echo $this->Paginator->sort('asset_status'); ?></th>
                            <th><?php echo $this->Paginator->sort('created'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($assets as $asset): ?>
                            <tr>
                                <td><?php echo h($asset['Assets']['id']); ?>&nbsp;</td>
                                <td><?php echo h($asset['Assets']['asset']); ?>&nbsp;</td>
                                <td><?php echo h($asset['Assets']['asset_url']); ?>&nbsp;</td>
                                <td><?php echo h($asset['Assets']['asset_status']); ?>&nbsp;</td>
                                <td><?php echo h($asset['Assets']['created']); ?>&nbsp;</td>
                            </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
