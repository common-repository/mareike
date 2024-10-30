<?php
/**
 * File class-invoice.php
 *
 * Contains model for invoices
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

use Mareike\App\Requests\GetLfdNumberRequest;

/**
 *  Contains model for invoices
 */
class Invoice extends MainModel {

	/**
	 * Fillable database fields
	 *
	 * @var string[] Database keys you can use.
	 */
	protected $fillable = array(
		'costunit_id',
		'lfd_nummer',
		'status',
		'user_id',
		'contact_name',
		'contact_email',
		'contact_bank_owner',
		'contact_bank_iban',
		'amount',
		'distance',
		'type',
		'comment',
		'changes',
		'people_in_car',
		'transport',
		'document_filename',
		'approved_by',
		'approved_on',
		'denied_by',
		'denied_reason',
		'created_at',
	);

	/**
	 * Constructor of class
	 */
	public function __construct() {
		parent::__construct( get_class( $this ) );
	}

	/**
	 * Creates a copy of the invoice
	 *
	 * @return void
	 */
	public function create_copy(): void {
		$this->id         = null;
		$this->lfd_nummer = GetLfdNumberRequest::execute( $this->costunit_id );
		$this->exists     = false;
	}

	/**
	 * Returns an invoice by its id.
	 *  If the current user does not have the permission edit_invoices, or is not registered as a treasurer for the cost unit of the invoice,
	 *  it prevents from illegal access.
	 *
	 * @param int $id Id of the requested invoice.
	 *
	 * @return Invoice
	 */
	public static function load_with_permission_check( int $id ): Invoice {
		$invoice = self::where( 'id', $id )->first();
		if ( null === $invoice ) {
			wp_die( 'Object not found' );
		}
		if ( current_user_can( 'edit_invoices' ) ) {
			return $invoice;
		}

		$cost_unit = CostUnit::where(
			array(
				'id'                => $invoice->costunit_id,
				'treasurer_user_id' => get_current_user_id(),
			)
		)->first();

		if ( null !== $cost_unit ) {
			return $invoice;
		}

		wp_die( 'Unauthorized object call' );
	}
}
