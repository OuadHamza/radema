<div class="col-lg-5">
	<div class="row agenda-alerts-block <?= is_singular() ? "full-width" : "" ?>">
		<div class="col-lg-12 avis-alerts-block">
			<div class="py-4">
				<?php get_template_part( 'template-parts/common/content', 'avis_alert' ); ?>
			</div>
		</div>
		<div class="col-lg-12 agenda-block">
			<div class="py-4">
				<?php get_template_part( 'template-parts/common/content', 'agenda' ); ?>
			</div>
		</div>
	</div>
</div>