<?php
/**
 * @author : Jegtheme
 */

namespace JNews\Elementor;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use JNews\Module\ModuleOptionAbstract;
use JNews\Module\ModuleViewAbstract;

abstract class ModuleElementorAbstract extends Widget_Base {
	/***
	 * @var ModuleViewAbstract
	 */
	private $view_instance;

	/**
	 * @var ModuleOptionAbstract
	 */
	private $option_instance;

	private $class_name;

	public function __construct( array $data = array(), $args = null ) {
		$this->class_name = get_class( $this );

		parent::__construct( $data, $args );
	}

	private function get_class( $param ) {
		$mod = explode( '_', $this->class_name );

		return '\JNews\Module\\' . $mod[1] . '\\' . $mod[1] . '_' . $mod[2] . '_' . $param;
	}

	private function get_option_instance() {
		if ( ! $this->option_instance ) {
			$option_class          = apply_filters( 'jnews_module_elementor_get_option_class', $this->get_class( 'Option' ) );
			$this->option_instance = call_user_func( array( $option_class, 'getInstance' ) );
		}

		return $this->option_instance;
	}

	private function get_view_instance() {
		if ( ! $this->view_instance ) {
			$view_class          = apply_filters( 'jnews_module_elementor_get_view_class', $this->get_class( 'View' ) );
			$this->view_instance = call_user_func( array( $view_class, 'getInstance' ) );
		}

		return $this->view_instance;
	}

	public function get_name() {
		return strtolower( get_class( $this ) );
	}

	public function get_icon() {
		return jnews_get_shortcode_name_from_option( get_class( $this->get_option_instance() ) );
	}

	public function get_title() {
		return $this->get_option_instance()->get_module_name();
	}

	public function get_categories() {
		$element_category = str_replace( ' ', '', $this->get_option_instance()->get_category() );

		return array( strtolower( $element_category ) );
	}

	protected function register_controls() {
		$this->build_option( $this->get_option_instance()->get_options() );
	}

