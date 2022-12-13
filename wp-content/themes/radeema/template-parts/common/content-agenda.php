<?php

$events_args = array (
	'post_type' => 'tribe_events',
	'ignore_sticky_posts' => true,
	'posts_per_page' => 3,
);
$events_posts = new WP_Query( $events_args );

?>


<h2 class="agenda-block-title"><?= translate_options_radeema('AGENDA') ?></h2>
<?php if( $events_posts->have_posts() ) { ?>

	<ul>

		<?php while( $events_posts->have_posts() ) {
			$events_posts->the_post(); 

			$date_start = get_post_meta(get_the_ID(), '_EventStartDate', true);
			$date_end = get_post_meta(get_the_ID(), '_EventEndDate', true);


			$day_start = wp_date('d', strtotime($date_start));
			$month_start = wp_date('M', strtotime($date_start));

			$day_end = wp_date('d', strtotime($date_end));
			$month_end = wp_date('M', strtotime($date_end)); ?>

			<li>
				<div class="row">
					<div class="col-3 agenda-date-block">
						<a href="<?php the_permalink(); ?>">
						<?php if($month_start == $month_end){ 
							if($day_end == $day_start){ ?>

								<h2 class="agenda-date"><?= $day_start."<br>".$month_start ?></h2>
							<?php }else { ?>
								<h2 class="agenda-date"><?= $day_start."- ".$day_end."<br>".$month_start ?></h2>
							<?php } ?>
						</a>
						<?php }else { ?>

							<h2 class="agenda-date"><?= $day_start." ".$month_start."<br>-<br>".$day_end." ".$month_end ?></h2>
						<?php } ?>
						
					</div>
					<div class="col-9 agenda-desc-block">
						<a href="<?php the_permalink(); ?>">
						<div class="agenda-content">
							<h4><?php the_title(); ?></h4>
							<?php the_excerpt(); ?>
						</div>
						</a>
					</div>
				</div>
			</li>
		<?php } ?>	
	</ul>
<?php } ?>