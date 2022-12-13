<?php 
	$urls = get_post_meta( get_the_ID(), 'custom_url_files', true );
	if(!empty($urls)){

		$urls = explode(",", $urls);
		$file_name = "";
		foreach($urls as $url){ 

			if( file_exists( str_replace(get_site_url().'/', '', $url) ) ){
				$url_pieces = explode("/", $url);
				$file_name = $url_pieces[count($url_pieces)-1]
				?>

				<table class="w-100 mt-4">
					<tr>
						<td><?= $file_name ?></td>
						<td style="text-align: right;"><a href="<?= $url ?>" class="btn-radeema btn-radeema-primary" download><?= translate_options_radeema('Download', 'radeema') ?></a></td>
					</tr>
				</table>

			<?php }
		}
	}
?>