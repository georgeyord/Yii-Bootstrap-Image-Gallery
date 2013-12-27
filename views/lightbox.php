<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
<div id="<?php echo $id; ?>" class="blueimp-gallery <?php echo($controls ? 'blueimp-gallery-controls' : ''); ?>">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <?php if ($controls): ?>
        <a class="prev">‹</a>
        <a class="next">›</a>
    <?php endif; ?>
    <a class="close">&times;</a>
    <?php if ($slideshow): ?>
        <a class="play-pause"></a>
    <?php endif; ?>
    <?php if ($indicator): ?>
        <ol class="indicator"></ol>
    <?php endif; ?>
</div>