<? if(isset($post)): ?>
<article class="active">
	<aside class="meta cs_2 fc">
		<?php
			$timestamp = new DateTime($post['post_pub_date']);
		?>
		<time datetime="<?=$timestamp->format('Y-m-d')?>">
		<?php
			echo $timestamp->format('d. M. Y');
		?>
		</time>
		<span class="author">by Jakob Bossek</span>
		<span class="comments">(Comments currently closed)</span>
		<?
		/*
		<ul class="taglist">
			<li><a href="http://www.jakobbossek.de/#">statistics</a></li>
			<li><a href="http://www.jakobbossek.de/#">optim</a></li>								
		</ul>
		*/
		?>
	</aside>
	<div class="cs_6 lc">
		<h3><?=$post['post_title']?></h3>
		<?=$post['post_content']?>
	</div>
</article><!-- blog post - endof-->
<? else: ?>
<p>Article not found!</p>
<? endif; ?>