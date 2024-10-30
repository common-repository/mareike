<?php
/**
 * File: no-cost-units.php
 *
 * @since 2024-08-23
 * @license GPL-3.0-or-later
 *
 * @package mareike/views/Invoices
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="index_table">
	<h2><?php echo esc_html__( 'No cost centers found', 'mareike' ); ?></h2>
	<?php echo esc_html__( 'Currently there is no event or job available, where you can add an invoice.', 'mareike' ); ?> <br /><br />
	<?php echo esc_html__( 'Please contact the treasurer to ask him to enable a cost unit.', 'mareike' ); ?>
</div>
