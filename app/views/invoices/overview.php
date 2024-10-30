<?php
/**
 * File overview.php
 *
 * Template to display an invoice
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/views/Invoices
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Helpers\PageTextReplacementHelper;
?>
<div class="mareike-invoice">
	<h3>
		<?php
		echo esc_html( $cost_unit->cost_unit_name );
		?>
		-
		<?php echo esc_html__( 'Invoice number', 'mareike' ); ?> #<?php echo esc_html( $invoice->lfd_nummer ); ?></h3>
	<table>
		<tr>
			<td><?php echo esc_html__( 'Name', 'mareike' ); ?></td>
			<td><?php echo esc_html( $invoice->contact_name ); ?></td>
		</tr>

		<tr>
			<td><?php echo esc_html__( 'E-mail address', 'mareike' ); ?></td>
			<td><?php echo esc_html( $invoice->contact_email ); ?></td>
		</tr>

		<tr>
			<td><?php echo esc_html__( 'Cost center', 'mareike' ); ?></td>
			<td><?php echo esc_html( $cost_unit->cost_unit_name ); ?></td>
		</tr>

		<tr>
			<td><?php echo esc_html__( 'Invoice number', 'mareike' ); ?>:</td>
			<td><?php echo esc_html( $invoice->lfd_nummer ); ?></td>
		</tr>

		<tr>
			<td><?php echo esc_html__( 'Type of invoice', 'mareike' ); ?>:</td>
			<td>
			<?php
			switch ( $invoice->type ) {
				case 'Travelling':
					echo esc_html__( 'Travelling', 'mareike' );
					break;

				case 'Program':
					echo esc_html__( 'Program', 'mareike' );
					break;

				case 'Other':
					echo esc_html__( 'Other', 'mareike' );
					break;

				case 'Accommodation':
					echo esc_html__( 'Accommodation', 'mareike' );
					break;

				case 'Catering':
					echo esc_html__( 'Catering', 'mareike' );
					break;
			}
			?>
			</td>
		</tr>

		<?php
		if ( 'Travelling' === $invoice->type && 0 <= $invoice->distance ) {
			?>
			<tr>
				<td><?php echo esc_html__( 'Tour', 'mareike' ); ?>:</td>
				<td><?php echo esc_html( $invoice->travel_direction ); ?></td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'Passengers', 'mareike' ); ?>:</td>
				<td><?php echo esc_html( $invoice->people_in_car ); ?></td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'Material transportation', 'mareike' ); ?>:</td>
				<td><?php echo $invoice->material ? esc_html__( 'Yes' ) : esc_html__( 'No' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Distance', 'mareike' ); ?>:</td>
				<td><?php echo esc_html( $invoice->distance ); ?> km x <?php echo esc_html( $cost_unit->distance_allowance ); ?> Euro / km</td>
			</tr>
			<?php
		} else {
			?>
			<tr>
				<td><?php echo esc_html__( 'Expenses', 'mareike' ); ?>:</td>
				<td><?php echo esc_html( mareike_format_amount( $invoice->amount ) ); ?> </td>
			</tr>
			<?php
		}
		?>

		<tr>
			<td><?php echo esc_html__( 'Total amount', 'mareike' ); ?>:</td>
			<td><?php echo esc_html( mareike_format_amount( $invoice->amount ) ); ?></td>
		</tr>

		<?php
		if ( 'DENIED' === $invoice->status ) {
			?>
			<tr style="vertical-align: top;">
				<td><?php echo esc_html__( 'Reason for deny', 'mareike' ); ?>:</td>
				<td><?php echo nl2br( esc_textarea( $invoice->denied_reason ) ); ?></td>
				</td>
			</tr>
			<?php
		}

		if ( 'NOPAYOUT' !== $invoice->status && 'NOPAYOUT' !== $invoice->comment ) {

			?>
			<tr>
				<td colspan=2 style="font-weight: bold;">
					<?php echo nl2br( esc_textarea( PageTextReplacementHelper::get_single_text( 'CONFIRMATION_PAYMENT' ) ) ); ?>
				</td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'Account owner', 'mareike' ); ?>:</td>
				<td><?php echo esc_html( $invoice->contact_bank_owner ); ?>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'IBAN', 'mareike' ); ?>:</td>
				<td><?php echo esc_html( $invoice->contact_bank_iban ); ?>
			</tr>

			<?php
		} else {
			?>
			<tr>
				<td colspan=2 style="font-weight: bold;">
					<?php echo nl2br( esc_textarea( PageTextReplacementHelper::get_single_text( 'CONFIRMATION_DONATE' ) ) ); ?>
				</td>
			</tr>
			<?php
		}
		?>
	</table>
</div>
<div class="mareike-button-bar">
	<?php
	if ( 'no-return' !== $overview ) {
		?>
		<a href="
			<?php
			echo esc_url(
				admin_url(
					'admin.php?page=' . $page .
					'&show=' . $overview .
					'&display-cost-unit=' . $cost_unit->id
				)
			);
			?>
											" class="button">
			<?php echo esc_html__( 'Back', 'mareike' ); ?></a>
		<?php
	}
	if ( null !== $invoice->document_filename ) {
		?>
		<a href="#" onclick="mareike_load_invoice(<?php echo esc_html( $invoice->id ); ?>);" class="button">
			<?php echo esc_html__( 'Show receipt', 'mareike' ); ?></a>
		<?php
	}

	if ( 'NEW' === $invoice->status ) {
		?>
		<a href="
			<?php
			echo esc_url(
				admin_url(
					'admin.php?page=' . $page .
					'&show=' . $overview .
					'&accept-invoice=' . $invoice->id
				)
			);
			?>
											"
			class="button mareike-accept-button">
			<?php echo esc_html__( 'Confirm and print', 'mareike' ); ?>
		</a>

		<a href="#" onclick="mareike_display_deny_invoice_dialog();" class="button mareike-deny-button">
			<?php echo esc_html__( 'Deny request', 'mareike' ); ?>
		</a>

		<a href="
		<?php
		echo esc_url(
			admin_url(
				'admin.php?page=' . $page .
				'&show=' . $overview .
				'&copy-and-deny=' . $invoice->id
			)
		);
		?>
		" class="button"><?php echo esc_html__( 'Deny and correct request', 'mareike' ); ?></a>
		<?php
	}

	if ( 'NOPAYOUT' === $invoice->status ) {
		?>
		<a href="#" onclick="mareike_print_invoice(<?php echo esc_html( $invoice->id ); ?>);"
			class="button mareike-accept-button">
			<?php echo esc_html__( 'Print invoice', 'mareike' ); ?>
		</a>

		<a href="#" onclick="mareike_display_deny_invoice_dialog();" class="button mareike-deny-button">
			<?php echo esc_html__( 'Deny request', 'mareike' ); ?>
		</a>
		<?php
	}

	if ( 'APPROVED' === $invoice->status || 'EXPORTED' === $invoice->status ) {
		?>
		<a href="#" onclick="mareike_print_invoice(<?php echo esc_html( $invoice->id ); ?>);" class="button">
			<?php echo esc_html__( 'Print invoice', 'mareike' ); ?>
		</a>
		<?php
	}

	if ( 'DENIED' === $invoice->status ) {
		?>
		<a href="
		<?php
		echo esc_url(
			admin_url(
				'admin.php?page=' . $page .
				'&show=' . $overview .
				'&reopen-invoice=' . $invoice->id
			)
		);
		?>
										" class="button mareike-accept-button">
			<?php echo esc_html__( 'For resubmission', 'mareike' ); ?>
		</a>
		<?php
	}
	?>
</div>

<?php
require 'denyinvoice.php';
?>

<div id="hider" onclick="mareike_printscreen();"></div>
