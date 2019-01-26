<div id="news">
	<div class="title">Newsy</div>

	<?php foreach($records as $row): ?>
		<div class="content">
			<div class="left">
				<div class="img">
					<a href="<?php echo base_url(); ?>images/posts/<?php echo $row->img_name; ?>" data-lightbox="img/posts/'.$img.'.jpg" >
						<img src="<?php echo base_url(); ?>images/posts/thumbs/<?php echo $row->img_name; ?>" width="100%" height="auto">
					</a>
				</div>
				<div class="postdate">
					Data dodania: <?php echo $row->date; ?>
				</div>
			</div>
			<div class="right">
				<div class="posttitle">
					<?php echo $row->title; ?>
				</div>
				<div class="postcontent">
					<p><?php echo $row->post; ?></p>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	<?php endforeach ?>
	
	<div id='pageslink'><?php echo $page_links ?></div>
	<div class="clear"></div>
