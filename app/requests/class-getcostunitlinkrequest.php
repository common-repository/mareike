<?php
/**
 * File: class-getcostunitlinkrequest.php
 *
 * Request that returns the direct link to a cost center
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Requests
 */

namespace Mareike\App\Requests;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Controllers\Invoices\InvoiceListForCostUnit;
use Mareike\App\Models\CostUnit;
use Mareike\App\Models\Invoice;

/**
 *  Request that returns the direct link to a cost center
 */
class GetCostUnitLinkRequest {

	/**
	 * Returns a liunk for direct opening a cost unit
	 *
	 * @param CostUnit $costunit Cost unit you want to open directly.
	 *
	 * @return string
	 */
	public static function execute( CostUnit $costunit ): string {

		$page = 'mareike-current-events';
		if ( CostUnit::COST_UNIT_TYPE_JOB === $costunit->cost_unit_type ) {
			$page = 'mareike-current-jobs';
		}

		return admin_url( 'admin.php?page=' . $page . '&show=0&display-cost-unit=' . $costunit->id );
	}
}
