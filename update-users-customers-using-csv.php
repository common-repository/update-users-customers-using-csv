<?php
/*
Plugin Name: Update users & customers using csv
Description: This plugin will help you to update woocommerce customers or/and wp users details in bulk using csv file
Author: Passionate Brains
Version: 1.0
WC requires at least: 3.7.0
WC tested up to: 4.2.0
License: GPLv2 or later
*/

/* initiating plugin */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/* Defining some of constant which will be helpful throughout */
if ( !defined( 'WUUC_BASENAME' ) ) {
    define( 'WUUC_BASENAME', plugin_basename( __FILE__ ) );
}
if ( !defined( 'WUUC_DIR' ) ) {
    define( 'WUUC_DIR', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WUUC_URL' ) ) {
    define( 'WUUC_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WUUC_SITE_URL' ) ) {
    define( 'WUUC_SITE_URL', site_url() );
}
if ( !defined( 'WUUC_SITE_DOMAIN' ) ) {
    define( 'WUUC_SITE_DOMAIN', trim( str_ireplace( array( 'http://', 'https://' ), '', trim( WUUC_SITE_URL, '/' ) ) ) );
}
if ( !defined( 'WUUC_PREFIX' ) ) {
    define( 'WUUC_PREFIX', 'WUUC_' );
}
if ( !defined( 'WUUC_VERSION' ) ) {
    define( 'WUUC_VERSION', '1.0' );
}

/* Definining main class */
if ( !class_exists( 'Update_Customer' ) ) {
  class Update_Customer {
    private static  $instance = null ;
    private  $main ;
    private  $admin;
    public static function get_instance()
    {
        if ( !self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function __construct()
    {
        $this->includes();
        $this->init();
    }
    /*loads other support classes*/
    private function includes()
    {
        //require_once WUUC_DIR . 'main/class-wuuc-main.php';
        require_once WUUC_DIR . 'main/class-wuuc-admin.php';
    }
    /* init support classes*/
    private function init()
    {
        //$this->main = new WUUC_Main();
        $this->admin = new WUUC_Admin();
    }
  }
}
add_action( 'plugins_loaded', array( 'Update_Customer', 'get_instance' ) );
