<?php
/**
 * File: editinvoice.php
 *
 * DESCRIPTION
 *
 * @since 2024-07-18
 * @license GPL-3.0-or-later
 *
 * @package mareike/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Helpers\PageTextReplacementHelper;
use Mareike\App\Models\CostUnit;
use Mareike\App\Models\PageText;
use Mareike\App\Requests\GetMyCostUnits;

?>
<form method="post"
		action="<?php echo esc_url( admin_url( 'admin.php?page=' . $page . '&update-invoice=' . $invoice->id ) ); ?>">
	<div class="mareike-invoice mareike-edit-invoice">
		<h3>
			<?php
			echo esc_html( $cost_unit->cost_unit_name );
			?>
			-
			<?php echo esc_html__( 'Invoice number', 'mareike' ); ?> #<?php echo esc_html( $invoice->lfd_nummer ); ?>
		</h3>

		<table class="mareike-correct-invoice">
			<tr><th colspan="2"><?php echo esc_html__( 'Please enter corrected data', 'mareike' ); ?></th></tr>
			<tr>
				<th><?php echo esc_html__( 'Type of invoice', 'mareike' ); ?>:</th>
				<td>
					<select name="costtypes">
						<?php
						foreach ( $cost_types as $cost_type ) {
							?>
								<option
									value="<?php echo esc_html( $cost_type ); ?>"
								<?php
								if ( $invoice->type === $cost_type ) {
									echo esc_html( ' selected' );
								}
								?>
								>
								<?php
								switch ( $cost_type ) {
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
								</option>
								<?php
						}
						?>

				</td>
			</tr>

			<tr>
				<th><?php echo esc_html__( 'Cost center', 'mareike' ); ?>:</th>
				<td>
					<select name="costunit">
						<optgroup label="<?php echo esc_html__( 'Current jobs', 'mareike' ); ?>">

							<?php
							foreach ( GetMyCostUnits::execute( CostUnit::COST_UNIT_TYPE_JOB, true ) as $cost_unit ) {
								?>
								<option
								value="<?php echo esc_html( $cost_unit->id ); ?>"
								<?php
								if ( $cost_unit->id === $invoice->costunit_id ) {
									echo esc_html( ' selected' );
								}
								?>
								>
								<?php echo esc_html( $cost_unit->cost_unit_name ); ?>
								</option>
								<?php
							}
							?>
						</optgroup>

						<optgroup label="<?php echo esc_html__( 'Current events', 'mareike' ); ?>">

							<?php
							foreach ( GetMyCostUnits::execute( CostUnit::COST_UNIT_TYPE_EVENT, true ) as $cost_unit ) {
								?>
								<option
								value="<?php echo esc_html( $cost_unit->id ); ?>"
								<?php
								if ( $cost_unit->id === $invoice->costunit_id ) {
									echo esc_html( ' selected' );
								}
								?>
								>
								<?php echo esc_html( $cost_unit->cost_unit_name ); ?>
								</option>
								<?php
							}
							?>
						</optgroup>

						<optgroup label="<?php echo esc_html__( 'Closed events', 'mareike' ); ?>">

							<?php
							foreach ( GetMyCostUnits::execute( CostUnit::COST_UNIT_TYPE_EVENT, false ) as $cost_unit ) {
								?>
								<option
								value="<?php echo esc_html( $cost_unit->id ); ?>"
								<?php
								if ( $cost_unit->id === $invoice->costunit_id ) {
									echo esc_html( ' selected' );
								}
								?>
								>
								<?php echo esc_html( $cost_unit->cost_unit_name ); ?>
								</option>
								<?php
							}
							?>
						</optgroup>
					</select></td>
			</tr>

			<tr>
				<th><?php echo esc_html__( 'Total amount', 'mareike' ); ?>:</th>
				<td><input type="text" name="amount" id="amount" value="<?php echo esc_html( mareike_format_amount( $invoice->amount, '' ) ); ?>"> Euro</td>
			</tr>

			<tr>
				<th><?php echo esc_html__( 'Reason for correction', 'mareike' ); ?>:</th>
				<td><input type="text" name="reason" /></td>
			</tr>

			<tr>
				<td colspan="2">
					<input type="checkbox" name="copy_invoice" value="1" id="create_copy" />
					<label for="create_copy">
						<?php echo esc_html__( 'Create a copy for splitting', 'mareike' ); ?></label>
					</td>
			</tr>
		</table>

		<table class="mareike-correct-invoice">
			<tr><th colspan="2"><?php echo esc_html__( 'Personal data (Read only)', 'mareike' ); ?></th></tr>
			<tr>
				<th><?php echo esc_html__( 'Name', 'mareike' ); ?>:</th>
				<td><?php echo esc_html( $invoice->contact_name ); ?>
			</tr>

			<tr>
				<th><?php echo esc_html__( 'Invoice number', 'mareike' ); ?>:</th>
				<td><?php echo esc_html( $invoice->lfd_nummer ); ?></td>
			</tr>

			<tr><th colspan="2">
					<?php echo esc_html( PageTextReplacementHelper::get_single_text( 'CONFIRMATION_PAYMENT' ) ); ?>
				</th></tr>

			<tr>
				<th><?php echo esc_html__( 'IBAN', 'mareike' ); ?>:</th>
				<td><?php echo esc_html( $invoice->contact_bank_iban ); ?></td>
			</tr>

			<tr>
				<th><?php echo esc_html__( 'Account owner', 'mareike' ); ?>:</th>
				<td><?php echo esc_html( $invoice->contact_bank_owner ); ?></td>
			</tr>
		</table>

		<input type="submit"
				class="button mareike-accept-button"
				value="<?php echo esc_html__( 'Save and confirm', 'mareike' ); ?>" />
		<br /><br />



</form>
