<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>


<div class="wrap">
	<!-- <h1><?= __('Deploy your site', 'one-click-deployer') ?></h1>
	<p><?= __('Define what you want to deploy', 'one-click-deployer') ?></p> -->

	<form name="one-click-deployer" method="post" action="">
		<h2><?= __('Deploy theme', 'one-click-deployer') ?></h2>

		<table class="form-table">
			<tbody><tr>
				<th scope="row">
					<label for="deploy-current-theme"><?= __('Send current theme :', 'one-click-deployer') ?> </label>
				</th>
				<td>
					<input type="checkbox" name="deploy-current-theme" id="deploy-current-theme" value="1"/>
				</td>
			</tr></tbody>
		</table>

		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
		</p>

	</form>

</div>
