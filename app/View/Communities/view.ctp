<?php //debug($community);              ?>
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


    .masonryItem-double{
        width: 85%;
    }

</style>
<div id="masonryContainer" class="container">

    <div class="masonryItem masonryItem-double">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    <?php echo h($community['Community']['name']); ?>
                </h3>
            </div>
            <div class="box-body">
                <?php
                    $description = !empty($community['Community']['description']) ?
                        $community['Community']['description'] :
                        "The Ping world awaits you...";

                    echo $description;
                ?>
            </div>
            <div class="box-footer">
                <div class="btn-group" >
                    <?php
                    echo $this->Html->link('Back', array('controller' => 'communities', 'action' => 'index'), array('title' => 'Back to Communities', 'class' => 'btn btn-default btn-lg'));
                    echo $this->Html->link('Create new Ping', array('controller' => 'Projects', 'action' => 'addPing', 'public' => true, 'community' => $community['Community']['id']), array('title' => 'Create a Ping project', 'class' => 'btn btn-success btn-lg'));
                    ?>
                </div>
            </div>
        </div>      
    </div>

    <?php if (!empty($projects)): ?>
        <?php foreach ($projects as $project): ?>

            <div class="masonryItem">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-folder-o"></i>
                        <h3 class="box-title">
                            <?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($project['Project']['title']))); ?>
                            <small><?php echo h(Project::statuses($project['Project']['status']) . ' ' . Project::kinds($project['Project']['kind'])); ?></small>
                        </h3>
                    </div>

                    <div class="box-body">

                        <?php
                        // get path info => extension
                        $pathinfo = pathinfo($project['Project']['image_url']);
                        ?>
                        <?php if (in_array(strtolower($pathinfo['extension']), array('jpg', 'jpeg', 'gif', 'png', 'apng', 'svg', 'bmp', 'ico'))) : ?>
                            <div class="thumbnail">
                                <?php
                                echo $this->Html->image(
                                        $project['Project']['image_url'], array(
                                    'class' => 'lazy',
                                    'data-original' => $project['Project']['image_url'],
                                    'url' => array(
                                        'controller' => 'Projects',
                                        'action' => 'viewPing',
                                        $project['Project']['id']
                                )));
                                ?>
                            <?php else: ?>
                                <div class="thumbnail" style="height: 200px">
                                    <?php
                                    echo $this->Html->image(
                                            null, array(
                                        'data-src' => 'holder.js/100%x100%/random/text:' . h(str_replace(' ', ' \n ', $project['Project']['title'])),
                                        'url' => array(
                                            'controller' => 'Projects',
                                            'action' => 'viewPing',
                                            $project['Project']['id']
                                    )));
                                    ?>
                                <?php endif; ?>                                                     
                            </div>
                        </div>

                        <div class="box-footer">
                            <span class="pull-left">
                                <small class="badge pull-right bg-yellow"></small>
                                <small class="badge pull-right bg-blue"></small>
                                <small class="badge pull-right bg-red"></small>
                            </span>
                            <p style="text-align: right">
                                <?php
                                echo $this->Html->link('View', array('controller' => 'Projects', 'action' => 'viewPing', $project['Project']['id']), array('title' => 'View this Ping', 'class' => 'btn btn-primary'));
                                ?>
                            </p>
                        </div>
                    </div>      
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="masonryItem">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-folder"></i>
                        <h3 class="box-title">
                            None here!
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="thumbnail">
                            <h1 style="text-align: center"><i class="fa fa-question"></i></h1>
                        </div>                    
                        <p>This community hasn't any Pings yet</p>
                    </div>

                </div>      
            </div>
        <?php endif; ?>

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
