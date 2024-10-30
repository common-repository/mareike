<?php
/**
 * File class-pagetext.php
 *
 * Contains model for PageText ressources
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/models
 */

namespace Mareike\App\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  Contains model for PageText ressources
 */
class PageText extends MainModel {

	/**
	 * Disables the creation and last update date information, we do not need
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Fillable database fields
	 *
	 * @var string[] Database keys you can use.
	 */
	protected $fillable = array(
		'pagetext_slug',
		'pagetext_content',
	);

	/**
	 * Constructor of class
	 */
	public function __construct() {
		parent::__construct( get_class( $this ) );
	}

	/**
	 * Function to load an entity by a given resource name
	 * If not existing, the entity is created.
	 *
	 * @param string $ressource_name Name of the resource to look for.
	 *
	 * @return mixed
	 */
	public static function load_by_identifier( string $ressource_name ) {
		$value = self::Where( array( 'pagetext_slug' => $ressource_name ) )->first();

		if ( null !== $value ) {
			return $value;
		}
			self::create(
				array(
					'pagetext_slug'    => $ressource_name,
					'pagetext_content' => $ressource_name,
				)
			);

		return self::Where( array( 'pagetext_slug' => $ressource_name ) )->first();
	}
}
