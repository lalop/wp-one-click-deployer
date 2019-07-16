<?php
/**
 * Plugin Name: One click deployer
 * Description: A wordpress deployer tool
 * Version: 0.0.1
 * Author: Samuel Laulhau
 * Author URI: https://samuellaulhau.fr
 * Text Domain: one-click-deployer
 */
 
 
add_action('admin_menu', 'one_click_deployer_admin_menu');
add_action('wp_before_admin_bar_render', 'one_click_deployer_toolbar', 999 );

function one_click_deployer_admin_menu() {
  add_management_page(
    __('Deploy', 'one-click-deployer'),
    __('One Click Deployer', 'one-click-deployer'), 
    'administrator', 
    'one-click-deployer', 
    'one_click_deployer_page'
  );
}

function one_click_deployer_toolbar() {
	global $wp_admin_bar;
	$args = array(
		'id' => 'one-click-deployer',
    'title' => '<i class="ab-icon dashicons-update"></i>'.__('Deploy', 'one-click-deployer'), 
    'group' => false,
    'href'   => admin_url('/tools.php?page=one-click-deployer'),
	);
	$wp_admin_bar->add_menu($args);
}

function one_click_deployer_page() {
  array_map(function($file) {
    include_once $file;
  }, glob(dirname(__FILE__) . '/includes/*'));

  if(isset($_POST['one-click-deployer-submit-conf']) && check_admin_referer('__ocd_nonce', 'ocd-ftpsetup')) {
    one_click_deployer_save_credentials($_POST);
  }

  if(isset($_POST['submit']) && check_admin_referer('__ocd_nonce', 'ocd-deploy')) {
    if(isset($_POST['deploy-current-theme'])) {
      echo '<div class="wrap">';
      one_click_deployer_send_current_theme();
      echo '</div>';
    }
  } elseif(one_click_deployer_get_config() === null) {
    include_once dirname(__FILE__) . '/admin-ui/conf.php';
  } else {
    include_once dirname(__FILE__) . '/admin-ui/form.php';
  }
}

function one_click_deployer_get_config() {
  return get_option('ocd_ftp', null);
}

function one_click_deployer_send_current_theme() {
  $remote = new OneClickDeployerRemoteServer(one_click_deployer_get_config());
  $remote->syncFiles('wp-content/themes/'.get_stylesheet());
  esc_html_e('theme sent', 'one-click-deployer');
}

function one_click_deployer_save_credentials($postData) {

  $submittedSetup = [
    'hostname' => $postData['one-click-deployer-conf-ftphostname'],
    'username' => $postData['one-click-deployer-conf-ftpusername'],
    'password' => $postData['one-click-deployer-conf-ftppassword'],
    'basepath' => $postData['one-click-deployer-conf-ftpbasepath']
  ];

  /** checks widely inspired from https://codex.wordpress.org/Function_Reference/request_filesystem_credentials */
  $submittedSetup = wp_unslash($submittedSetup);
  // Sanitize the hostname, Some people might pass in odd-data:
  $submittedSetup['hostname'] = preg_replace( '|\w+://|', '', $submittedSetup['hostname'] ); //Strip any schemes off
  
  if (strpos($submittedSetup['hostname'], ':')) {
		list($submittedSetup['hostname'], $submittedSetup['port']) = explode( ':', $submittedSetup['hostname'], 2);
		if (!is_numeric($submittedSetup['port'])) {
			unset($submittedSetup['port']);
		}
  }
  
  update_option('ocd_ftp', $submittedSetup);
}