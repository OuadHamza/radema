<?php

	//function to generate response
	function my_contact_form_generate_response($type, $message){

		if($type == "success") $response = "<div class='alert alert-success' role='alert'>{$message}</div>";
		else $response = "<div class='alert alert-danger' role='alert'>{$message}</div>";
		
		return $response;
	}
	if(isset($_POST['form-submited'])){
		$invalid_email   = translate_options_radeema('Invalid email', 'radeema').".";
		$not_human       = translate_options_radeema('Incorrect verification', 'radeema').".";
		$message_unsent  = translate_options_radeema('The message was not sent. Try again', 'radeema').".";
		$message_sent    = translate_options_radeema('Thank you! Your message has been sent', 'radeema').".";
		if( is_email($_POST['message_email']) ) {
			//user posted variables
			$phone = sanitize_text_field( $_POST['message_phone'] );
			$email = sanitize_email( $_POST['message_email'] );
			$message = sanitize_text_field( $_POST['form_message'] ).
				"\r\n telephone: ".$phone;
			 
			//php mailer variables
			$to = get_option('admin_email');
			$subject = "Someone sent a message from ".
				sanitize_text_field( $_POST['message_name'] ).": ".sanitize_text_field( $_POST['message_subject'] );

			$headers = 'From: '. $email . "\r\n" . 
				'Reply-To: ' . $email . "\r\n";

			if($_POST['input_human'] != $_POST['message_validate']){
				$response = my_contact_form_generate_response("error", $not_human);
				
			}else {
				$sent = wp_mail($to, $subject, strip_tags($message) , $headers);

				if($sent) $response = my_contact_form_generate_response("success", $message_sent); 

				else $response = my_contact_form_generate_response("error", $message_unsent);
			}
		} else {
			$response = my_contact_form_generate_response("error", $invalid_email);
		}
	}

	$six_digit_random_number = random_int(100000, 999999);
?>

<?php get_header(); ?>


	<div class="container pt-3">
		<h2><?= /*Contactez nous*/ translate_options_radeema('Contact us', 'radeema') ?></h2>
		<form class="py-5" action="" method="post">
				<?php if(isset($response)) echo $response ?>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="nom"><?= translate_options_radeema('Full name', 'radeema') ?></label>
						<input type="text" class="form-control" id="nom" name="message_name" required>
					</div>
					<div class="form-group">
						<label for="email"><?= translate_options_radeema('Email address', 'radeema') ?></label>
						<input type="email" class="form-control" id="email" required aria-describedby="emailHelp" name="message_email">
						<small id="emailHelp" class="form-text text-muted"><?= translate_options_radeema("We'll never share your email with anyone else", 'radeema') ?>.</small>
					</div>
					<div class="form-group">
						<label for="tele"><?= translate_options_radeema('Phone', 'radeema') ?></label>
						<input type="text" class="form-control" id="tele" name="message_phone">
					</div>
					<div class="form-group">
						<label for="objet"><?= translate_options_radeema('Object', 'radeema') ?></label>
						<input type="text" class="form-control" id="objet" name="message_subject">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="message"><?= translate_options_radeema('Message', 'radeema') ?></label>
						<textarea id="message" class="form-control" rows="12" name="form_message" required></textarea>
					</div>
				</div>
			</div>
			<div class="w-100 text-center">
				<div class="w-100 py-2">

					<label><?= translate_options_radeema('repeat this number', 'radeema') ?></label>	
					<span class="verify-form"><?= $six_digit_random_number ?></span>
					<input type="hidden" readonly name="message_validate" value="<?= $six_digit_random_number ?>">

					<input type="text" name="input_human" required>
				</div>
				<input type="submit" class="btn-radeema btn-radeema-primary" value="<?= translate_options_radeema('Send', 'radeema') ?>" name="form-submited">
			</div>
		</form>
	</div>
	
<?php get_footer(); ?>