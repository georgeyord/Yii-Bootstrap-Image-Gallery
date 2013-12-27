<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<!-- The Gallery as inline carousel, can be positioned anywhere on the page -->
<div id="<?php echo $id; ?>" class="blueimp-gallery <?php echo($controls ? 'blueimp-gallery-controls' : ''); ?>">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <?php if ($indicator): ?>
        <ol class="indicator"></ol>
    <?php endif; ?>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade" style="overflow: hidden;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <?php if ($controls): ?>
                        <button type="button" class="btn btn-default pull-left prev">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                            Previous
                        </button>
                        <button type="button" class="btn btn-primary next">
                            Next
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>