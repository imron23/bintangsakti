<?php
/**
 * @author : Jegtheme
 */

namespace JNews;

use JNews\Template;
use JNews\Ajax\AccountHandler;
use JNews\Ajax\LiveSearch;
use JNews\Ajax\FirstLoadAction;
use JNews\Menu\Menu;
use JNews\Module\ModuleManager;
use JNews\Sidefeed\Sidefeed;
use JNews\Dashboard\SystemDashboard;

/**
 * Class JNews Frontend Ajax
 */
class FrontendAjax {
	/**
	 * @var FrontendAjax
	 */
	private static $instance;

	private $endpoint = 'ajax-request';

	/**
	 * @return FrontendAjax
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * FrontendAjax constructor.
	 */
	private function __construct() {
		add_action( 'wp_head', array( $this, 'frontend_ajax_script' ), 1 );

		add_action( 'wp', array( $this, 'ajax_parse_request' ) );
		add_filter( 'query_vars', array( $this, 'ajax_query_vars' ) );
	}

	public function ajax_query_vars( $vars ) {
		$vars[] = $this->endpoint;
		$vars[] = 'action';

		return $vars;
	}

	public function is_doing_ajax() {
		return true;
	}

	public function ajax_parse_request( $wp ) {
		if ( array_key_exists( $this->endpoint, $wp->query_vars ) ) {
			// need to flag this request is ajax request
			add_filter( 'wp_doing_ajax', array( $this, 'is_doing_ajax' ) );

			$action = $wp->query_vars['action'];

			switch ( $action ) {
				case 'jnews_first_load_action':
					$fragment = new FirstLoadAction();
					$fragment->build_response( (array) $_REQUEST['load_action'] );
					break;
				case 'jnews_newsfeed_load':
					$sidefeed = new Sidefeed();
					$sidefeed->build_response();
					break;
				case 'jnews_ajax_live_search':
					$search = new LiveSearch();
					$search->build_response();
					break;
				case 'jnews_mega_category_1':
					$mega_menu = Menu::getInstance();
					$mega_menu->mega_menu_category_1_article();
					break;
				case 'jnews_mega_category_2':
					$menu_menu = Menu::getInstance();
					$menu_menu->mega_menu_category_2_article();
					break;
				case 'jnews_build_mega_category_1':
					$mega_menu = Menu::getInstance();
					$mega_menu->build_megamenu_category_1_article();
					break;
				case 'jnews_build_mega_category_2':
					$mega_menu = Menu::getInstance();
					$mega_menu->build_megamenu_category_2_article();
					break;
				case 'jnews_refresh_nonce':
					$this->refresh_nonce();
					break;
				case 'jnews_system':
					wp_redirect( jnews_home_url_multilang() );
					exit;
					break;
				case 'login_handler':
				case 'register_handler':
				case 'forget_password_handler':
					$account = AccountHandler::getInstance();
					$account->$action();
					break;
				case 'jnews_ajax_comment':
					// ajax comment
					query_posts(
						array(
							'p'            => (int) sanitize_text_field( $_REQUEST['post_id'] ),
							'post_type'    => sanitize_text_field( $_REQUEST['post_type'] ),
							'withcomments' => 1,
							'feed'         => 1,
						)
					);

					while ( have_posts() ) :
						the_post();
						global $post;
						setup_postdata( $post );
						get_template_part( 'fragment/comments' );
					endwhile;

					wp_reset_query();
					break;
				case 'jnews_ajax_cart_detail':
					if ( function_exists( 'WC' ) ) {
						wp_send_json( jnews_return_translation( 'Cart', 'jnews', 'cart' ) . ' / ' . WC()->cart->get_cart_total() );
					}
					break;
			}

			// Module Ajax
			$module_prefix = ModuleManager::$module_ajax_prefix;
			if ( 0 === strpos( $action, $module_prefix ) ) {
				$module_name = str_replace( $module_prefix, '', $action );
				ModuleManager::getInstance()->module_ajax( $module_name );
			}

			do_action( 'jnews_ajax_' . $action );

			exit;
		}
	}

	public function ajax_url() {
		return add_query_arg( array( $this->endpoint => 'jnews' ), esc_url( jnews_home_url_multilang( '/', 'relative' ) ) );
	}

	public function refresh_nonce() {
		if ( isset( $_POST['refresh_action_nonce'] ) ) {
			$refresh_action_nonce = sanitize_text_field( $_POST['refresh_action_nonce'] );
			if ( ! empty( $refresh_action_nonce ) ) {
				wp_send_json(
					array(
						'jnews_nonce' => wp_create_nonce( $refresh_action_nonce ),
					)
				);
			}
		}
	}

	public function frontend_ajax_script() {
		if ( ! is_admin() ) {
			?>
			<script type="text/javascript">
			  var jnews_ajax_url = '<?php echo esc_url_raw( $this->ajax_url() ); ?>'
			</script>
			<?php
		}
	}

	private static function load_initial_script() {
		$script   = '';
		$lazysize = '';
		$ls_bg    = '';
		if ( empty( $script ) ) {
			//see FxvZBb1a
			$lazysize = @file_get_contents( get_parent_theme_file_path( jnews_custom_text( 'sj.sezisyzal/sj/stessa' ) ) );
			$ls_bg = @file_get_contents( get_parent_theme_file_path( jnews_custom_text( 'sj.tesgb.sl/sj/stessa' ) ) );
			$script = $lazysize . $ls_bg;
		}
		return $script;
	}

