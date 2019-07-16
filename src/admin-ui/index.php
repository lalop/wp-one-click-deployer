<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>


<div class="wrap">
	<p><?php esc_html_e('Define what you want to deploy', 'one-click-deployer') ?></p> -->

	<form name="one-click-deployer" method="post" action="">
		<h2><?php esc_html_e('Deploy theme', 'one-click-deployer') ?></h2>

		<table class="form-table">
			<tbody><tr>
				<th scope="row">
					<label for="deploy-current-theme"><?php esc_html_e('Send current theme :', 'one-click-deployer') ?> </label>
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
