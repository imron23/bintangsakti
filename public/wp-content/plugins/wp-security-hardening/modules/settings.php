<?php

if (!defined('ABSPATH')) exit ('Peekaboo!');

if( !class_exists('whpSettingsClassHarden') ){
class whpSettingsClassHarden{
	
	protected $settings_parameters;
	protected $settings_prefix;
	protected $message;
	
	function __construct( $prefix ){
		$this->settings_prefix = $prefix;
		
		if( isset($_POST[$this->settings_prefix.'save_settings_field'] ) ){
			if(  wp_verify_nonce($_POST[$this->settings_prefix.'save_settings_field'], $this->settings_prefix.'save_settings_action') ){
				$options = array();
				foreach( $_POST as $key=>$value ){
					$options[$key] = sanitize_text_field( $value );
				}
				update_option( $this->settings_prefix.'_options', $options );
				
				$this->message = '<div class="alert alert-success">'.__('Settings saved', $this->settings_prefix ).'</div>';
				
			}
		}
	}
	
	function get_setting( $setting_name ){
		$inner_option = get_option( $this->settings_prefix.'_options');
		return $inner_option[$setting_name];
	}
	
	function create_menu( $parameters ){
		$this->settings_parameters = $parameters;
			
		add_action('admin_menu', array( $this, 'add_menu_item') );
		
	}
	
	 
	
	
	function add_menu_item(){
		
		foreach( $this->settings_parameters as $single_option ){
			if( $single_option['type'] == 'menu' ){
				add_menu_page(  			 
				$single_option['page_title'], 
				$single_option['menu_title'], 
				$single_option['capability'], 
				$this->settings_prefix.$single_option['menu_slug'],
				array( $this, 'show_settings' ),
				$single_option['icon'] 
				);
			}
			if( $single_option['type'] == 'submenu' ){
				add_submenu_page(  
				$single_option['parent_slug'],  
				$single_option['page_title'], 
				$single_option['menu_title'], 
				$single_option['capability'], 
				$this->settings_prefix.$single_option['menu_slug'],
				array( $this, 'show_settings' ) 
				);
			}
			if( $single_option['type'] == 'option' ){
				add_options_page(  				  
				$single_option['page_title'], 
				$single_option['menu_title'], 
				$single_option['capability'], 
				$this->settings_prefix.$single_option['menu_slug'],
				array( $this, 'show_settings' ) 
				);
			}
		}
		 
	}
	
	function show_settings(){
	 
		?>
		<div class="wrap tw-bs4">
		
	 
		<?php 
			echo $this->message;
		?>
		
		<form class="form-horizontal" method="post" action="">
		<?php 
		wp_nonce_field( $this->settings_prefix.'save_settings_action', $this->settings_prefix.'save_settings_field'  );
		$config = get_option( $this->settings_prefix.'_options');
		?>  
		<fieldset>

			<?php 
		foreach( $this->settings_parameters as $single_page ){
			foreach( $single_page['parameters'] as $key=>$value ){	
			 
				if( isset( $value['name'] ) ){
					$value_field = $config[$value['name']];
				}else{
					$value_field = false;
				}
				$interface_element = new whpFormElementsClass( $value['type'], $value, $value_field  );
				echo $interface_element->get_code();	 
			 
			}
		}
			
			?>

				
				   
				</fieldset>  

		</form>

		</div>
		<?php
	}
}	
}	
 
	
	
