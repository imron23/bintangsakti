<?php
/**
 * @author : Jegtheme
 */

namespace JNews;

use JNews\Customizer\CustomizeSetting;
use JNews\Widget\EditWidgetArea;

class Importer {

	/**
	 * @var string
	 *
	 * Backup content
	 */
	public static $backup_option = 'jnews_import_backup';

	/**
	 * @var string
	 *
	 * importer option
	 * content : import_content (news | sport | etc), style : ( news | sport | etc )
	 */
	public static $option         = 'jnews_import';
	public static $option_content = 'jnews_import_content';
	public static $option_style   = 'jnews_import_style';

	/**
	 * @var string
	 */
	public static $default_path = 'data/import/';

	/**
	 * @var string
	 *
	 * Path where import content lies
	 */
	private $import_path;

	/**
	 * @var string
	 *
	 * absolute path for import content
	 */
	private $import_url;

	/**
	 * @var string
	 *
	 * demo type
	 */
	private $demo_type;

	/**
	 * @var array
	 *
	 * file that contain array of item
	 */
	private $content = array();

	/**
	 * @var boolean
	 *
	 * Flag to detect local demo. false by default.
	 */
	private $local_demo = false;

	/**
	 * @var array
	 *
	 * array of imported image
	 */
	private $image = array();

	/**
	 * @var array
	 *
	 * array of imported taxonomy
	 */
	private $taxonomy = array();

	/**
	 * @var array
	 *
	 * array of imported taxonomy image
	 */
	private $taxonomy_image = array();

	/**
	 * @var array
	 *
	 * array of imported post
	 */
	private $post = array();

	/**
	 * @var array
	 *
	 * array of imported menu location
	 */
	private $menu_location = array();

	/**
	 * @var array
	 *
	 * array of widget position
	 */
	private $widget_position = array();

	/**
	 * @var array
	 *
	 * array of imported menu
	 */
	private $menu = array();

	/**
	 * @param $demo
	 */
	public function __construct( $demo ) {
		$this->demo_type   = $demo;
		$path              = self::$default_path . $demo;
		$this->import_path = JNEWS_THEME_DIR . $path;
		$this->import_url  = JNEWS_THEME_URL . '/' . $path;
		if ( file_exists( $this->import_path . '/content.php' ) ) {
			$this->local_demo = true;
			$this->content    = include $this->import_path . '/content.php';
			$this->extract_option();
		}
	}

	/**
	 * @return booelan
	 */
	public function is_local_demo() {
		return $this->local_demo;
	}

	/**
	 * @return boolean
	 */
	public function is_content_empty() {
		return empty( $this->content );
	}

	/**
	 * @param array $content
	 */
	public function set_content( $content ) {
		$this->content = $content;
		$this->extract_option();
	}

	/**
	 * Temporary support webp.
	 *
	 * @param $mime_types
	 *
	 * @return mixed
	 */
	public function support_webp_mime_type( $mime_types ) {
		$mime_types['webp'] = 'image/webp';

		return $mime_types;
	}

	public function extract_option() {
		$option = get_option( self::$option_content );

		if ( isset( $option['image'] ) ) {
			$this->image = $option['image'];
		}

		if ( isset( $option['taxonomy'] ) ) {
			$this->taxonomy = $option['taxonomy'];
		}

		if ( isset( $option['post'] ) ) {
			$this->post = $option['post'];
		}

		if ( isset( $option['menu_location'] ) ) {
			$this->menu_location = $option['menu_location'];
		}

		if ( isset( $option['menu'] ) ) {
			$this->menu = $option['menu'];
		}
	}

	/**
	 * @return array
	 */
	public function get_image_index() {
		return array_keys( $this->content['image'] );
	}

	/**
	 * @return array
	 */
	public function get_post_index() {
		return array_keys( $this->content['post'] );
	}

	/**
	 * @return array
	 */
	public function get_plugin_index() {
		return $this->content['plugin'];
	}

	/**
	 * do actual import process
	 *
	 * @param $import_part
	 */
	public function do_import( $import_part ) {
		// no timeout
		set_time_limit( 0 );

		foreach ( $this->content as $part => $content ) {
			if ( 'image' === $part && 'image' === $import_part ) {
				$this->do_import_image( $content );
				$this->save_option( 'image', $this->image );
			}

			if ( 'taxonomy' === $part && 'taxonomy' === $import_part ) {
				$this->do_import_taxonomy( $content );
				$this->save_option( 'taxonomy', $this->taxonomy );
				$this->save_option( 'taxonomy_image', $this->taxonomy_image );
			}

			if ( ! empty( $this->taxonomy_image ) ) {
				$this->do_import_taxonomy_image( $this->taxonomy_image );
			}

			if ( 'post' === $part && 'post' === $import_part ) {
				$this->do_import_post( $content );
				$this->save_option( 'post', $this->post );
			}

			if ( 'menu_location' === $part && 'menu_location' === $import_part ) {
				$this->do_import_menu_location( $content );
				$this->save_option( 'menu_location', $this->menu_location );
			}

			if ( 'menu' === $part && 'menu' === $import_part ) {
				$this->do_import_menu( $content );
				$this->save_option( 'menu', $this->menu );
			}

			if ( 'widget_position' === $part && 'widget' === $import_part ) {
				$this->do_import_widget_location( $content );
				$this->save_option( 'widget_position', $this->widget_position );
			}

			if ( 'widget' === $part && 'widget' === $import_part ) {
				$this->do_import_widget( $content );
			}

			if ( 'customizer' === $part && 'customizer' === $import_part ) {
				$this->do_import_style( $content );
			}

			if ( 'elementor_setting' === $part && 'elementor_setting' === $import_part ) {
				$this->do_import_elementor_setting( $content );
			}
		}
	}