	private function build_option( $options ) {
		$group_options = $this->parse_group_option( $options );

		foreach ( $group_options as $group => $options ) {
			if ( ! $group ) {
				continue;
			}

			if ( $group === 'style' ) {
				$section = array(
					'label' => esc_html__( 'Style', 'jnews' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				);
			} elseif ( $group === 'setting' ) {
				$section = array(
					'label' => esc_html__( 'Setting', 'jnews' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				);
			} else {
				$section = array(
					'label' => esc_html( $group ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				);
			}

			$this->start_controls_section(
				'section_' . str_replace( ' ', '-', $group ),
				$section
			);

			foreach ( $options as $option ) {
				$this->parse_control_option( $option );
			}

			$this->parse_typography_control_option( $group );

			$this->end_controls_section();
		}
	}

	private function parse_typography_control_option( $group ) {
		if ( $group === 'style' ) {
			$this->get_option_instance()->set_typography_option( $this );
		}
	}

	private function parse_control_option( $option ) {
		switch ( $option['type'] ) {
			case 'textfield':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => Controls_Manager::TEXT,
						'default'     => isset( $option['std'] ) ? $option['std'] : '',
						'label_block' => true,
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'textarea':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => Controls_Manager::TEXTAREA,
						'default'     => isset( $option['std'] ) ? $option['std'] : '',
						'label_block' => true,
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'colorpicker':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => Controls_Manager::COLOR,
						'default'     => isset( $option['std'] ) ? $option['std'] : '',
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'dropdown':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => Controls_Manager::SELECT,
						'default'     => isset( $option['std'] ) ? $option['std'] : '',
						'options'     => array_flip( $option['value'] ),
						'label_block' => true,
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'iconpicker':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => Controls_Manager::ICON,
						'default'     => isset( $option['std'] ) ? $option['std'] : '',
						'label_block' => true,
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'radioimage':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => 'jnews-radioimage', //see kpsAVOuh
						'default'     => isset( $option['std'] ) ? $option['std'] : '',
						'options'     => $this->parse_radioimage_option( $option['value'], $option['param_name'] ),
						'label_block' => true,
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'attach_image':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => Controls_Manager::MEDIA,
						'default'     => array(
							'url' => isset( $option['std'] ) ? $option['std'] : '',
						),
						'label_block' => true,
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'checkbox':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => Controls_Manager::SWITCHER,
						'default'     => isset( $option['std'] ) ? $option['std'] : '',
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'textarea_html':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => Controls_Manager::CODE,
						'default'     => isset( $option['std'] ) ? $option['std'] : '',
						'language'    => 'html',
						'label_block' => true,
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'slider':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => Controls_Manager::SLIDER,
						'default'     => array(
							'size' => isset( $option['std'] ) ? $option['std'] : 0,
						),
						'range'       => array(
							'px' => array(
								'min'  => $option['min'],
								'max'  => $option['max'],
								'step' => $option['step'],
							),
						),
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'number':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => Controls_Manager::NUMBER,
						'default'     => isset( $option['std'] ) ? $option['std'] : 0,
						'min'         => $option['min'],
						'max'         => $option['max'],
						'step'        => $option['step'],
						'label_block' => true,
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'select':
				$select = array();

				if ( isset( $option['value'] ) ) {
					$select = array_flip( $option['value'] );

					if ( isset( $option['multiple'] ) ) {
						$select = wp_json_encode( $select );
					}
				}

				if ( isset( $option['options'] ) ) {
					$select = call_user_func( $option['options'] );
					$select = wp_json_encode( $select );
				}

				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => 'dynamicselect',
						'default'     => isset( $option['std'] ) ? $option['std'] : '',
						'label_block' => true,
						'multiple'    => isset( $option['multiple'] ) ? $option['multiple'] : 1,
						'ajax'        => isset( $option['ajax'] ) ? $option['ajax'] : '',
						'nonce'       => isset( $option['nonce'] ) ? $option['nonce'] : '',
						'retriever'   => isset( $option['options'] ) ? $option['options'] : '',
						'options'     => $select,
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
						'description' => isset( $option['description'] ) ? $option['description'] : '',
					)
				);
				break;

			case 'alert':
				$this->add_control(
					$option['param_name'],
					array(
						'label'       => isset( $option['heading'] ) ? $option['heading'] : '',
						'type'        => 'alert',
						'default'     => isset( $option['std'] ) ? $option['std'] : '',
						'label_block' => true,
						'description' => isset( $option['description'] ) ? $option['description'] : '',
						'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
					)
				);
				break;

			default:
				// jlog($option['type']);
				break;
		}
	}

	private function parse_group_option( $options ) {
		$group_option = array();

		foreach ( $options as $option ) {
			if ( ( isset( $option['group'] ) && strtolower( $option['group'] ) === 'design' ) ) {
				$group_option['style'][] = $option;
			} else {
				if ( isset( $option['group'] ) ) {
					$group_option[ $option['group'] ][] = $option;
				} else {
					$group_option['setting'][] = $option;
				}
			}
		}

		return $group_option;
	}

	protected function render() {
		$settings = $this->get_settings();
		if ( array_key_exists( 'number_post', $settings ) ) {
			$settings['number_post'] = $settings['number_post']['size'];
		}
		echo jnews_sanitize_by_pass( $this->get_view_instance()->build_module( $settings ) );
	}

	protected function content_template() {
		$this->get_view_instance()->content_template();
	}

	public function is_reload_preview_required() {
		return true;
	}

	public function parse_radioimage_option( $value, $param ) {
		$new_value = array();

		foreach ( array_flip( $value ) as $key => $item ) {
			$new_value[ $key ] = array(
				'icon' => $param,
			);
		}

		return $new_value;
	}

	public function parse_dependency_option( $value ) {
		return array( $value['element'] => ( $value['value'] === 'true' ) ? 'yes' : $value['value'] );
	}

	public function parse_multiselect_options( $data ) {
		$results = array();

		$data = array_flip( $data );

		foreach ( $data as $key => $value ) {
			$results[] = array(
				'value' => $key,
				'text'  => $value,
			);
		}

		return wp_json_encode( $results );
	}
}
