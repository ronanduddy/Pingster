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

    <?php if (!empty($data['projects'])): ?>
        <?php foreach ($data['projects'] as $projectKey => $projectData) : ?>

            <div class="masonryItem">
                <div class="box box-primary no-border">
                    <div class="box-header">
                        <?php
                        // get path info => extension
                        $pathinfo = pathinfo($projectData['Project']['image_url']);
                        ?>
                        <?php if (isset ($pathinfo['extension']) && in_array(strtolower($pathinfo['extension']), array('jpg', 'jpeg', 'gif', 'png', 'apng', 'svg', 'bmp', 'ico'))) : ?>
                            <div class="thumbnail">
                                <?php
                                echo $this->Html->image(
                                        $projectData['Project']['image_url'], array(
                                    'class' => 'lazy',
                                    'data-original' => $projectData['Project']['image_url'],
                                    'url' => array(
                                        'controller' => 'Projects',
                                        'action' => 'viewTeamUp',
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
                                            'action' => 'viewTeamUp',
                                            $projectData['Project']['id']
                                    )));
                                    ?>
                                <?php
                                endif;
                                ?>

                            </div>
                    </div>

                    <div class="box-body">
                    <h3 class="box-title">
                            <?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($projectData['Project']['title']))); ?>
                    </h3>
                    <?php echo $projectData['Project']['description']; ?>
                    </div>
                        <div class="box-footer">
                            <p style="text-align: right">
                                <?php
                                echo $this->Html->link('View', array('controller' => 'Projects', 'action' => 'viewTeamUp', $projectData['Project']['id']), array('title' => 'View this Team Up', 'class' => 'btn btn-primary'));
                                ?>
                            </p>
                        </div>
                    </div>      
                </div>

            <?php endforeach; ?>
        <?php endif; ?>


        <div class="masonryItem">
            <div class="box box-success no-border">
                <div class="box-footer">
                    <p style="text-align: right">
                        <?php
                        echo $this->Html->link('Create', array('controller' => 'Projects', 'action' => 'addTeamUp'), array('title' => 'Create a Team Up', 'class' => 'btn btn-success btn-lg btn-block'));
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="masonryItem">
            <div class="box box-info no-border">
                <div class="box-body">
                    <nav>
                    <?php
                    echo $this->Paginator->counter(array(
                        'format' => __('Page {:page} of {:pages}')
                    ));
                    ?>
                    </nav>
                </div>
                <div class="box-footer">
                    <ul class="pagination btn-group">
                        <?php
                        echo $this->Paginator->prev('< ' . __('previous'), array('tag' => 'li'), null, array('class' => 'btn btn-default disabled'));
                        echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'btn btn-default'));
                        echo $this->Paginator->next(__('next') . ' >', array('tag' => 'li'), null, array('class' => 'btn btn-default disabled'));
                        ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>
