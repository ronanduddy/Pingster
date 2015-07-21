<?php //debug($data);           ?>
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

    <div id="dialogProjectsCreate"></div>
    <div class="masonryItem">     
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    Make a Ping!
                </h3>
            </div>
            <div class="box-footer">
                <p style="text-align: right">
                    <?php
                      echo $this->Html->link('Create',
                        array(
                          'controller' => 'Projects',
                          'action' => 'addPing'
                        ),
                        array(
                          'id' => 'ProjectsCreateButton',
                          'title' => 'Create a Ping project',
                          'class' => 'btn btn-success btn-lg'
                        )
                      );
                    ?>
                </p>
            </div>
        </div>      
    </div>

    <?php if (!empty($data['projects'])): ?>
        <?php foreach ($data['projects'] as $projectKey => $projectData) : ?>

            <div class="masonryItem">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-folder-o"></i>
                        <h3 class="box-title">
                            <?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($projectData['Project']['title']))); ?>
                            <small><?php echo h(Project::statuses($projectData['Project']['status']) . ' ' . Project::kinds($projectData['Project']['kind'])); ?></small>
                        </h3>
                    </div>

                    <div class="box-body">


                        <?php
                        // get path info => extension
                        $pathinfo = pathinfo($projectData['Project']['image_url']);
                        ?>
                        <?php if (in_array(strtolower($pathinfo['extension']), array('jpg', 'jpeg', 'gif', 'png', 'apng', 'svg', 'bmp', 'ico'))) : ?>
                            <div class="thumbnail">
                                <?php
                                echo $this->Html->image(
                                        $projectData['Project']['image_url'], array(
                                    'class' => 'lazy',
                                    'data-original' => $projectData['Project']['image_url'],
                                    'url' => array(
                                        'controller' => 'Projects',
                                        'action' => 'viewPing',
                                        $projectData['Project']['id']
                                )));
                                ?>
                            <?php else: ?>
                                <div class="thumbnail" style="height:200px;">
                                    <?php
                                    echo $this->Html->image(
                                            null, array(
                                        'data-src' => 'holder.js/100%x100%/random/text:' . h(str_replace(' ', ' \n ', $projectData['Project']['title'])),
                                        'url' => array(
                                            'controller' => 'Projects',
                                            'action' => 'viewPing',
                                            $projectData['Project']['id']
                                    )));
                                    ?>
                                <?php endif; ?>
                            </div>
                            <?php if ($projectData['Tag'] != null) : ?>
                                <?php foreach ($projectData['Tag'] as $tag) : ?>
                                    <?php echo '<br>#' . h($tag['tag_content']); ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="box-footer">
                            <p style="text-align: right">
                                <?php
                                echo $this->Html->link('View', array('controller' => 'Projects', 'action' => 'viewPing', $projectData['Project']['id']), array('title' => 'View this Ping', 'class' => 'btn btn-primary'));
                                ?>
                            </p>
                        </div>
                    </div>      
                </div>

            <?php endforeach; ?>
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

<?php echo $this->Html->script('Pings'); ?>
