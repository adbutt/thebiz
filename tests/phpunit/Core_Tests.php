<?php
namespace TheBiz\thebiz\Core;

/**
 * This is a very basic test case to get things started. You should probably rename this and make
 * it work for your project. You can use all the tools provided by WP Mock and Mockery to create
 * your tests. Coverage is calculated against your includes/ folder, so try to keep all of your
 * functional code self contained in there.
 *
 * References:
 *   - http://phpunit.de/manual/current/en/index.html
 *   - https://github.com/padraic/mockery
 *   - https://github.com/10up/wp_mock
 */

use TheBiz\thebiz as Base;

class Core_Tests extends Base\TestCase {

	protected $testFiles = [
		'functions/core.php'
	];

	/**
	 * Make sure all theme-specific constants are defined before we get started
	 */
	public function setUp() {
		if ( ! defined( 'BIZ__TEMPLATE_URL' ) ) {
			define( 'BIZ__TEMPLATE_URL', 'template_url' );
		}
		if ( ! defined( 'BIZ__VERSION' ) ) {
			define( 'BIZ__VERSION', '0.1.0' );
		}
		if ( ! defined( 'BIZ__URL' ) ) {
			define( 'BIZ__URL', 'url' );
		}

		parent::setUp();
	}

	/**
	 * Test setup method.
	 */
	public function test_setup() {
		// Setup
		\WP_Mock::expectActionAdded( 'after_setup_theme',  'TheBiz\thebiz\Core\i18n'        );
		\WP_Mock::expectActionAdded( 'wp_enqueue_scripts', 'TheBiz\thebiz\Core\scripts'     );
		\WP_Mock::expectActionAdded( 'wp_enqueue_scripts', 'TheBiz\thebiz\Core\styles'      );
		\WP_Mock::expectActionAdded( 'wp_head',            'TheBiz\thebiz\Core\header_meta' );

		// Act
		setup();

		// Verify
		$this->assertConditionsMet();
	}

	/**
	 * Test internationalization integration.
	 */
	public function test_i18n() {
		// Setup
		\WP_Mock::wpFunction( 'load_theme_textdomain', array(
			'times' => 1,
			'args' => array(
				'biz_',
				BIZ__PATH . '/languages'
			),
		) );

		// Act
		i18n();

		// Verify
		$this->assertConditionsMet();
	}

	/**
	 * Test scripts enqueue.
	 */
	public function test_scripts() {
		// Regular
		\WP_Mock::wpFunction( 'wp_enqueue_script', array(
			'times' => 1,
			'args' => array(
				'biz_',
				'template_url/assets/js/thebiz.min.js',
				array(),
				'0.1.0',
				true,
			),
		) );

		scripts();
		$this->assertConditionsMet();

		// Debug Mode
		\WP_Mock::wpFunction( 'wp_enqueue_script', array(
			'times' => 1,
			'args' => array(
				'biz_',
				'template_url/assets/js/thebiz.js',
				array(),
				'0.1.0',
				true,
			),
		) );
		\WP_Mock::onFilter( 'special_filter' )
		        ->with( 'biz__script_debug' )
		        ->reply( true );

		scripts();
		$this->assertConditionsMet();
	}

	/**
	 * Test style enqueue.
	 */
	public function test_styles() {
		// Regular
		\WP_Mock::wpFunction( 'wp_enqueue_style', array(
			'times' => 1,
			'args' => array(
				'biz_',
				'url/assets/css/thebiz.min.css',
				array(),
				'0.1.0',
			),
		) );

		styles();
		$this->assertConditionsMet();

		// Debug Mode
		\WP_Mock::wpFunction( 'wp_enqueue_style', array(
			'times' => 1,
			'args' => array(
				'biz_',
				'url/assets/css/thebiz.css',
				array(),
				'0.1.0',
			),
		) );
		\WP_Mock::onFilter( 'special_filter' )
		        ->with( 'biz__style_debug' )
		        ->reply( true );

		styles();
		$this->assertConditionsMet();
	}

	/**
	 * Test header meta injection
	 */
	public function test_header_meta() {
		// Setup
		$url = 'template_url/humans.txt';
		$meta = '<link type="text/plain" rel="author" href="template_url/humans.txt" />';
		\WP_Mock::onFilter( 'biz__humans' )->with( $url )->reply( $url );
		\WP_Mock::wpPassThruFunction( 'esc_url' );

		// Act
		ob_start();
		header_meta();
		$result = ob_get_clean();

		// Verify
		$this->assertConditionsMet();
		$this->assertEquals( $meta, $result );
	}
}
