<?php //debug($data);            ?>
<style>
    @media(max-width:767px){
        .masonryItem{
            width: 26%;
            margin-right: 2px;
        }
    }
    @media(min-width:768px){
        .masonryItem{
            width: 35%;
        }
    }
    @media(min-width:992px){
        .masonryItem{
            width: 27%;
            margin-left: 4%;
        }
    }
    @media(min-width:1200px){
        .masonryItem{
            width: 25%;
        }
    }
</style>
<div id="masonryContainer" class="container">

    <div class="masonryItem">     
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    Communities
                </h3>
            </div>
            <div class="box-body">
                <div class="thumbnail" style="background-color: #e8535d">
                    <?php echo $this->Html->image('pingster.png'); ?>                
                </div>
                The Pingster Community
            </div>
            <div class="box-footer">
                <p style="text-align: right">
                    <?php
                    if ($current_user['Group']['name'] == 'admins') {
                        echo $this->Html->link('Create new community', array('controller' => 'communities', 'action' => 'add', 'admin' => true), array('title' => 'Create a Community', 'class' => 'btn btn-success btn-lg'));
                    }
                    ?>
                </p>
            </div>
        </div>      
    </div>

    <?php foreach ($communities as $community) : ?>

        <div class="masonryItem">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-folder-o"></i>
                    <h3 class="box-title">
                        <?php echo h($community['Community']['name']); ?>
                    </h3>
                </div>

                <div class="box-body">

                    <div class="thumbnail" style="height:200px;">
                        <?php
                        echo $this->Html->image(
                               null, array(
                            'data-src' => 'holder.js/100%x100%/random/text:' . h(str_replace(' ', ' \n ', $community['Community']['name'])),
                            'url' => array(
                                'controller' => 'communities',
                                'action' => 'view',
                                $community['Community']['id']
                        )));
                        ?>
                    </div>
                </div>

                <div class="box-footer">
                    <p style="text-align: right">
                        <?php
                        echo $this->Html->link('View', array('controller' => 'communities', 'action' => 'view', $community['Community']['id']), array('title' => 'View this Community', 'class' => 'btn btn-primary'));
                        ?>
                    </p>
                </div>
            </div>      
        </div>

    <?php endforeach; ?>

    <div class="masonryItem">
        <div class="box box-info">
            <div class="box-body">
                <p>
                    <?php
                    echo $this->Paginator->counter(array(
                        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                    ));
                    ?>	</p>
                <nav>
                    <ul class="pagination btn-group">
                        <?php
                        echo $this->Paginator->prev('< ' . __('previous'), array('tag' => 'li'), null, array('class' => 'btn btn-default disabled'));
                        echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'btn btn-default'));
                        echo $this->Paginator->next(__('next') . ' >', array('tag' => 'li'), null, array('class' => 'btn btn-default disabled'));
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

</div>
