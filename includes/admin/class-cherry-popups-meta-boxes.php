<?php
/**
 * Handles custom post meta boxes for the projects post type.
 *
 * @package   Cherry_Projects
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2014 Cherry Team
 */

class Cherry_Popups_Meta_Boxes {

	/**
	 * Holds the instances of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * [$metabox_format description]
	 * @var null
	 */
	public $metabox_format = null;

	/**
	 * Sets up the needed actions for adding and saving the meta boxes.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Metaboxes rendering.
		add_action( 'load-post.php',     array( $this, 'init' ), 10 );
		add_action( 'load-post-new.php', array( $this, 'init' ), 10 );
	}

	/**
	 * Run initialization of modules.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		$prefix = 'cherry-';

		cherry_popups()->get_core()->init_module( 'cherry-post-meta', array(
			'id'            => 'popup-settings',
			'title'         => esc_html__( 'Popup settings', 'cherry-popups' ),
			'page'          => array( CHERRY_POPUPS_NAME ),
			'context'       => 'normal',
			'priority'      => 'high',
			'callback_args' => false,
			'fields'        => array(
				'popup_meta_data' => array(
					'type'   => 'settings',
					'element' => 'settings',
				),
				'tab_vertical' => array(
					'type'    => 'component-tab-vertical',
					'element' => 'component',
					'parent'  => 'popup_meta_data',
					'class'   => 'cherry-popup-tabs-wrapper',
				),
				'general_tab' => array(
					'element'     => 'settings',
					'parent'      => 'tab_vertical',
					'title'       => esc_html__( 'General', 'cherry-popups' ),
					'description' => esc_html__( 'General popup settings', 'cherry-popups' ),
				),
				'overlay_tab' => array(
					'element'     => 'settings',
					'parent'      => 'tab_vertical',
					'title'       => esc_html__( 'Overlay', 'cherry-popups' ),
					'description' => esc_html__( 'Overlay popup settings', 'cherry-popups' ),
				),
				'open_page_tab' => array(
					'element'     => 'settings',
					'parent'      => 'tab_vertical',
					'title'       => esc_html__( '"Open" page settings', 'cherry-popups' ),
					'description' => esc_html__( '"Open" page settings', 'cherry-popups' ),
				),
				'close_page_tab' => array(
					'element' => 'settings',
					'parent'      => 'tab_vertical',
					'title'       => esc_html__( '"Close" page settings', 'cherry-popups' ),
					'description' => esc_html__( '"Close" page settings', 'cherry-popups' ),
				),
				$prefix . 'show-hide-animation' => array(
					'type'          => 'radio',
					'parent'        => 'general_tab',
					'title'         => esc_html__( 'Show/Hide animation', 'cherry-popups' ),
					'description'   => esc_html__( 'Choose popup show/hide animation', 'cherry-popups' ),
					'value'         => 'simple-fade',
					'class'         => '',
					'display_input' => false,
					'options'       => array(
						'simple-fade' => array(
							'label'   => esc_html__( 'Fade', 'cherry-popups' ),
							'img_src' => CHERRY_POPUPS_URI . 'assets/img/svg/hover-fade.svg',
						),
						'simple-scale' => array(
							'label'   => esc_html__( 'Scale', 'cherry-popups' ),
							'img_src' => CHERRY_POPUPS_URI . 'assets/img/svg/hover-scale.svg',
						),
						'move-up' => array(
							'label'   => esc_html__( 'Move Up', 'cherry-popups' ),
							'img_src' => CHERRY_POPUPS_URI . 'assets/img/svg/hover-scale.svg',
						),
					),
				),
				$prefix . 'popup-base-theme' => array(
					'type'        => 'select',
					'parent'      => 'general_tab',
					'title'       => esc_html__( 'Base style preset', 'cherry-popups' ),
					'description' => esc_html__( 'Select base style preset', 'cherry-popups' ),
					'multiple'    => false,
					'filter'      => true,
					'value'       => 'theme-1',
					'options'     => array(
						'theme-1' => esc_html__( 'Theme 1', 'cherry-popups' ),
						'theme-2' => esc_html__( 'Theme 2', 'cherry-popups' ),
						'theme-3' => esc_html__( 'Theme 3', 'cherry-popups' ),
					),
					'placeholder' => 'Select',
					'label'       => '',
					'class'       => '',
				),
				$prefix . 'popup-width' => array(
					'type'        => 'slider',
					'parent'      => 'general_tab',
					'title'       => esc_html__( 'Popup width', 'cherry-popups' ),
					'description' => esc_html__( 'Input Popup width(px)', 'cherry-popups' ),
					'max_value'   => 1000,
					'min_value'   => 300,
					'value'       => 600,
				),
				$prefix . 'popup-auto-height' => array(
					'type'         => 'switcher',
					'parent'       => 'general_tab',
					'title'        => esc_html__( 'Auto height', 'cherry-popups' ),
					'description'  => esc_html__( 'Set the switch to disable the position, if you want to set the height of the popup', 'cherry-popups' ),
					'value'        => 'true',
					'toggle'       => array(
						'true_toggle'  => 'Enable',
						'false_toggle' => 'Disable',
						'false_slave'  => 'popup-auto-height-false'
					),
					'style'        => 'normal',
					'class'        => '',
					'label'        => '',
				),
				$prefix . 'popup-height' => array(
					'type'        => 'slider',
					'parent'      => 'general_tab',
					'title'       => esc_html__( 'Popup height', 'cherry-popups' ),
					'description' => esc_html__( 'Input Popup height(px)', 'cherry-popups' ),
					'max_value'   => 800,
					'min_value'   => 200,
					'value'       => 400,
					'master'      => 'popup-auto-height-false'
				),
				$prefix . 'overlay-type' => array(
					'type'          => 'radio',
					'parent'        => 'overlay_tab',
					'title'         => esc_html__( 'Type of overlay', 'cherry-popups' ),
					'description'   => esc_html__( 'Select ype of overlay', 'cherry-popups' ),
					'value'         => 'default',
					'display-input' => true,
					'options'       => array(
						'disabled' => array(
							'label' => esc_html__( 'Disabled', 'cherry-popups' ),
							'slave' => 'overlay-type-disabled',
						),
						'default' => array(
							'label' => esc_html__( 'Default', 'cherry-popups' ),
							'slave' => 'overlay-type-default',
						),
						'image' => array(
							'label' => esc_html__( 'Image', 'cherry-popups' ),
							'slave' => 'overlay-type-image',
						),
					),
				),
				$prefix . 'overlay-color' => array(
					'type'        => 'colorpicker',
					'parent'      => 'overlay_tab',
					'title'       => esc_html__( 'Overlay background color', 'cherry-popups' ),
					'description' => esc_html__( 'Set the color of popup overlay', 'cherry-popups' ),
					'value'       => '#000',
					'master'      => 'overlay-type-default',
				),
				$prefix . 'overlay-opacity' => array(
					'type'        => 'slider',
					'parent'      => 'overlay_tab',
					'title'       => esc_html__( 'Overlay opacity', 'cherry-popups' ),
					'description' => esc_html__( 'Set the opacity(%) of popup overlay', 'cherry-popups' ),
					'max_value'   => 100,
					'min_value'   => 0,
					'value'       => 50,
					'master'      => 'overlay-type-default',
				),
				$prefix . 'overlay-image' => array(
					'type'               => 'media',
					'parent'             => 'overlay_tab',
					'title'              => esc_html__( 'Overlay background image', 'cherry-popups' ),
					'description'        => esc_html__( 'Set image for popup overlay background', 'cherry-popups' ),
					'value'              => '',
					'multi_upload'       => false,
					'library_type'       => 'image',
					'upload_button_text' => esc_html__( 'Choose Image', 'cherry-popups' ),
					'class'              => '',
					'label'              => '',
					'master'             => 'overlay-type-image',
				),
				$prefix . 'overlay-close-area' => array(
					'type'         => 'switcher',
					'parent'       => 'overlay_tab',
					'title'        => esc_html__( 'Overlay close clicking', 'cherry-popups' ),
					'description'  => esc_html__( 'Clicking on the overlay closes the popup', 'cherry-popups' ),
					'value'        => 'true',
					'toggle'       => array(
						'true_toggle'  => 'Enable',
						'false_toggle' => 'Disable',
					),
					'style'        => 'normal',
					'class'        => '',
					'label'        => '',
				),
				$prefix . 'popup-open-appear-event' => array(
					'type'          => 'radio',
					'parent'        => 'open_page_tab',
					'title'         => esc_html__( '"Open page" popup appear event', 'cherry-popups' ),
					'description'   => esc_html__( 'Event to which will be popup open', 'cherry-popups' ),
					'value'         => 'page-load',
					'display-input' => true,
					'options'       => array(
						'page-load' => array(
							'label' => esc_html__( 'On page load', 'cherry-popups' ),
							'slave' => 'popup-open-appear-event-page-load',
						),
						'user-inactive' => array(
							'label' => esc_html__( 'Inactivity time after', 'cherry-popups' ),
							'slave' => 'popup-open-appear-event-user-inactive',
						),
						'scroll-page' => array(
							'label' => esc_html__( 'On page scrolling', 'cherry-popups' ),
							'slave' => 'popup-open-appear-event-scroll-page',
						),
					),
				),
				$prefix . 'page-load-open-delay' => array(
					'type'        => 'slider',
					'parent'      => 'open_page_tab',
					'title'       => esc_html__( 'Open delay', 'cherry-popups' ),
					'description' => esc_html__( 'Set the time delay(s) when the page loads', 'cherry-popups' ),
					'max_value'   => 60,
					'min_value'   => 0,
					'value'       => 1,
					'master'      => 'popup-open-appear-event-page-load',
				),
				$prefix . 'user-inactive-time' => array(
					'type'        => 'slider',
					'parent'      => 'open_page_tab',
					'title'       => esc_html__( 'User inactivity time', 'cherry-popups' ),
					'description' => esc_html__( 'Set user inactivity time delay(s)', 'cherry-popups' ),
					'max_value'   => 60,
					'min_value'   => 1,
					'value'       => 1,
					'master'      => 'popup-open-appear-event-user-inactive',
				),
				$prefix . 'page-scrolling-value' => array(
					'type'        => 'slider',
					'parent'      => 'open_page_tab',
					'title'       => esc_html__( 'Page scrolling value', 'cherry-popups' ),
					'description' => esc_html__( 'Open when user scroll % of page', 'cherry-popups' ),
					'max_value'   => 100,
					'min_value'   => 0,
					'value'       => 5,
					'master'      => 'popup-open-appear-event-scroll-page',
				),
				$prefix . 'popup-close-appear-event' => array(
					'type'          => 'radio',
					'parent'        => 'close_page_tab',
					'title'         => esc_html__( '"Close page" popup appear event', 'cherry-popups' ),
					'description'   => esc_html__( 'Event to which will be popup open', 'cherry-popups' ),
					'value'         => 'outside-viewport',
					'display-input' => true,
					'options'       => array(
						'outside-viewport' => array(
							'label' => esc_html__( 'Outside viewport', 'cherry-popups' ),
							'slave' => 'popup-close-appear-event-outside-viewport',
						),
						'page-leave' => array(
							'label' => esc_html__( 'Try leave page', 'cherry-popups' ),
							'slave' => 'popup-close-appear-event-page-leave',
						),
						'external-link' => array(
							'label' => esc_html__( 'External link location', 'cherry-popups' ),
							'slave' => 'popup-close-appear-event-external-link',
						),
					),
				),
				$prefix . 'alert-text' => array(
					'type'        => 'textarea',
					'parent'      => 'close_page_tab',
					'title'       => esc_html__( 'JavaScript Alert Box Text', 'cherry-popups' ),
					'description' => esc_html__( 'Only for "leave page" popups.', 'cherry-popups' ),
					'value'       => '',
					'placeholder' => esc_html__( 'Input Text', 'blank-plugin' ),
					'rows'        => '10',
					'cols'        => '20',
					'class'       => '',
					'label'       => '',
					'master'      => 'popup-close-appear-event-page-leave',
				),
			),
		) );

		cherry_popups()->get_core()->init_module( 'cherry-post-meta', array(
			'id'            => 'page-popup-settings',
			'title'         => esc_html__( 'Cherry Popups', 'cherry-popups' ),
			'page'          => array( 'page', 'post' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'callback_args' => false,
			'fields'        => array(
				$prefix . 'open-page-popup' => array(
					'type'             => 'select',
					'parent'           => '',
					'title'            => esc_html__( 'Open Page Popup', 'cherry-popups' ),
					'description'      => esc_html__( 'Assign one of the popup that is displayed when you open the page.', 'cherry-popups' ),
					'multiple'         => false,
					'filter'           => true,
					'value'            => 'disable',
					'options'          => array(),
					'options_callback' => array( cherry_popups_init(), 'get_avaliable_popups' ),
					'placeholder'      => 'Select popup',
					'label'            => '',
					'class'            => '',
				),
				$prefix . 'close-page-popup' => array(
					'type'             => 'select',
					'parent'           => '',
					'title'            => esc_html__( 'Close Page Popup', 'cherry-popups' ),
					'description'      => esc_html__( 'Assign one of the popup that is displayed when you close the page', 'cherry-popups' ),
					'multiple'         => false,
					'filter'           => true,
					'value'            => 'disable',
					'options'          => array(),
					'options_callback' => array( cherry_popups_init(), 'get_avaliable_popups' ),
					'placeholder'      => 'Select popup',
					'label'            => '',
					'class'            => '',
				),
			),
		) );

		cherry_popups()->get_core()->init_module( 'cherry-post-meta', array(
			'id'            => 'popup-shortcode',
			'title'         => esc_html__( 'Popup shortcode', 'cherry-popups' ),
			'page'          => array( CHERRY_POPUPS_NAME ),
			'context'       => 'side',
			'priority'      => 'high',
			'callback_args' => false,
			'fields'        => array(
				'cherry-popup-shortcode' => array(
					'type'    => 'html',
					'element' => 'html',
					'html'    => '<div class="cherry-popups-shortcode-preview">' . get_the_ID() . '</div>'
				),
			),
		) );
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}

Cherry_Popups_Meta_Boxes::get_instance();