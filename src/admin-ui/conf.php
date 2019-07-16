<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$plugins = get_plugins();
?>


<div class="wrap">

	<form name="one-click-deployer" method="post" action="">
		
		<h2><?php esc_html_e('Configure deploy theme', 'one-click-deployer') ?></h2>
		
    <?php wp_nonce_field('__ocd_nonce', 'ocd-ftpsetup') ?>

    <table class="form-table">
      <tbody>
        <tr>
          <th>
		        <label for="one-click-deployer-conf-ftphostname"><?php esc_html_e('Host ftp', 'one-click-deployer') ?></label>
          </th>
          <td>
			      <input type="text" name="one-click-deployer-conf-ftphostname" id="one-click-deployer-conf-ftphostname"/>
          </td>
        </tr>
        <tr>
          <th>
		        <label for="one-click-deployer-conf-ftpusername"><?php esc_html_e('User ftp', 'one-click-deployer') ?></label>
          </th>
          <td>
			      <input type="text" name="one-click-deployer-conf-ftpusername" id="one-click-deployer-conf-ftpusername"/>
          </td>
        </tr>
        <tr>
          <th>
		        <label for="one-click-deployer-conf-ftppassword"><?php esc_html_e('Password ftp', 'one-click-deployer') ?></label>
          </th>
          <td>
			      <input type="password" name="one-click-deployer-conf-ftppassword" id="one-click-deployer-conf-ftppassword"/>
          </td>
        </tr>
        <tr>
          <th>
		        <label for="one-click-deployer-conf-ftpbasepath"><?php esc_html_e('Base path ftp', 'one-click-deployer') ?></label>
          </th>
          <td>
			      <input type="text" name="one-click-deployer-conf-ftpbasepath" id="one-click-deployer-conf-ftpbasepath"/>
          </td>
        </tr>
			</tbody>
		</table>
    <?php submit_button(__('Save Configuration', 'one-click-deployer'), 'primary', 'one-click-deployer-submit-conf') ?>
	</form>
</div>
