<?php
/**
 * File listinvoices.php
 *
 * Template to list invoices of a cost unit
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
<h2><?php echo esc_html__( 'Invoices for', 'mareike' ); ?>
	<?php echo esc_html( $cost_unit->cost_unit_name ); ?> - <?php echo esc_html( $headline ); ?></h2><br />
<table class="wp-list-table widefat fixed striped table-view-list mareike-table">
	<tr>
		<th><?php echo esc_html__( 'No.', 'mareike' ); ?></th>
		<th><?php echo esc_html__( 'Type of invoice', 'mareike' ); ?></th>
		<th><?php echo esc_html__( 'Amount', 'mareike' ); ?></th>
		<th><?php echo esc_html__( 'Applicant', 'mareike' ); ?></th>
		<th></th>
	</tr>

	<?php
	foreach ( $invoices as $invoice ) {
		?>
			<tr>
				<td><?php echo esc_html( $invoice->lfd_nummer ); ?></td>
				<td><?php echo esc_html( $invoice->type ); ?></td>
				<td><?php echo esc_html( $invoice->amount ); ?></td>
				<td><?php echo esc_html( $invoice->contact_name ) . '<br />' . esc_html( $invoice->contact_email ); ?></td>
				<td>
				<?php
				if ( in_array( $invoice->status, array( 'NEW', 'NOPAYOUT' ), true ) ) {
					?>
							<a class="button"
								href="
								<?php
								echo esc_url(
									admin_url(
										'admin.php?page=' . $page .
											'&open-invoice=' . $invoice->id .
											'&back-to=' . $invoice_type
									)
								);
								?>
													">
								<?php echo esc_html__( 'Process invoice', 'mareike' ); ?></a>
							<?php
				}
				if ( 'APPROVED' === $invoice->status ) {
					?>
							<a class="button"
								href="
								<?php
								echo esc_url(
									admin_url(
										'admin.php?page=' . $page .
											'&open-invoice=' . $invoice->id .
											'&back-to=' . $invoice_type
									)
								);
								?>
													">
								<?php echo esc_html__( 'Show invoice', 'mareike' ); ?></a><br />

							<a class="button"  href="#"
								onclick="mareike_load_ajax_nw('print-invoice', 'invoice-id=<?php echo esc_html( $invoice->id ); ?>')">
								<?php echo esc_html__( 'Print invoice', 'mareike' ); ?></a><br />
						<?php
				}

				if ( in_array( $invoice->status, array( 'DENIED', 'EXPORTED' ), true ) ) {
					?>
							<a class="button"
								href="
								<?php
								echo esc_url(
									admin_url(
										'admin.php?page=' . $page .
											'&open-invoice=' . $invoice->id . '
                                                   &back-to=' . $invoice_type
									)
								);
								?>
									">
								<?php echo esc_html__( 'Show invoice', 'mareike' ); ?></a><br />
						<?php
				}
				?>
				</td>
			</tr>
			<?php
	}
	?>
</table>
<a class="button-primary mareike-back-button"  href="<?php echo esc_url( admin_url( 'admin.php?page=' . $page ) ); ?>">
	<?php echo esc_html__( 'Back', 'mareike' ); ?>
</a>
