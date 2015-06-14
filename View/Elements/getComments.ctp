<?php
$this->Paginator->options(array(
  'update' => '#commentsPage',
  'evalScripts' => true,
  'url' => array('controller' => 'Projects', 'action' => 'displayComments', $project['Project']['id'])
));
?>

<?php if (!empty($commentsList)): ?>
<style>
  #commentsPage .commentsFlash {
    border-radius: 4px 4px 4px 4px;
    background-color: #FF4400;
    margin-bottom: 20px;
    font-weight: bold;
    color: white;
    display: none;
    padding: 5px;
  }
</style>
<div id='commentsPage'>
  <div class="commentsFlash"></div>
  <ul class="timeline">

      <?php
      $day = 0;
      ?>

      <?php foreach ($commentsList as $comment): ?>

          <?php if ($day == 0) : ?>
              <li class="time-label">
                  <span class="bg-blue-gradient"> 
                      <?php
                      echo $this->Time->timeAgoInWords($comment['Comment']['created'], array('format' => 'F jS, Y', 'end' => '+1 year'));
                      $day = date("d", strtotime($comment['Comment']['created']));
                      ?>
                  </span>
              </li>
          <?php elseif ($day != date("d", strtotime($comment['Comment']['created']))): ?>
              <li class="time-label">
                  <span class="bg-blue-gradient"> 
                      <?php
                      echo $this->Time->timeAgoInWords($comment['Comment']['created'], array('format' => 'F jS, Y', 'end' => '+1 year'));
                      $day = date("d", strtotime($comment['Comment']['created']));
                      ?>
                  </span>
              </li>
          <?php endif; ?>

          <li>
              <i class="fa fa-comment"></i>
              <div class="timeline-item">
                  <span class="time">
                      <small class="text-muted">
                          <i class="fa fa-clock-o"></i> 
                          <?php echo $this->Time->niceshort($comment['Comment']['created']); ?>
                      </small>
                  </span>

                  <h3 class="timeline-header">        
                      <i class="fa fa-user"></i>
                      <?php
                      echo $this->Html->link($comment['User']['username'], array(
                          'controller' => 'users',
                          'action' => 'view',
                          $comment['User']['id']
                      ));
                      ?>
                  </h3>

                  <div class="timeline-body" style="border-bottom: 1px solid #f4f4f4">
                      <?php if ($comment['Comment']['asset_id'] != null) : ?>
                          <div class="thumbnail" style="height:auto;">
                              <?php
                              // get path info => extension
                              $pathinfo = pathinfo($comment['Asset']['asset_url']);
                              ?>
                              <?php if (in_array(strtolower($pathinfo['extension']), array('jpg', 'jpeg', 'gif', 'png', 'apng', 'svg', 'bmp', 'ico'))) : ?>
                                  <?php
                                  echo $this->Html->image(
                                          $comment['Asset']['asset_url'], array(
                                      'class' => 'lazy',
                                      'data-original' => $comment['Asset']['asset_url']
                                  ));
                                  ?>
                              <?php else: ?>
                                  <?php
                                  echo $this->Html->image(
                                          null, array(
                                      'data-src' => 'holder.js/100%x100%/random/text:' . h(str_replace(' ', ' \n ', $comment['Asset']['asset']))
                                  ));
                                  ?>
                              <?php endif; ?>                                   
                          </div>
                      <?php endif; ?>
                      <p class="message">                    
                          <?php echo h($comment['Comment']['comment']); ?>                   
                      </p>
                  </div>

                  <div class="timeline-footer">
                      <div class="clearfix">
                          <?php
                          if ($comment['Comment']['asset_id'] != null) {
                              echo $this->Html->link('Download ' . $comment['Asset']['asset'], $comment['Asset']['asset_url'], array('class' => 'btn btn-primary pull-left', 'target' => '_blank', 'title' => 'Download ' . $comment['Asset']['asset_url']));
                          }
                          if ($current_user['id'] == $comment['Comment']['user_id'] || $current_user['Group']['name'] == 'admins') {
                              echo $this->Html->link(__('Delete'), array('controller' => 'comments', 'action' => 'delete', 'ext' => 'json', $comment['Comment']['id'], '?' => array('projectId' => $project['Project']['id'], 'kind' => $project['Project']['kind'])), array('class' => 'btn btn-danger pull-right comment-deleter'), __('Are you sure you want to delete this comment & asset?', $comment['Comment']['id']));
                          } else {
                              if ($current_user['id'] == $comment['Comment']['user_id'] || $current_user['Group']['name'] == 'admins') {
                                  echo $this->Html->link(__('Delete'), array('controller' => 'comments', 'action' => 'delete', 'ext' => 'json', $comment['Comment']['id'], '?' => array('projectId' => $project['Project']['id'], 'kind' => $project['Project']['kind'])), array('class' => 'btn btn-danger pull-right comment-deleter'), __('Are you sure you want to delete this comment?', $comment['Comment']['id']));
                              }
                          }
                          ?>
                      </div>
                  </div>

              </div>
          </li>
      <?php endforeach; ?>
      <li>
          <i class="fa fa-clock-o"></i>
      </li>

  </ul>
</div>
<p>
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ));
    ?>	</p>
<div class="paging">
    <?php
    echo $this->Paginator->prev('< ' . __('previous'), array('class' => 'comment-navigator'), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => '', 'class' => 'comment-navigator'));
    echo $this->Paginator->next(__('next') . ' >', array('class' => 'comment-navigator'), null, array('class' => 'next disabled'));
    ?>
</div>

<script>
  function commentLoad(loc)
  {
    var block = $('#commentsBlock');
    block.fadeOut();
    $.ajax({dataType: "html", evalScripts: true, url: loc, success: function (data, textStatus) {
      block.hide();
      block.empty().append(data);
      block.fadeIn();
    }})
    .fail(function (jqxhr) {
      block.fadeIn({
        done: function () {
          commentDisplayError("Could not load this comment, sorry!");
        }
      });
    });
  }

  function commentDisplayError(message) {
    var flash = $("#commentsPage .commentsFlash");
    flash.hide();
    flash.empty().append(message);
    flash.slideDown("slow");
  }

  $(function () {
    $('#commentsBlock .comment-navigator a').bind('click', function (e) {
      var destination = $(e.target).attr('href');
      e.preventDefault();
      commentLoad(destination);
    });

    $('#commentsBlock .comment-deleter').bind('click', function (e) {
      var destination = $(e.target).attr('href');
      e.preventDefault();
      $.ajax({type: "POST", dataType: "html", evalScripts: true, url: destination, data: {_method: "POST"}, success: function (data, textStatus) {
        commentLoad('<?= $this->Paginator->url([$project['Project']['id'], 'controller' => 'Projects', 'action' => 'displayComments', 'page' => $this->Paginator->current('Comment')]) ?>');
      }})
      .fail(function (jqxhr) {
        var data = $.parseJSON(jqxhr.responseText);
        commentDisplayError(data.message);
      });
    });
  });
</script>

<?php else: ?>
    <div class="box box-solid">
        <div class="box-body">
            <p class="message">                    
                There are currently no comments associated with this project :'(                  
            </p>
        </div>
    </div>
<?php endif;
