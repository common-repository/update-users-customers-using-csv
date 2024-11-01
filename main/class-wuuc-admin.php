<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/*
 * Declaring Class
 */
class WUUC_Admin {
	/* initiating variables */
  private $slug;
  private $page_id = null;
  protected $tabs = array();
  public function __construct() {
		$this->slug = 'woo_update_customer';
		$this->page_id = add_menu_page(
			"Update Customer",
			"Update Customer",
			'manage_options',
			"woo_update_customer",
			array( $this, 'render' ),
			WUUC_URL.'assests/images/WoocommerceAnalyticsFevicon.png'
		);
    add_action( 'admin_menu', array( $this, 'add_menu_pages' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'wuuc_enqueue_scripts' ) );
		add_filter( 'plugin_action_links_' . WUUC_BASENAME, array( $this, 'settings_link' ) );
		add_action( 'load-' . $this->page_id, array( $this, 'on_load' ) );
  }

	/* page on load function */
	public function on_load(){
    $this->tabs = array(
       'upload'   => 'Upload',
       'rule' => 'File Rules',
       'history' => 'History',
    );
  }
	/* getting slug value */
  public function get_slug() {
    return $this->slug;
  }

  /* creating view for individual tab */
  public function view( $name, $options = array() ) {
		$file    = WUUC_DIR . "inc/view/{$name}.php";
		$content = '';
		if ( is_file( $file ) ) {
			ob_start();
			if ( isset( $options['id'] ) ) {
				$options['orig_id'] = $options['id'];
				$options['id']      = str_replace( '/', '-', $options['id'] );
			}
			extract( $options );
			include $file;
			$content = ob_get_clean();
		}
		echo $content;
	}

  /* Get tab name for settings page */
  public function get_current_tab() {
		$tabs = $this->get_tabs();
		if ( isset( $_GET['view'] ) && array_key_exists( wp_unslash( $_GET['view'] ), $tabs ) ) {
			return wp_unslash( $_GET['view'] );
		}
		if ( empty( $tabs ) ) {
			return false;
		}
		reset( $tabs );
		return key( $tabs );
	}

  /* getting tab url */
  public function get_tab_url( $tab ) {
    $tabs = $this->get_tabs();
    if ( ! isset( $tabs[ $tab ] ) ) {
      return '';
    }
    if ( is_multisite() && is_network_admin() ) {
      return network_admin_url( 'admin.php?page=' . $this->slug . '&view=' . $tab );
    } else {
      return admin_url( 'admin.php?page=' . $this->slug . '&view=' . $tab );
    }
  }

  /*getting all tabs*/
  protected function get_tabs() {
    return  $this->tabs;
  }

  /* setting link to plugins page*/
	public function settings_link( $links, $url_only = false, $networkwide = false ) {
    $settings_page = is_multisite() && is_network_admin() ? network_admin_url( 'admin.php?page=woo_update_customer' ) : menu_page_url( 'woo_update_customer', false );
    $settings_page = $url_only && $networkwide && is_multisite() ? network_admin_url( 'admin.php?page=woo_update_customer' ) : $settings_page;
    $settings      = '<a href="' . $settings_page . '">Settings</a>';
    if ( $url_only ) {
      return $settings_page;
    }
    if ( ! empty( $links ) ) {
      array_unshift( $links, $settings );
    } else {
      $links = array( $settings );
    }
    return $links;
  }

	/*  enqueue scripts */
  public function wuuc_enqueue_scripts() {
    $this->register_scripts();
    if (isset($_GET['page']) && ($_GET['page'] == 'woo_update_customer')) {
        wp_enqueue_style('wuuc_material_css');
        wp_enqueue_style('wuuc_css');
        wp_enqueue_script('wuuc_material_js');
				wp_enqueue_script('wuuc_js');
        wp_enqueue_style( 'wuuc_icons' );
    }
  }

  /* registering scripts */
  private function register_scripts() {
    wp_register_style( 'wuuc_material_css', WUUC_URL . 'assests/css/materialize.min.css', false, null);
    wp_register_style( 'wuuc_css', WUUC_URL . 'assests/css/wuuc.css', false, null);
    wp_register_style( 'wuuc_icons', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
    wp_register_script('wuuc_material_js', WUUC_URL . 'assests/js/materialize.min.js', array('jquery'), null, true);
		wp_register_script('wuuc_js', WUUC_URL . 'assests/js/wuuc.js', array('jquery'), null, true);
  }


  public function add_menu_pages() {
		$title = "Update Customer";
		$this->pages['wuuc'] = $this->page_id;
	}

  public function render(){
?>
	<div class="row">
	 <div class="col s12 m12 l3 xl3">
		 <div class="content-pad">
			 <img class="responsive-img small-plugin-image" src="<?php echo WUUC_URL . 'assests/images/WoocommerceAnalytics.png'; ?>">
		 </div>
		 <ul class="collection menu-collection">
			 <?php
			 foreach ( $this->get_tabs() as $tab => $name ) {
					 ?>
					 <a href="<?php echo  esc_url( $this->get_tab_url( $tab ) ); ?>" class="collection-item <?php echo  ( $tab === $this->get_current_tab() ? 'white z-depth-1' : null ) ;?>">
						 <li><span><?php echo  esc_html( $name );?></span>
							 <?php echo '<i class="material-icons right">check_circle</i>';?>
						 </li>
					 </a>
				 <?php
			 }
		 ?>
		 </ul>
	 </div>
	 <div class="content-pad">
		 <div class="col s12 m12 l9 xl9 white main-content">
			 <?php
			$current_tab = $this->get_current_tab();
			$expires_headers = $this->view_options( $current_tab );
			$this->view( $current_tab, $expires_headers );
			?>

		 </div>
	</div>
  <?php
  }


	/* suppling setting and some required values */
	private function view_options( $tab ){
			switch ( $tab ) {
				 case 'upload':
						return array();
				 case 'rule':
					 return array();
				 case 'history':
						 return array();
				 defult:
					 return array();
			}
	 }
}
