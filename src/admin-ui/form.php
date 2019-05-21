<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$plugins = get_plugins();
?>


<div class="wrap">
	<!-- <h1><?= __('Deploy your site', 'one-click-deployer') ?></h1>
	<p><?= __('Define what you want to deploy', 'one-click-deployer') ?></p> -->

	<form name="one-click-deployer" method="post" action="">
		
		<h2><?= __('Deploy theme', 'one-click-deployer') ?></h2>

		<?php wp_nonce_field('ocd-deploy') ?>

		<label for="deploy-current-theme">
			<input type="checkbox" name="deploy-current-theme" id="deploy-current-theme" value="1"/>
			<?= __('Send current theme', 'one-click-deployer') ?> 
		</label>

    <?php submit_button(__('deploy', 'one-click-deployer')) ?>
	</form>
</div>
