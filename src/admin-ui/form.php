<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$plugins = get_plugins();
?>


<div class="wrap">
	<p><?php esc_html_e('Define what you want to deploy', 'one-click-deployer') ?></p>

	<form name="one-click-deployer" method="post" action="">
		
		<h2><?php esc_html_e('Deploy theme', 'one-click-deployer') ?></h2>

		<?php wp_nonce_field('__ocd_nonce', 'ocd-deploy') ?>

		<label for="deploy-current-theme">
			<input type="checkbox" name="deploy-current-theme" id="deploy-current-theme" value="1"/>
			<?php esc_html_e('Send current theme', 'one-click-deployer') ?> 
		</label>

    <?php submit_button(__('deploy', 'one-click-deployer')) ?>
	</form>
</div>
