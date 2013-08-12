<?php $first = true; ?>
<? foreach($posts as $post): ?>
<? if($first):?>
<article class="active clearfix">
<?php $first = false; ?>
<? else: ?>
<article class="clearfix">
<? endif; ?>
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
		<?=$post['post_excerpt']?>
		<a href="<?=Helper::link(array("blog", "show", $post['post_name']))?>" title="read full article">Read entire article</a>
	</div>
</article><!-- blog post - endof-->
<? endforeach; ?>