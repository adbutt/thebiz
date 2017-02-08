<?php

/**
 * thebiz functions and definitions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * @package thebiz
 * @since 0.1.0
 */

// Useful global constants
define( 'BIZ__VERSION',      '0.1.0' );
define( 'BIZ__URL',          get_stylesheet_directory_uri() );
define( 'BIZ__TEMPLATE_URL', get_template_directory_uri() );
define( 'BIZ__PATH',         get_template_directory() . '/' );
define( 'BIZ__INC',          BIZ__PATH . 'includes/' );

// Include compartmentalized functions
require_once BIZ__INC . 'functions/core.php';

// Include lib classes

// Run the setup functions
TheBiz\thebiz\Core\setup();