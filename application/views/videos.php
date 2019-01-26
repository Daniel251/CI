<div id='videos'>
    <div class='content'>
        <div class='title'>Filmy</div>

        <?php foreach($big_player as $row): ?>
            <div id="big_player">
                <iframe width="960" height="540" src="<?php echo str_replace("watch?v=","embed/", $row->link); ?>" frameborder="0" allowfullscreen></iframe>
            </div>
        <?php endforeach ?>
        <?php foreach($videos as $row): ?>
            <div class="vid">
                <a class="swipebox-video"  href="<?php echo $row->link; ?>">
                    <div class="dark">
                        <img src="<?php echo base_url(); ?>images/videos/<?php echo $row->img_name; ?>" alt="image">
                    </div>
                    <div class="video_description">
                        <?php echo $row->description; ?>
                    </div>
                </a>
            </div>
        <?php endforeach ?>
        <div class="clear"></div>
</div>
<script src='js/jquery.swipebox.min.js'></script>
<script type="text/javascript">
$( document ).ready(function() {
        /* Video */
        $( '.swipebox-video' ).swipebox();
  });
</script>