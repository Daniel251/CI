<div id="news">
	<div class="title">Newsy</div>

	<?php foreach($records as $row): ?>
		<div class="content">
			<div class="left">
				<div class="img">
					<a href="<?= base_url() ?>images/posts/<?= $row->img_name ?>" data-lightbox="img/posts/'.$img.'.jpg" >
						<img src="<?= base_url() ?>images/posts/thumbs/<?= $row->img_name ?>" width="100%" height="auto">
					</a>
				</div>
				<div class="postdate">
					Data dodania: <?= $row->date ?>
				</div>
			</div>
			<div class="right">
				<div class="posttitle">
					<?= $row->title ?>
				</div>
				<div class="postcontent">
					<p><?= $row->post ?></p>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	<?php endforeach ?>
	
	<div id='pageslink'><?= $page_links ?></div>
	<div class="clear"></div>