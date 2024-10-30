<?php
/**
 * File listitems.php
 *
 * Template to display cost units
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/views/CostUnit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Controllers\CostUnit\ListItemsController;
use Mareike\App\Controllers\Invoices\InvoiceListForCostUnit;
?>
<h2><?php echo esc_html( $display_type ); ?></h2>

<table class="wp-list-table widefat fixed striped table-view-list mareike-table">
	<tr>
		<th><?php echo esc_html__( 'Event name', 'mareike' ); ?></th>
		<th><?php echo esc_html__( 'Open invoices', 'mareike' ); ?></th>
		<th><?php echo esc_html__( 'Actions', 'mareike' ); ?></th>
	</tr>
	<?php
	foreach ( $events as $event ) {
		?>
			<tr>
				<td>
					<span style="font-weight: bold">
					<?php
					if ( in_array(
						$mareike_event_mode,
						array(
							ListItemsController::OPEN_EVENTS,
							ListItemsController::JOBS,
						),
						true
					) ) {
						?>
								<a href="
								<?php
								echo esc_url( admin_url( 'admin.php?page=' . $page . '&edit-cost-unit=' . $event->id ) );
								?>
									">
							<?php } ?>
						<?php
						echo esc_html( $event->cost_unit_name );
						if ( in_array(
							$mareike_event_mode,
							array(
								ListItemsController::OPEN_EVENTS,
								ListItemsController::JOBS,
							),
							true
						) ) {
							?>
								</a>
							<?php } ?>
					</span><br />
					<?php echo esc_html__( 'Total costs', 'mareike' ); ?>:
						<?php echo esc_html( mareike_format_amount( $event->total_amount ) ); ?>
					<br />
					<?php echo esc_html__( 'Donations', 'mareike' ); ?>:
					<?php echo esc_html( mareike_format_amount( $event->donated_amount ) ); ?>
					<br />
				</td>
				<td>
					<?php
					if ( ListItemsController::ARCHIVED_EVENTS !== $mareike_event_mode ) {
						?>
							<a  href="
							<?php
							echo esc_url(
								admin_url(
									'admin.php?page=' . $page . '&show=' .
									InvoiceListForCostUnit::NEW_INVOICE .
									'&display-cost-unit=' . $event->id
								)
							);
							?>
							">
								<?php echo esc_html__( 'Unprocessed', 'mareike' ); ?>: <?php echo esc_html( $event->open_invoice_count ); ?>
								<span class="dashicons dashicons-share-alt2"></span>
							</a><br />

							<a href="
							<?php
							echo esc_url(
								admin_url(
									'admin.php?page=' . $page . '&show=' .
									InvoiceListForCostUnit::ACCEPTED_INVOICE .
									'&display-cost-unit=' . $event->id
								)
							);
							?>
							">
								<?php echo esc_html__( 'Unexported', 'mareike' ); ?>: <?php echo esc_html( $event->unexported_invoice_count ); ?>
								<span class="dashicons dashicons-share-alt2"></span>
							</a><br />

							<a href="
							<?php
							echo esc_url(
								admin_url(
									'admin.php?page=' . $page . '&show=' .
									InvoiceListForCostUnit::NOPAYOUT_INVOICE .
									'&display-cost-unit=' . $event->id
								)
							);
							?>
							">
								<?php echo esc_html__( 'Without payout', 'mareike' ); ?>: <?php echo esc_html( $event->nopayout_invoice_count ); ?>
								<span class="dashicons dashicons-share-alt2"></span>
							</a><br />

							<a href="
							<?php
							echo esc_url(
								admin_url(
									'admin.php?page=' . $page . '&show=' .
									InvoiceListForCostUnit::DENIED_INVOICE .
									'&display-cost-unit=' . $event->id
								)
							);
							?>
							">
								<?php echo esc_html__( 'Denied', 'mareike' ); ?>: <?php echo esc_html( $event->denied_invoice_count ); ?>
								<span class="dashicons dashicons-share-alt2"></span>
							</a>
							<?php
					}
					?>
				</td>

				<td>
					<?php
					switch ( $mareike_event_mode ) {
						case ListItemsController::OPEN_EVENTS:
							?>
								<a class="button mareike-event-action-button mareike-deny-button" href="
								<?php
								echo esc_url( admin_url( 'admin.php?page=' . $page . '&close-cost-unit=' . $event->id ) );
								?>
								">
									<?php echo esc_html__( 'Deny new requests', 'mareike' ); ?></a>
								<?php
							break;

						case ListItemsController::CLOSED_EVENTS:
							?>
								<a class="button mareike-event-action-button mareike-accept-button"
									onclick="mareike_load_ajax_nw('export-invoices', 'costunit-id=' + <?php echo esc_html( $event->id ); ?>)">
								<?php echo esc_html__( 'Export payouts', 'mareike' ); ?></a><br />

								<a class="button mareike-event-action-button" href="
								<?php
								echo esc_url(
									admin_url(
										'admin.php?page=' . $page .
											'&show=' . InvoiceListForCostUnit::EXPORTED_INVOICE .
											'&display-cost-unit=' . $event->id
									)
								);
								?>
																					">
									<?php echo esc_html__( 'Exported invoicess', 'mareike' ); ?></a><br />



								<a class="button mareike-event-action-button mareike-allow-button"
									href="
									<?php
									echo esc_url(
										admin_url(
											'admin.php?page=' . $page .
															'&reopen-cost-unit=' . $event->id
										)
									);
									?>
											">

									<?php echo esc_html__( 'Allow new requests', 'mareike' ); ?></a><br />

								<a class="button mareike-event-action-button mareike-allow-button mareike-deny-button"
									href="
									<?php
									echo esc_url(
										admin_url(
											'admin.php?page=' . $page .
															'&archive-cost-unit=' . $event->id
										)
									);
									?>
											">
									<?php echo esc_html__( 'Archive', 'mareike' ); ?></a><br />
								<?php
							break;

						case ListItemsController::ARCHIVED_EVENTS:
							?>
								<a class="button mareike-event-action-button"
									href="
									<?php
									echo esc_url(
										admin_url(
											'admin.php?page=' . $page .
													'&show=' . InvoiceListForCostUnit::EXPORTED_INVOICE .
													'&display-cost-unit=' . $event->id
										)
									);
									?>
											">
									<?php echo esc_html__( 'Exported invoicess', 'mareike' ); ?></a><br />
								<?php
							break;

						case ListItemsController::JOBS:
							?>
								<a class="button mareike-event-action-button mareike-accept-button"
									onclick="mareike_load_ajax_nw('export-invoices', 'mareike_nonce=<?php echo esc_html( $nonce ); ?>&costunit-id=' + <?php echo esc_html( $event->id ); ?>)">
								<?php echo esc_html__( 'Export payouts', 'mareike' ); ?></a><br />

								<a class="button mareike-event-action-button"
									href="
									<?php
									echo esc_url(
										admin_url(
											'admin.php?page=' . $page .
															'&show=' . InvoiceListForCostUnit::EXPORTED_INVOICE .
															'&display-cost-unit=' . $event->id
										)
									);
									?>
											">
									<?php echo esc_html__( 'Exported invoicess', 'mareike' ); ?></a><br />

								<a class="button mareike-event-action-button mareike-allow-button mareike-deny-button"
									href="
									<?php
									echo esc_url(
										admin_url(
											'admin.php?page=' . $page .
															'&archive-cost-unit=' . $event->id
										)
									);
									?>
											">
									<?php echo esc_html__( 'Archive', 'mareike' ); ?></a><br />
								<?php
							break;
					}
					?>
				</td>
			</tr>
			<?php
	}
	?>
</table>