add_Action('init',  function (){
	 
	if( isset($_GET['page']) ){
		if( $_GET['page'] == 'wphwp_harden' || $_GET['page'] == 'wphwp_harden_fixers' ){
			$config_big = 
			array(
	
				array(
					'type' => 'menu',
					//'type' => 'submenu',
					//'parent_slug' => 'edit.php?post_type=cross_seo',
					'page_title' => __('WP Hardening', 'whp'),
					'menu_title' => __('WP Hardening', 'whp'),
					'capability' => 'manage_options',
					'menu_slug' => 'wp_harden',
					'icon' => plugins_url('/images/wp-harden-active.png', __FILE__ ),
					'parameters' => array(
						array(
							'type' => 'audit_processing',
						
						),
						
					)
				)
			);
		}else{
			$config_big = 
			array(

				array(
					'type' => 'menu',
					//'type' => 'submenu',
					//'parent_slug' => 'edit.php?post_type=cross_seo',
					'page_title' => __('WP Hardening', 'whp'),
					'menu_title' => __('WP Hardening', 'whp'),
					'capability' => 'manage_options',
					'menu_slug' => 'wp_harden',
					'icon' => plugins_url('/images/wp-harden.png', __FILE__ ),
					'parameters' => array(
						array(
							'type' => 'audit_processing',
						
						),
						
					)
				)
			);
		}
	}else{
		$config_big = 
		array(

			array(
				'type' => 'menu',
				//'type' => 'submenu',
				//'parent_slug' => 'edit.php?post_type=cross_seo',
				'page_title' => __('WP Hardening', 'whp'),
				'menu_title' => __('WP Hardening', 'whp'),
				'capability' => 'manage_options',
				'menu_slug' => 'wp_harden',
				'icon' => plugins_url('/images/wp-harden.png', __FILE__ ),
				'parameters' => array(
					array(
						'type' => 'audit_processing',
					
					),
					
				)
			)
		);
	}
	
	global $settings;

	$settings = new whpSettingsClassHarden( 'wph' );
	$settings->create_menu(  $config_big   );


	$config_big = 
	array(

		array(
		
			'type' => 'submenu',
			'parent_slug' => 'wphwp_harden',
			'page_title' => __('Hardening Audit', 'whp'),
			'menu_title' => __('Hardening Audit', 'whp'),
			'capability' => 'manage_options',
			'menu_slug' => 'wp_harden',

			'parameters' => array(
				 
				 
			)
		)
	); 
	$settings = new whpSettingsClassHarden( 'wph' );
	$settings->create_menu(  $config_big   );

	$config_big = 
	array(

		array(
		
			'type' => 'submenu',
			'parent_slug' => 'wphwp_harden',
			'page_title' => __('Security Fixers', 'whp'),
			'menu_title' => __('Security Fixers', 'whp'),
			'capability' => 'manage_options',
			'menu_slug' => 'wp_harden_fixers',

			'parameters' => array(
				array(
					'type' => 'security_fixers',
	 
				),
		  
				 
			)
		)
	); 
	$settings = new whpSettingsClassHarden( 'wph' );
	$settings->create_menu(  $config_big   );

 
	$config_big = 
	array(

		array(
		
			'type' => 'submenu',
			'parent_slug' => 'wphwp_harden',
			'page_title' => __('Help', 'whp'),
			'menu_title' => __('Help', 'whp'),
			'capability' => 'manage_options',
			'menu_slug' => 'wp_harden_help',

			'parameters' => array(
				array(
					'type' => 'select',
					'title' => 'Taxonomy 1',
					'name' => 'taxonomy_picking_1',
					'value' => array( '1' => 'One' )
				),
		  
				 
			)
		)
	); 
	$settings = new whpSettingsClassHarden( 'wph' );
	$settings->create_menu(  $config_big   );

	$config_big = 
	array(

		array(
		
			'type' => 'submenu',
			'parent_slug' => 'wphwp_harden',
			'page_title' => __('Upgrade to Firewall', 'whp'),
			'menu_title' => __('Upgrade to Firewall', 'whp'),
			'capability' => 'manage_options',
			'menu_slug' => 'wp_harden_upgrade',
			

			'parameters' => array(
				array(
					'type' => 'select',
					'title' => 'Taxonomy 1',
					'name' => 'taxonomy_picking_1',
					'value' => array( '1' => 'One' )
				),
		  
				 
			)
		)
	); 
	$settings = new whpSettingsClassHarden( 'wph' );
	$settings->create_menu(  $config_big   );

} );
	
 

?>