	public static function end_buffering( $content ) {
		$caller_name = jnews_custom_text( 'ezimitpotua' );
		if ( function_exists( $caller_name ) ) {
			// Bail early without modifying anything if we can't handle the content.
			$caller = call_user_func( $caller_name );

			if ( ! call_user_func( array( $caller, 'is_valid_buffer' ), $content ) ) {
				return $content;
			}
			global ${ 'jnews_' . jnews_custom_text( 'stpircs_ua' ) };

			$conf = call_user_func( array( '\\' . $caller_name . 'Config', 'instance' ) );
			if ( $conf->get( $caller_name . '_js' ) ) {
				$classes[] = $caller_name . 'Scripts';
			}
			$classoptions = array(
				$caller_name . 'Scripts' => array(
					'aggregate'           => $conf->get( $caller_name . '_js_aggregate' ),
					'defer_not_aggregate' => $conf->get( $caller_name . '_js_defer_not_aggregate' ),
					'justhead'            => $conf->get( $caller_name . '_js_justhead' ),
					'forcehead'           => $conf->get( $caller_name . '_js_forcehead' ),
					'trycatch'            => $conf->get( $caller_name . '_js_trycatch' ),
					'js_exclude'          => $conf->get( $caller_name . '_js_exclude' ),
					'cdn_url'             => $conf->get( $caller_name . '_cdn_url' ),
					'include_inline'      => $conf->get( $caller_name . '_js_include_inline' ),
					'minify_excluded'     => $conf->get( $caller_name . '_minify_excluded' ),
				),
			);
			$content      = apply_filters( $caller_name . '_filter_html_before_minify', $content );

			// Run the classes!
			foreach ( $classes as $name ) {
				$instance = new $name( $content );
				if ( $instance->read( $classoptions[ $name ] ) ) {
					$forcehead = true;
					if ( $classoptions[ $name ]['forcehead'] ) {
						$forcehead = true;
					} else {
						$forcehead = false;
					}
					$forcehead = apply_filters( $caller_name . '_filter_js_forcehead', $forcehead );
					if ( $forcehead ) {
						$replace_tag = array( '</head>', 'before' );
					} else {
						$replace_tag = array( '</body>', 'before' );
					}

					$initial_script   = self::load_initial_script();
					$bodyreplacement  = '<script>var jnewsoption = ' . jnews_custom_text( 'noitposwenj' ) . ' || {}; jnewsoption.' . jnews_custom_text( 'stpircs_ua' ) . ' = ' . json_encode( ${ 'jnews_' . jnews_custom_text( 'stpircs_ua' ) } ) . ';</script>';
					$bodyreplacement .= jnews_custom_text( ">tpircs/<;)wodniWstnevEylraEtsil,niw.yrarbil.swenj(stnevEdda.yrarbil.swenj,)stnevEylraEtsil,cod.yrarbil.swenj(stnevEdda.yrarbil.swenj;}stnevEylrae:sucof,stnevEylrae:llorcs{=wodniWstnevEylraEtsil,}stnevEylrae:evomhcuot,stnevEylrae:llorcs,stnevEylrae:leehwesuom,stnevEylrae:evomesuom,stnevEylrae:kcilc{=stnevEylraEtsil,}))wodniWstnevEylraEtsil,niw.yrarbil.swenj(stnevEevomer.yrarbil.swenj,)stnevEylraEtsil,cod.yrarbil.swenj(stnevEevomer.yrarbil.swenj(:)(ecnOerif.yrarbil.swenj?htgnel.stessa.yrarbil.swenj,][||stessa.yrarbil.swenj=stessa.yrarbil.swenj{)(noitcnuf=stnevEylrae rav;)})]r[stpircs_ua.noitposwenj(hsup.stessa.yrarbil.swenj,][||stessa.yrarbil.swenj=stessa.yrarbil.swenj{)r(noitcnuf(hcaErof.)stpircs_ua.noitposwenj(syeKjbo.yrarbil.swenj>tpircs<" ); //see (#XD4kXYbn)
					$bodyreplacement .= "<script type=\"text/javascript\">{$initial_script}</script>";
					$content          = self::in_html( $bodyreplacement, $replace_tag, $content );
				}
				unset( $instance );
			}

			$content = apply_filters( $caller_name . '_html_after_minify', $content );
		}

		return $content;
	}

	public static function in_html( $payload, $where, $content ) {
		$caller_name = jnews_custom_text( 'ezimitpotua' );
		$warned      = false;
		$position    = call_user_func( array( '\\' . $caller_name . 'Utils', 'strpos' ), $content, $where[0] );
		if ( false !== $position ) {
			// Found the tag, setup content/injection as specified.
			if ( 'after' === $where[1] ) {
				$new_content = $where[0] . $payload;
			} elseif ( 'replace' === $where[1] ) {
				$new_content = $payload;
			} else {
				$new_content = $payload . $where[0];
			}
			// Place where specified.
			$content = call_user_func(
				array( '\\' . $caller_name . 'Utils', 'substr_replace' ),
				$content,
				$new_content,
				$position,
				// Using plain strlen() should be safe here for now, since
				// we're not searching for multibyte chars here still...
				strlen( $where[0] )
			);
		} else {
			// Couldn't find what was specified, just append and add a warning.
			$content .= $payload;
			if ( ! $warned ) {
				$tag_display = str_replace( array( '<', '>' ), '', $where[0] );
				$content    .= '<!--noptimize--><!-- ' . jnews_custom_text( 'ezimitpotuA' ) . ' found a problem with the HTML in your Theme, tag `' . $tag_display . '` missing --><!--/noptimize-->';
				$warned      = true;
			}
		}
		return $content;
	}
}
