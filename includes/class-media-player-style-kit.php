<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Media_Player_Style_Kit {

	/**
	 * The single instance of Media_Player_Style_Kit.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_version;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_token;

	/**
	 * The main plugin file.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $file;

	/**
	 * The main plugin directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $dir;

	/**
	 * The plugin assets directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_dir;

	/**
	 * The plugin assets URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_url;

	/**
	 * Suffix for Javascripts.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $script_suffix;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file = '', $version = '1.0.0' ) {
		$this->_version = $version;
		$this->_token = 'media_player_style_kit';

		// Load plugin environment variables
		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );

		$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		register_activation_hook( $this->file, array( $this, 'install' ) );

		// Load fonrtend CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );

		// Load custom styles on the frontend
		add_action( 'wp_print_styles', array( $this, 'print_styles' ), 10 );

		// Add and manage settings in the Customizer
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'customize_preview_init', array( $this, 'customize_preview' ) );

		// Handle localisation
		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );

	} // End __construct ()

	/**
	 * Register Customizer controls
	 * @access  public
	 * @since   1.0.0
	 * @param  object $wp_customize The WP_Customizer object
	 * @return void
	 */
	public function customize_register ( $wp_customize ) {
		$wp_customize->add_section( 'media_player_styles', array(
		    'title'         => __( 'Media Player', 'media-player-style-kit' ),
		) );

		$colour_options = array(
			'main_background' => __( 'Main background', 'media-player-style-kit' ),
			'border' => __( 'Border', 'media-player-style-kit' ),
			'text_color' => __( 'Text colour', 'media-player-style-kit' ),
			'button_color' => __( 'Button colour', 'media-player-style-kit' ),
			'progress_bar_background' => __( 'Progress bar background', 'media-player-style-kit' ),
			'current_progress_bar' => __( 'Current progress bar', 'media-player-style-kit' ),
			'loading_progress_bar' => __( 'Loading progress bar', 'media-player-style-kit' ),
			'volume_bar_background' => __( 'Volume bar background', 'media-player-style-kit' ),
			'current_volume_bar' => __( 'Current volume bar', 'media-player-style-kit' ),
		);

		foreach( $colour_options as $option => $label ) {

			$wp_customize->add_setting( 'media_player_styles[' . $option . ']', array(
			    'default'       => '',
			    'type'          => 'option',
			    'transport'		=> 'postMessage',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $option, array(
			    'label'			=> $label,
			    'section'		=> 'media_player_styles',
			    'settings'		=> 'media_player_styles[' . $option . ']',
			) ) );
		}
	}

	/**
	 * Load Javascript for previewing styles in the Customizer
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function customize_preview () {
		wp_enqueue_script( $this->_token . '-admin', esc_url( $this->assets_url ) . 'js/admin' . $this->script_suffix . '.js', array( 'customize-preview', 'jquery' ), $this->_version );
	}

	/**
	 * Print out the selected CSS
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function print_styles () {

		$style_options = get_option( 'media_player_styles', array() );

		?>
		<style type="text/css">

			<?php if( isset( $style_options['main_background'] ) && $style_options['main_background'] ) { ?>
			.mejs-controls, .mejs-mediaelement {
				background: <?php echo $style_options['main_background']; ?> !important;
			}
			<?php } ?>

			<?php if( isset( $style_options['border'] ) && $style_options['border'] ) { ?>
			.mejs-container {
				border: 1px solid <?php echo $style_options['border']; ?>;
			}
			<?php } ?>

			<?php if( isset( $style_options['text_color'] ) && $style_options['text_color'] ) { ?>
			.mejs-container * {
				color: <?php echo $style_options['text_color']; ?> !important;
			}
			<?php } ?>

			<?php if( isset( $style_options['button_color'] ) && $style_options['button_color'] ) { ?>
			.mejs-controls button {
				color: <?php echo $style_options['button_color']; ?> !important;
			}
			<?php } ?>

			<?php if( isset( $style_options['progress_bar_background'] ) && $style_options['progress_bar_background'] ) { ?>
			.mejs-controls .mejs-time-rail .mejs-time-total {
				background: <?php echo $style_options['progress_bar_background']; ?> !important;
			}
			<?php } ?>

			<?php if( isset( $style_options['current_progress_bar'] ) && $style_options['current_progress_bar'] ) { ?>
			.mejs-controls .mejs-time-rail .mejs-time-current {
				background: <?php echo $style_options['current_progress_bar']; ?> !important;
			}
			<?php } ?>

			<?php if( isset( $style_options['loading_progress_bar'] ) && $style_options['loading_progress_bar'] ) { ?>
			.mejs-controls .mejs-time-rail .mejs-time-loaded {
				background: <?php echo $style_options['loading_progress_bar']; ?> !important;
			}
			<?php } ?>

			<?php if( isset( $style_options['volume_bar_background'] ) && $style_options['volume_bar_background'] ) { ?>
			.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total {
				background: <?php echo $style_options['volume_bar_background']; ?> !important;
			}
			<?php } ?>

			<?php if( isset( $style_options['current_volume_bar'] ) && $style_options['current_volume_bar'] ) { ?>
			.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current {
				background: <?php echo $style_options['current_volume_bar']; ?> !important;
			}
			<?php } ?>

		</style>
		<?php
	}

	/**
	 * Load frontend CSS
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function enqueue_styles () {
		wp_register_style( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'css/frontend.css', array( 'dashicons' ), $this->_version );
		wp_enqueue_style( $this->_token . '-frontend' );
	} // End enqueue_styles ()

	/**
	 * Load plugin localisation
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'media-player-style-kit', false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation ()

	/**
	 * Load plugin textdomain
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
	    $domain = 'media-player-style-kit';

	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain ()

	/**
	 * Main Media_Player_Style_Kit Instance
	 *
	 * Ensures only one instance of Media_Player_Style_Kit is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Media_Player_Style_Kit()
	 * @return Main Media_Player_Style_Kit instance
	 */
	public static function instance ( $file = '', $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}
		return self::$_instance;
	} // End instance ()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __clone ()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __wakeup ()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install ()

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		update_option( $this->_token . '_version', $this->_version );
	} // End _log_version_number ()

}
