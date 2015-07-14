                    </div><!-- /.box-body -->

                    <div class="box-footer clearfix">  
                        <div class="pull-right">
                            <div class="btn-group">
                                <?php foreach ($footLinks as $link) : ?>
                                    <?php echo $link; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php if($showPaginate) : ?>
                            <div class="pull-left">
                                <p>
                                    <?php
                                    echo $this->Paginator->counter(array(
                                        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                                    ));
                                    ?>	</p>
                                <div class="pagination pagination-sm no-margin">
                                    <?php
                                    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                                    echo $this->Paginator->numbers(array('separator' => ''));
                                    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>                      
                    </div><!-- box-footer -->
                </div><!-- /.box -->
            </div><!-- /.col (MAIN) -->
        </div>

</section><!-- /.content -->