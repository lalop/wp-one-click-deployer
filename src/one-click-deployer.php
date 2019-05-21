<?php
/**
 * Plugin Name: One click deployerer
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

  if(isset($_POST['one-click-deployer-submit-conf']) && check_admin_referer( 'ocd-ftpsetup')) {
    $ftpSetup = [
      'hostname' => $_POST['one-click-deployer-conf-ftphostname'],
      'username' => $_POST['one-click-deployer-conf-ftpusername'],
      'password' => $_POST['one-click-deployer-conf-ftppassword'],
      'basepath' => $_POST['one-click-deployer-conf-ftpbasepath']
    ];
    file_put_contents(ABSPATH .'/one-click-deployer.json', json_encode([
      'ftp' => $ftpSetup
    ], JSON_PRETTY_PRINT));
  }

  if(isset($_POST['submit']) && check_admin_referer( 'ocd-deploy')) {
    if(isset($_POST['deploy-current-theme'])) {
      echo '<div class="wrap">';
      one_click_deployer_send_current_theme();
      echo '</div>';
    }
    if(isset($_POST['deploy-plugins']) && is_array($_POST['deploy-plugins'])) {
      foreach($_POST['deploy-plugins'] as $plugin) {
        one_click_deployer_send_plugin($plugin);
      }
    }
  } elseif(one_click_deployer_get_config() === null) {
    include_once dirname(__FILE__) . '/admin-ui/conf.php';
  } else {
    include_once dirname(__FILE__) . '/admin-ui/form.php';
  }
}

function one_click_deployer_get_config() {
  if(file_exists(ABSPATH .'/one-click-deployer.json')) {
    $conf = json_decode(file_get_contents(ABSPATH .'/one-click-deployer.json'), true) ?: null;
  } else {
    $conf = null;
  }
  return $conf;
}

function one_click_deployer_send_current_theme() {
  $remote = new OneClickDeployerRemoteServer(one_click_deployer_get_config());
  $remote->syncFiles('wp-content/themes/'.get_stylesheet());
  echo __('theme sent', 'one-click-deployer');
}

function one_click_deployer_send_plugin($plugin) {
  $plugin = trim(current(explode('/', $plugin)), '.');
  if(!$plugin) return;
  $remote = new OneClickDeployerRemoteServer(one_click_deployer_get_config());
  $remote->syncFiles("wp-content/plugins/{$plugin}");
  printf(__('plugin %s sent', 'one-click-deployer'), $plugin);
}
