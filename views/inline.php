<!-- The Gallery as inline carousel, can be positioned anywhere on the page -->
<div id="<?php echo $id; ?>" class="blueimp-gallery blueimp-gallery-carousel <?php echo($controls ? 'blueimp-gallery-controls' : ''); ?>">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <?php if ($controls): ?>
        <a class="prev">‹</a>
        <a class="next">›</a>
    <?php endif; ?>
    <?php if ($slideshow): ?>
        <a class="play-pause"></a>
    <?php endif; ?>
    <?php if ($indicator): ?>
        <ol class="indicator"></ol>
    <?php endif; ?>
</div>