	/**
	 * @param $content
	 *
	 * Handle Import Image
	 */
	public function do_import_image( $content ) {
		add_filter( 'upload_mimes', array( $this, 'support_webp_mime_type' ) );
		foreach ( $content as $key => $image ) {
			$result = $this->handle_file( $image );
			if ( $result ) {
				$this->image[ $key ] = $result;
			}
		}
		remove_filter( 'upload_mimes', array( $this, 'support_webp_mime_type' ) );
	}

	/**
	 * @param $url
	 *
	 * @return int|null
	 *
	 * Handle Import file, and return File ID when process complete
	 */
	public function handle_file( $url ) {
		$file_name = basename( $url );
		$upload    = wp_upload_bits( $file_name, 0, '' );
		$this->fetch_file( $url, $upload['file'] );

		if ( $upload['file'] ) {
			$file_loc  = $upload['file'];
			$file_name = basename( $upload['file'] );
			$file_type = wp_check_filetype( $file_name );

			$attachment = array(
				'post_mime_type' => $file_type['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			);

			$attach_id   = wp_insert_attachment( $attachment, $file_loc );
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file_loc );
			wp_update_attachment_metadata( $attach_id, $attach_data );

			return $attach_id;
		} else {
			return null;
		}
	}

	/**
	 * @param $url
	 * @param $file_path
	 *
	 * @return array|bool
	 *
	 * Download file and save to file system
	 */
	public function fetch_file( $url, $file_path ) {
		$http     = new \WP_Http();
		$response = $http->get( $url );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$headers             = wp_remote_retrieve_headers( $response );
		$headers['response'] = wp_remote_retrieve_response_code( $response );

		if ( false == $file_path ) {
			return $headers;
		}

		// GET request - write it to the supplied filename
		WP_Filesystem();
		global $wp_filesystem;
		$wp_filesystem->put_contents( $file_path, wp_remote_retrieve_body( $response ), FS_CHMOD_FILE );

		return $headers;
	}

	/**
	 * Save content to databases
	 *
	 * @param $type
	 * @param $content
	 */
	public function save_option( $type, $content ) {
		$option_name     = self::$option_content;
		$option          = get_option( $option_name );
		$option[ $type ] = $content;

		update_option( $option_name, $option );
	}

	/**
	 * @param $content
	 *
	 * import taxonomy
	 */
	public function do_import_taxonomy( $content ) {
		foreach ( $content as $taxonomy => $items ) {
			$this->taxonomy[ $taxonomy ]       = array();
			$this->taxonomy_image[ $taxonomy ] = array();

			foreach ( $items as $slug => $tax ) {
				$currentterm = get_term_by( 'slug', $slug, $taxonomy );

				if ( ! $currentterm ) {
					$tax_args = array(
						'slug' => $slug,
					);

					if ( isset( $tax['parent'] ) ) {
						$tax_args['parent'] = $this->taxonomy[ $taxonomy ][ $tax['parent'] ];
					}
					if ( isset( $tax['description'] ) ) {
						$tax_args['description'] = $tax['description'];
					}

					$term = wp_insert_term( $tax['title'], $taxonomy, $tax_args );

					if ( $term instanceof \WP_Error ) {
						$this->taxonomy[ $taxonomy ][ $slug ] = $term->error_data['term_exists'];
					} else {
						$this->taxonomy[ $taxonomy ][ $slug ] = $term['term_id'];
					}
				} else {
					$this->taxonomy[ $taxonomy ][ $slug ] = $currentterm->term_id;
				}
				if ( isset( $tax['term_image'] ) ) {
					$this->taxonomy_image[ $taxonomy ][ $this->taxonomy[ $taxonomy ][ $slug ] ] = $this->text_filter( $tax['term_image'] );
				}
			}
		}
	}

	/**
	 * @param $text
	 *
	 * @return string
	 *
	 * Replace text with defined content
	 */
	public function text_filter( $text ) {
		$result = preg_replace_callback( '/(\{{.*?\}})/', array( $this, 'trim_convert_tag' ), $text );

		return $result;
	}

	/**
	 * import taxonomy image
	 *
	 * @param $taxonomies_image
	 */
	public function do_import_taxonomy_image( $taxonomies_image ) {

		foreach ( $taxonomies_image as $taxonomy => $values ) {
			foreach ( $values as $taxonomy_id => $image_id ) {
				$this->save_taxonomy_image( 'jnews_' . $taxonomy . '_term_image', $taxonomy_id, $this->text_filter( $image_id ), null );
			}
		}
	}

	/**
	 * Save taxonomy image to databases
	 *
	 * @param $taxonomy_image_option
	 * @param $taxonomy_id
	 * @param $image_id
	 * @param $value
	 */
	public function save_taxonomy_image( $taxonomy_image_option, $taxonomy_id, $image_id, $value ) {
		$option_name = $taxonomy_image_option;
		if ( ! isset( $value ) ) {
			$option                 = get_option( $option_name );
			$option[ $taxonomy_id ] = $image_id;
		} else {
			$option = $value;
		}

		update_option( $option_name, $option );
	}

	/**
	 * @param $content
	 *
	 * import content
	 */
	public function do_import_post( $content ) {
		$index = 0;

		foreach ( $content as $slug => $item ) {
			$this->post[ $slug ] = $this->import_post( $slug, $item, $index ++ );
		}
	}

	public function import_post( $slug, $item, $index = 0, $builder = 'vc' ) {
		$check_post = get_page_by_title( $item['title'], null, $item['post_type'] );

		$post_date = $this->post_date( $slug );

		$post_array = array(
			'post_title'    => wp_kses(
				$item['title'],
				array(
					'em'     => array(),
					'strong' => array(),
				)
			),
			'post_name'     => $slug,
			'post_type'     => $item['post_type'],
			'post_status'   => 'publish',
			'post_date'     => $post_date,
			'post_date_gmt' => $post_date,
		);

		if ( isset( $item['parent'] ) ) {
			$post_array['post_parent'] = $this->text_filter( $item['parent'] );
		}

		if ( ( 'footer' === $item['post_type'] || 'page' === $item['post_type'] ) && 'default' != ( isset( $item['metabox']['_wp_page_template'] ) && $item['metabox']['_wp_page_template'] ) ) {
			if ( 'elementor' == $builder ) {
				unset( $item['metabox']['_elementor_page_settings'] );
				unset( $item['metabox']['_elementor_edit_mode'] );
				unset( $item['metabox']['_elementor_data'] );

				$post_array['post_content'] = $this->compile_content( $item['content'] );
			} else {

				unset( $item['metabox']['_wpb_shortcodes_custom_css'] );
				unset( $item['metabox']['_wpb_post_custom_css'] );

				unset( $post_array['post_content'] );
			}
		} else {
			if ( $this->is_post_content_json( $item['content'] ) ) {
				$post_data                           = $this->compile_post_content_json( $item['content'] );
				$post_array['post_content']          = $post_data['post_content'];
				$post_array['post_content_filtered'] = $post_data['post_content_filtered'];
			} else {
				$post_array['post_content'] = $this->compile_content( $item['content'] );
			}
		}

		// insert or update post
		if ( ! $check_post ) {
			$post_id = wp_insert_post( $post_array );
		} else {
			$post_id = $check_post->ID;
			wp_update_post( $post_array );
		}

		// set post featured image
		if ( isset( $item['featured_image'] ) ) {
			set_post_thumbnail( $post_id, $this->image[ $item['featured_image'] ] );
		}

		// set taxonomy
		if ( isset( $item['taxonomy'] ) && ! empty( $item['taxonomy'] ) ) {
			foreach ( $item['taxonomy'] as $taxonomy => $taxstring ) {
				$tax_array = array();
				$taxs      = explode( ',', $taxstring );

				if ( sizeof( $taxs ) > 1 ) {
					$taxs = array_map( 'trim', explode( ',', $taxstring ) );

					foreach ( $taxs as $tax ) {
						$tax_array[] = $this->taxonomy[ $taxonomy ][ $tax ];
					}

					wp_set_object_terms( $post_id, $tax_array, $taxonomy );

				} else {

					wp_set_object_terms( $post_id, $taxstring, $taxonomy );

				}
			}
		}

		// set metabox
		if ( isset( $item['metabox'] ) && ! empty( $item['metabox'] ) ) {
			$this->update_metabox( $post_id, $item['metabox'] );
		}

		return $post_id;
	}

	/**
	 * @param  $slug
	 *
	 * @return string
	 *
	 * post date
	 */
	public function post_date( $slug ) {
		$index = 0;
		foreach ( $this->content['post'] as $key => $post ) {
			if ( $slug === $key ) {
				break;
			}
			$index ++;
		}

		$now       = strtotime( '-1 months' );
		$interval  = $index * DAY_IN_SECONDS;
		$post_date = gmdate( 'Y-m-d H:i:s', ( $now - $interval ) );

		return $post_date;
	}

	/**
	 * Detect if post content is JSON
	 *
	 * @param string $file File name.
	 *
	 * @return boolean
	 */
	public function is_post_content_json( $file ) {
		$path_info = pathinfo( $file );
		$ext       = $path_info['extension'];
		if ( 'json' === $ext ) {
			return true;
		}
		return false;
	}

	/**
	 * Compile post content JSON
	 *
	 * @param string $file File name.
	 *
	 * @return array
	 */
	public function compile_post_content_json( $file ) {
		$data                          = $this->load_file_content( $this->import_path . '/post/' . $file );
		$data                          = json_decode( $data, true );
		$data                          = wp_parse_args(
			$data[0] ? $data[0] : array(),
			array(
				'post_content'          => '',
				'post_content_filtered' => '',
			)
		);
		$data['post_content']          = $this->text_filter( $data['post_content'] );
		$data['post_content_filtered'] = $this->text_filter( $data['post_content_filtered'] );
		return $data;
	}

	/**
	 * @param $file
	 *
	 * @return string
	 *
	 * print file with content
	 */
	public function compile_content( $file ) {
		$text = $this->load_file_content( $this->import_path . '/post/' . $file );

		return $this->text_filter( $text );
	}

	/**
	 * @param $filepath
	 *
	 * @return string
	 *
	 * load file in this path, and return text that contain inside the file it self
	 */
	public function load_file_content( $filepath ) {
		ob_start();
		include $filepath;
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function update_metabox( $post_id, $metabox ) {
		foreach ( $metabox as $metakey => $metavalue ) {
			$metavalue = $this->recursive_filter_text( $metavalue );

			if ( '_elementor_data' === $metakey && ! empty( $metavalue ) ) {
				$metavalue = $this->compile_content( $metavalue );
			}

			update_post_meta( $post_id, $metakey, $metavalue );
		}
	}

	public function recursive_filter_text( $contents ) {
		if ( is_array( $contents ) ) {
			foreach ( $contents as $key => $value ) {
				$contents[ $key ] = $this->recursive_filter_text( $value );
			}
		} else {
			return $this->text_filter( $contents );
		}

		return $contents;
	}

	/**
	 * @param $content
	 *
	 * import menu location
	 */
	public function do_import_menu_location( $content ) {
		foreach ( $content as $key => $menu ) {
			$menu_exists = wp_get_nav_menu_object( $menu['title'] );

			if ( $menu_exists ) {
				wp_delete_nav_menu( $menu['title'] );
			}

			// create menu
			$this->menu_location[ $key ] = wp_create_nav_menu( $menu['title'] );

			// assign menu to location
			if ( isset( $menu['location'] ) ) {
				$location                      = get_theme_mod( 'nav_menu_locations' );
				$location[ $menu['location'] ] = $this->menu_location[ $key ];
				set_theme_mod( 'nav_menu_locations', $location );
			}
		}
	}

	/**
	 * @param $content
	 *
	 * import menu
	 */
	public function do_import_menu( $content ) {
		foreach ( $content as $key => $menu ) {
			// convert every tag on menu item data
			foreach ( $menu['menu-item-data'] as $item_key => $data ) {
				$menu['menu-item-data'][ $item_key ] = $this->text_filter( $data );
			}

			$this->menu[ $key ] = wp_update_nav_menu_item( $this->menu_location[ $menu['location'] ], 0, $menu['menu-item-data'] );

			// set metabox
			if ( isset( $menu['metabox'] ) && ! empty( $menu['metabox'] ) ) {
				$this->update_metabox( $this->menu[ $key ], $menu['metabox'] );
			}
		}
	}

	/**
	 * @param $content
	 *
	 * import location
	 */
	public function do_import_widget_location( $content ) {
		$this->widget_position = $content;

		$current_location = get_option( EditWidgetArea::$widget_list );

		if ( is_array( $current_location ) ) {
			$new_location = array_merge( $current_location, $content );
		} else {
			$new_location = $content;
		}

		foreach ( $new_location as $widget ) {
			register_sidebar(
				array(
					'id'            => sanitize_title( $widget ),
					'name'          => $widget,
					'before_widget' => '<div class="widget %2$s" id="%1$s">',
					'before_title'  => '',
					'after_title'   => '',
					'after_widget'  => '</div>',
				)
			);
		}

		update_option( EditWidgetArea::$widget_list, $new_location );
	}

	/**
	 * @param $content
	 *
	 * import widget
	 */
	public function do_import_widget( $content ) {
		$this->reset_widget_content();

		foreach ( $content as $file ) {
			$import = $this->load_file_content( $this->import_path . '/' . $file );
			$import = $this->text_filter( $import );
			$import = json_decode( $import );

			$this->import_widget( $import );
		}
	}

	/**
	 * Empty widget content
	 */
	public function reset_widget_content() {
		$sidebarOptions = get_option( 'sidebars_widgets' );

		foreach ( $sidebarOptions as $sidebar_name => $sidebar_value ) {
			if ( is_array( $sidebar_value ) ) {
				unset( $sidebarOptions[ $sidebar_name ] );
				$sidebarOptions[ $sidebar_name ] = array();
			}
		}

		update_option( 'sidebars_widgets', $sidebarOptions );
	}

	/**
	 * @param $data
	 *
	 * do actual widget import
	 */
	public function import_widget( $data ) {
		// available widget
		global $wp_registered_sidebars;
		$available_widgets = $this->available_widgets();

		$widget_instances = array();
		foreach ( $available_widgets as $widget_data ) {
			$widget_instances[ $widget_data['id_base'] ] = get_option( 'widget_' . $widget_data['id_base'] );
		}

		foreach ( $data as $sidebar_id => $widgets ) {

			// Skip inactive widgets (should not be in export file)
			if ( 'wp_inactive_widgets' == $sidebar_id ) {
				continue;
			}

			// Check if sidebar is available on this site
			// Otherwise add widgets to inactive, and say so
			if ( isset( $wp_registered_sidebars[ $sidebar_id ] ) ) {
				$use_sidebar_id = $sidebar_id;
			} else {
				$use_sidebar_id = 'wp_inactive_widgets';
			}

			// Result for sidebar
			$results[ $sidebar_id ]['name']    = ! empty( $wp_registered_sidebars[ $sidebar_id ]['name'] ) ? $wp_registered_sidebars[ $sidebar_id ]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
			$results[ $sidebar_id ]['widgets'] = array();

			// Loop widgets
			foreach ( $widgets as $widget_instance_id => $widget ) {

				$fail = false;

				// Get id_base (remove -# from end) and instance ID number
				$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );

				// Does site support this widget?
				if ( ! $fail && ! isset( $available_widgets[ $id_base ] ) ) {
					$fail = true;
				}

				// Convert multidimensional objects to multidimensional arrays
				$widget = json_decode( json_encode( $widget ), true );

				// convert all tag on widget content
				foreach ( $widget as $key => $value ) {
					$widget[ $key ] = $this->text_filter( $value );
				}

				// Does widget with identical settings already exist in same sidebar?
				if ( ! $fail && isset( $widget_instances[ $id_base ] ) ) {

					// Get existing widgets in this sidebar
					$sidebars_widgets = get_option( 'sidebars_widgets' );
					$sidebar_widgets  = isset( $sidebars_widgets[ $use_sidebar_id ] ) ? $sidebars_widgets[ $use_sidebar_id ] : array(); // check Inactive if that's where will go

					// Loop widgets with ID base
					$single_widget_instances = ! empty( $widget_instances[ $id_base ] ) ? $widget_instances[ $id_base ] : array();
					foreach ( $single_widget_instances as $check_id => $check_widget ) {
						// Is widget in same sidebar and has identical settings?
						if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {
							$fail = true;
							break;
						}
					}
				}

				// No failure
				if ( ! $fail ) {
					// Add widget instance
					$single_widget_instances   = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
					$single_widget_instances   = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
					$single_widget_instances[] = $widget; // add it

					// Get the key it was given
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );

					// If key is 0, make it 1
					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number                             = 1;
						$single_widget_instances[ $new_instance_id_number ] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}

					// Move _multiwidget to end of array for uniformity
					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}

					// Update option with new widget
					update_option( 'widget_' . $id_base, $single_widget_instances );

					// Assign widget instance to sidebar
					$sidebars_widgets                      = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
					$new_instance_id                       = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
					$sidebars_widgets[ $use_sidebar_id ][] = $new_instance_id; // add new instance to sidebar
					update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data
				}
			}
		}
	}

	/**
	 * @return array
	 *
	 * return all available registred widget
	 */
	public function available_widgets() {
		global $wp_registered_widget_controls;
		$widget_controls   = $wp_registered_widget_controls;
		$available_widgets = array();

		foreach ( $widget_controls as $widget ) {
			if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[ $widget['id_base'] ] ) ) {
				$available_widgets[ $widget['id_base'] ]['id_base'] = $widget['id_base'];
				$available_widgets[ $widget['id_base'] ]['name']    = $widget['name'];
			}
		}

		return $available_widgets;
	}

	/**
	 * @param $content
	 *
	 * import menu
	 */
	public function do_import_style( $content ) {
		foreach ( $content as $file ) {
			$data = $this->load_file_content( $this->import_path . '/' . $file );
			$data = $this->text_filter( $data );
			$data = json_decode( $data, true );
			// array_walk_recursive($data, array(&$this, 'array_convert'));

			// execute
			$this->import_theme_mod( $data );
		}
	}

	/**
	 * @param $content
	 *
	 * import menu
	 */
	public function do_import_elementor_setting( $content ) {
		foreach ( $content as $file ) {
			$data = $this->load_file_content( $this->import_path . '/' . $file );
			$data = $this->text_filter( $data );
			$data = json_decode( $data, true );
			// array_walk_recursive($data, array(&$this, 'array_convert'));

			// execute
			$this->import_elementor_setting( $data );
		}
	}

	/**
	 * @param $data
	 *
	 * do real style import
	 */
	public function import_elementor_setting( $data ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			if ( \Elementor\Plugin::instance()->kits_manager ) {
				$kit = \Elementor\Plugin::instance()->kits_manager->get_active_kit();

				$old_settings = $kit->get_meta( '_elementor_page_settings' );

				if ( ! $old_settings ) {
					$old_settings = array();
				}

				$new_settings = $data;

				$new_settings = $new_settings['settings'];

				if ( $old_settings ) {
					$new_settings['custom_colors'] = array_merge( $old_settings['custom_colors'], $new_settings['custom_colors'] );

					$new_settings['custom_typography'] = array_merge( $old_settings['custom_typography'], $new_settings['custom_typography'] );
				}

				$new_settings = array_replace_recursive( $old_settings, $new_settings );

				$kit->save( array( 'settings' => $new_settings ) );
			}
		}
	}

	/**
	 * @param $data
	 *
	 * do real style import
	 */
	public function import_theme_mod( $data ) {
		global $wp_customize;

		if ( isset( $data['options'] ) ) {
			foreach ( $data['options'] as $option_key => $option_value ) {
				$option = new CustomizeSetting(
					$wp_customize,
					$option_key,
					array(
						'default'    => '',
						'type'       => 'option',
						'capability' => 'edit_theme_options',
					)
				);

				$option->import( $option_value );
			}
		}

		// Call the customize_save action.
		do_action( 'customize_save', $wp_customize );

		if ( isset( $data['mods'] ) && ! empty( $data['mods'] ) ) {
			// Loop through the mods.
			foreach ( $data['mods'] as $key => $val ) {

				// Call the customize_save_ dynamic action.
				do_action( 'customize_save_' . $key, $wp_customize );

				// Save the mod.
				set_theme_mod( $key, $val );
			}
		}

		// Call the customize_save_after action.
		do_action( 'customize_save_after', $wp_customize );

		if ( isset( $data['wp_css'] ) ) {
			wp_update_custom_css_post( $data['wp_css'], array() );
		}
	}

	public function do_import_single( $part, $key, $builder ) {
		if ( 'image' === $part ) {
			$id = $this->do_import_image_single( $key );
			$this->save_single_option( 'image', $key, $id );
		}

		if ( 'post' === $part ) {
			$id = $this->do_import_post_single( $key, $builder );
			$this->save_single_option( 'post', $key, $id );
		}
	}

	public function do_import_image_single( $key ) {
		$images = $this->content['image'];

		return $this->handle_file( $images[ $key ] );
	}

	public function save_single_option( $type, $key, $id ) {
		$option          = get_option( self::$option_content );
		$content         = isset( $option[ $type ] ) ? $option[ $type ] : array();
		$content[ $key ] = $id;

		$this->save_option( $type, $content );
	}

	public function do_import_post_single( $key, $builder ) {
		$posts = $this->content['post'];

		return $this->import_post( $key, $posts[ $key ], 0, $builder );
	}

	/**
	 * do uninstall process
	 */
	public function do_uninstall_content() {
		// hapus timeout
		set_time_limit( 0 );

		$option_content = self::$option_content;
		$option         = get_option( $option_content );

		// do all uninstall process
		$this->reset_widget_content();

		if ( isset( $option['menu'] ) ) {
			$this->uninstall_menu( $option['menu'] );
		}
		if ( isset( $option['menu_location'] ) ) {
			$this->uninstall_menu_location( $option['menu_location'] );
		}
		if ( isset( $option['widget_position'] ) ) {
			$this->uninstall_widget_position( $option['widget_position'] );
		}
		if ( isset( $option['post'] ) ) {
			$this->uninstall_post( $option['post'] );
		}
		if ( isset( $option['taxonomy'] ) ) {
			$this->uninstall_taxonomy( $option['taxonomy'] );
		}
		if ( isset( $option['taxonomy_image'] ) ) {
			$this->uninstall_taxonomy_image( $option['taxonomy_image'] );
		}
		if ( isset( $option['image'] ) ) {
			$this->uninstall_image( $option['image'] );
		}

		// delete option when
		delete_option( $option_content );
	}

	/**
	 * uninstall menu
	 *
	 * @param $menus
	 */
	public function uninstall_menu( $menus ) {
		foreach ( $menus as $menu ) {
			wp_delete_post( $menu, true );
		}
	}

	/**
	 * Uninstall menu location
	 *
	 * @param $menu_location
	 */
	public function uninstall_menu_location( $menu_location ) {
		foreach ( $menu_location as $location ) {
			wp_delete_term( $location, 'nav_menu' );
		}
	}

	public function uninstall_widget_position( $widget_position ) {
		$widget_list = get_option( EditWidgetArea::$widget_list );

		foreach ( $widget_list as $key => $widget ) {
			if ( in_array( $widget, $widget_position ) ) {
				unset( $widget_list[ $key ] );
			}
		}

		update_option( EditWidgetArea::$widget_list, $widget_list );
	}

	/**
	 * uninstall post
	 *
	 * @param $posts
	 */
	public function uninstall_post( $posts ) {
		foreach ( $posts as $post ) {
			wp_delete_post( $post, true );
		}
	}

	/**
	 * uninstall taxonomy
	 *
	 * @param $taxonomies
	 */
	public function uninstall_taxonomy( $taxonomies ) {
		foreach ( $taxonomies as $taxonomy => $values ) {
			foreach ( $values as $key => $value ) {
				wp_delete_term( $value, $taxonomy );
			}
		}
	}

	/**
	 * uninstall taxonomy image
	 *
	 * @param $taxonomies_image
	 */
	public function uninstall_taxonomy_image( $taxonomies_image ) {
		foreach ( $taxonomies_image as $taxonomy => $values ) {
			$option_name         = 'jnews_' . $taxonomy . '_term_image';
			$taxonomy_image_list = get_option( $option_name );
			if ( ! empty( $taxonomy_image_list ) ) {
				foreach ( $taxonomy_image_list as $taxonomy_id => $image_id ) {
					if ( array_key_exists( $taxonomy_id, $values ) ) {
						unset( $taxonomy_image_list[ $taxonomy_id ] );
					}
				}
				$this->save_taxonomy_image( $option_name, null, null, $taxonomy_image_list );
			}
			if ( empty( $taxonomy_image_list ) ) {
				delete_option( $option_name );
			}
		}
	}

	/**
	 * uninstall image
	 *
	 * @param $images
	 */
	public function uninstall_image( $images ) {
		foreach ( $images as $image ) {
			wp_delete_attachment( $image, true );
		}
	}

	public function do_uninstall_single( $key ) {
		$option_name = self::$option_content;
		$option      = get_option( $option_name );

		switch ( $key ) {
			case 'style':
				$this->uninstall_style();
				break;
			case 'widget':
				$this->reset_widget_content();
				if ( isset( $option['widget_position'] ) ) {
					$this->uninstall_widget_position( $option['widget_position'] );
				}
				break;
			case 'menu':
				if ( isset( $option['menu'] ) ) {
					$this->uninstall_menu( $option['menu'] );
				}
				if ( isset( $option['menu_location'] ) ) {
					$this->uninstall_menu_location( $option['menu_location'] );
				}
				break;
			case 'post':
				if ( isset( $option['post'] ) ) {
					$this->uninstall_post( $option['post'] );
				}
				break;
			case 'taxonomy':
				if ( isset( $option['taxonomy'] ) ) {
					$this->uninstall_taxonomy( $option['taxonomy'] );
				}
				if ( isset( $option['taxonomy_image'] ) ) {
					$this->uninstall_taxonomy_image( $option['taxonomy_image'] );
				}
				break;
			case 'image':
				if ( isset( $option['image'] ) ) {
					$this->uninstall_image( $option['image'] );
				}
				break;
			case 'finish':
				delete_option( $option_name );
				delete_option( self::$option );
				break;
		}
	}

	/**
	 * uninstall theme mod
	 */
	public function uninstall_style() {
		delete_option( 'theme_mods_jnews' );
	}

	/**
	 * Backup Content
	 */
	public function do_backup() {
		$backup = array();

		// backup widget
		$backup['widget'] = $this->export_widget();

		// backup style
		$backup['customizer'] = $this->export_style();

		// backup elementor settings
		$backup['elementor_setting'] = $this->export_elementor_setting();
		if ( empty( $backup['elementor_setting'] ) ) {
			unset( $backup['elementor_setting'] );
		}

		// save option
		update_option( self::$backup_option, $backup );
	}

	/**
	 * Export Widget
	 *
	 * @return array
	 */
	public function export_widget() {
		$available_widgets = $this->available_widgets();

		$widget_instances = array();
		foreach ( $available_widgets as $widget_data ) {
			$instances = get_option( 'widget_' . $widget_data['id_base'] );

			if ( ! empty( $instances ) ) {
				foreach ( $instances as $instance_id => $instance_data ) {
					if ( is_numeric( $instance_id ) ) {
						$unique_instance_id                      = $widget_data['id_base'] . '-' . $instance_id;
						$widget_instances[ $unique_instance_id ] = $instance_data;
					}
				}
			}
		}

		$sidebars_widgets          = get_option( 'sidebars_widgets' );
		$sidebars_widget_instances = array();

		foreach ( $sidebars_widgets as $sidebar_id => $widget_ids ) {

			if ( 'wp_inactive_widgets' == $sidebar_id ) {
				continue;
			}

			if ( ! is_array( $widget_ids ) || empty( $widget_ids ) ) {
				continue;
			}

			foreach ( $widget_ids as $widget_id ) {
				if ( isset( $widget_instances[ $widget_id ] ) ) {
					$sidebars_widget_instances[ $sidebar_id ][ $widget_id ] = $widget_instances[ $widget_id ];
				}
			}
		}

		return $sidebars_widget_instances;
	}

	/**
	 * Export Style
	 *
	 * @return array
	 */
	public function export_style() {
		return array(
			'template' => get_template(),
			'mods'     => get_theme_mods(),
		);
	}

	/**
	 * Export Elementor Setting
	 *
	 * @return array
	 */
	public function export_elementor_setting() {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			if ( \Elementor\Plugin::instance()->kits_manager ) {
				return \Elementor\Plugin::instance()->kits_manager->get_active_kit()->get_export_data();
			}
		}
		return array();
	}

	/**
	 * Restore backup content
	 */
	public function do_restore() {
		$option = get_option( self::$backup_option );

		// restore widget
		$this->import_widget( $option['widget'] );

		// restore style
		$this->import_theme_mod( $option['customizer'] );

		// restore elementor setting
		if ( isset( $option['elementor_setting'] ) ) {
			$this->import_elementor_setting( $option['elementor_setting'] );
		}
	}

	public function save_import_option( $type, $value ) {
		$option          = get_option( self::$option );
		$option[ $type ] = $value;

		update_option( self::$option, $option );
	}

	public function delete_import_option( $type ) {
		$option = get_option( self::$option );
		if ( $option ) {
			$option[ $type ] = false;

			update_option( self::$option, $option );
		}
	}

	public function do_import_style_only() {
		$content   = $this->content['customizer'];
		$theme_mod = get_theme_mods();

		remove_theme_mods();

		foreach ( $content as $file ) {
			$data = $this->load_file_content( $this->import_path . '/' . $file );
			$data = $this->text_filter( $data );
			$data = json_decode( $data, true );

			$data['mods'] = $this->alter_mod_default( $theme_mod, $data['mods'] );
			unset( $data['options'] );

			$this->import_theme_mod( $data );
		}
		if ( isset( $this->content['elementor_setting'] ) ) {
			$this->do_import_elementor_setting( $this->content['elementor_setting'] );
		}
	}

	public function alter_mod_default( $current, $data ) {
		$overwrites = array(
			'nav_menu_locations',
			'jnews_social_icon',
			'jnews_header_logo',
			'jnews_header_logo_retina',
			'jnews_sticky_menu_logo',
			'jnews_sticky_menu_logo_retina',
			'jnews_mobile_logo',
			'jnews_mobile_logo_retina',
			'jnews_background_image',
			'jnews_social_icon',
		);

		foreach ( $overwrites as $option ) {
			$data[ $option ] = isset( $current[ $option ] ) ? $current[ $option ] : null;
		}

		return $data;
	}

	/**
	 * @param $value
	 *
	 * convert every word to converted tag
	 */
	public function array_convert( &$value ) {
		$value = $this->text_filter( $value );
	}

	/**
	 * @param $content
	 *
	 * @return null|string
	 */
	public function trim_convert_tag( $content ) {
		return $this->convert_tag( trim( $content[1], '{}' ) );
	}

	/**
	 * @param $string
	 *
	 * @return null|string
	 *
	 * convert every string with tag to corespondent tag
	 */
	public function convert_tag( $string ) {
		$tag = explode( ':', $string );

		if ( sizeof( $tag ) > 1 ) {
			switch ( $tag[0] ) {
				case 'image':
					$result = $this->image_tag( $tag );
					break;
				case 'category':
					$result = $this->category_tag( $tag );
					break;
				case 'taxonomy':
					$result = $this->taxonomy_tag( $tag );
					break;
				case 'post':
					$result = $this->post_tag( $tag );
					break;
				case 'url':
					$result = $this->url_tag( $tag );
					break;
				case 'menu':
					$result = $this->menu_tag( $tag );
					break;
				case 'menu_location':
					$result = $this->menu_location_tag( $tag );
					break;
				default:
					$result = $string;
					break;
			}
		} else {
			$result = $string;
		}

		return apply_filters( 'jnews_convert_tag', $result, $tag );
	}

	/**
	 * @param $tag
	 *
	 * @return null
	 *
	 * convert image tag
	 * ex:
	 *  1. get ID of image : image:news01:id
	 *  2. get URL of image by size : image:news01:url:thumbnail
	 *  3. Retrieve the URL for an attachment : image:attach:src
	 */
	public function image_tag( $tag ) {
		if ( isset( $this->image[ $tag[1] ] ) ) {
			$image_id = $this->image[ $tag[1] ];
			$to       = $tag[2];

			if ( 'id' === $to ) {
				return $image_id;
			} elseif ( 'url' === $to ) {
				$result = wp_get_attachment_image_src( $image_id, $tag[3] );

				return $result[0];
			} else {
				$result = wp_get_attachment_url( $image_id );

				return $result;
			}
		}

		return null;
	}

	/**
	 * @param $tag
	 *
	 * @return null|string
	 *
	 * convert category tag
	 * ex:
	 *  1. get ID of category : category:first-category-slug:id
	 *  2. get URL of category : category:first-category-slug:url
	 */
	public function category_tag( $tag ) {
		if ( isset( $this->taxonomy['category'] ) && isset( $this->taxonomy['category'][ $tag[1] ] ) ) {
			$category_id = $this->taxonomy['category'][ $tag[1] ];
			$to          = $tag[2];

			if ( 'id' === $to ) {
				return $category_id;
			} elseif ( 'url' === $to ) {
				return get_category_link( $this->taxonomy['category'][ $tag[1] ] );
			}
		}

		return null;
	}

	/**
	 * @param $tag
	 *
	 * @return null|string
	 *
	 * convert taxonomy tag
	 * ex:
	 *  1. get ID of taxonomy : taxonomy:post_tag:first-tag:id
	 *  2. get URL of taxonomy : taxonomy:post_tag:first-tag:url
	 */
	public function taxonomy_tag( $tag ) {
		$taxonomy = $tag[1];

		if ( isset( $this->taxonomy[ $taxonomy ] ) && $this->taxonomy[ $taxonomy ][ $tag[2] ] ) {
			$taxonomy_id = $this->taxonomy[ $taxonomy ][ $tag[2] ];
			$to          = $tag[3];

			if ( 'id' === $to ) {
				return $taxonomy_id;
			} elseif ( 'url' === $to ) {
				return get_term_link( $taxonomy_id . $taxonomy );
			}
		}

		return null;
	}

	/**
	 * @param $tag
	 *
	 * @return null|string
	 *
	 * convert post tag
	 * ex:
	 *  1. get ID of post : post:first-content-slug:id
	 *  2. get URL of post : post:first-content-slug:url
	 */
	public function post_tag( $tag ) {
		if ( isset( $this->post[ $tag[1] ] ) ) {
			$post_id = $this->post[ $tag[1] ];
			$to      = $tag[2];

			if ( 'id' === $to ) {
				return $post_id;
			} elseif ( 'url' === $to ) {
				return get_permalink( $post_id );
			}
		}

		return null;
	}

	/**
	 * @param $tag
	 *
	 * convert url tag
	 * ex:
	 *  1. get home url : url:home
	 *  2. get specific endpoint : url:home:favorite
	 *
	 * @return string|void
	 */
	public function url_tag( $tag ) {
		if ( isset( $tag[1] ) ) {
			$content = $tag[1];
			$to      = isset( $tag[2] ) ? $tag[2] : '';

			switch ( $content ) {
				case 'domain':
					$urlparts = parse_url( home_url( '/' ) );
					$domain   = $urlparts['host'];
					return $domain;
					break;
				case 'home':
					if ( ! empty( $to ) ) {
						return home_url( '/' . $to, 'relative' );
					} else {
						return home_url( '/', 'relative' );
					}
					break;
				case 'email':
					$current_user = wp_get_current_user();
					return $current_user->user_email;
					break;
			}
		}
		return null;
	}

	/**
	 * @param $tag
	 *
	 * @return null|string
	 *
	 * convert menu tag
	 * ex:
	 *  1. get ID of post : menu:first-menu:id
	 */
	public function menu_tag( $tag ) {
		if ( isset( $this->menu[ $tag[1] ] ) ) {
			$menu_id = $this->menu[ $tag[1] ];
			$to      = $tag[2];

			if ( 'id' === $to ) {
				return $menu_id;
			}
		}

		return null;
	}

	/**
	 * @param $tag
	 *
	 * @return null|string
	 *
	 * convert menu location tag
	 * ex:
	 *  1. get ID of post : menu_location:main-navigation:id
	 */
	public function menu_location_tag( $tag ) {
		if ( isset( $this->menu_location[ $tag[1] ] ) ) {
			$menu_id = $this->menu_location[ $tag[1] ];
			$to      = $tag[2];

			if ( 'id' === $to ) {
				return $menu_id;
			}
		}

		return null;
	}
}

