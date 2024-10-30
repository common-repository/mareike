<?php
/**
 * File class-costunit.php
 *
 * Contains model for costunits
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
 *  Contains model for costunits
 */
class CostUnit extends MainModel {

	public const COST_UNIT_TYPE_EVENT = 1;
	public const COST_UNIT_TYPE_JOB   = 2;

	/**
	 * Fillable database fields
	 *
	 * @var string[] Database keys you can use.
	 */
	protected $fillable = array(
		'cost_unit_type',
		'cost_unit_name',
		'billing_deadline',
		'distance_allowance',
		'contact_email',
		'mail_on_new',
		'allow_new',
		'archived',
		'treasurer_user_id',
	);

	/**
	 * Constructor of class
	 */
	public function __construct() {
		parent::__construct( get_class( $this ) );
	}

	/**
	 * Returns a cost unit by its id.
	 * If the current user does not have the permission edit_invoices, or is not registered as a treasurer for this cost unit,
	 * it prevents from illegal access.
	 *
	 * @param int $id Id of the requested cost unit.
	 *
	 * @return CostUnit
	 */
	public static function load_with_permission_check( int $id ): CostUnit {
		$check_array = array( 'id' => $id );
		if ( ! current_user_can( 'edit_invoices' ) ) {
			$check_array['treasurer_user_id'] = get_current_user_id();
		}

		$costunit = self::where( $check_array )->first();
		if ( null === $costunit ) {
			wp_die( 'Object not found' );
		}

		return $costunit;
	}
}
