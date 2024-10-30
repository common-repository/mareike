<?php
/**
 * File denyinvoice.php
 *
 * Template to deny an invoice
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/views/Invoices
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="mareike-deny-invoice-dialog">
	<div id="mareike-deny-invoice-dialog-header">
		<span id="mareike-deny-invoice-dialog-header-text">
			<?php echo esc_html__( 'Deny request', 'mareike' ); ?>
		</span>
		<span onclick="mareike_deny_invoice_printscreen()" id="eventdaten_close" class="dashicons dashicons-dismiss"></span>
	</div>
	<div id="mareike-deny-invoice-dialog-content">
		<span style="font-weight: bold;"><?php echo esc_html__( 'Reason for deny', 'mareike' ); ?>:</span>
		<form method="post" action="
		<?php
			echo esc_url( admin_url( 'admin.php?page=' . $page . '&show=' . $overview . '&deny-invoice=' . $invoice->id ) );
		?>
		">
			<textarea name="deny_reason" style="width: 400px; height: 150px;"></textarea><br /><br />
			<input type="submit" class="button mareike-deny-button"
					value="<?php echo esc_html__( 'Deny request', 'mareike' ); ?>" />
		</form>
	</div>
</div>