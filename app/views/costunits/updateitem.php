<?php
/**
 * File updateitem.php
 *
 * Template to update a cost unit
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/views/CostUnit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;
?>

<div class="mareike-invoice">
	<h3><?php echo esc_html__( 'Edit cost center', 'mareike' ); ?></h3>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=' . $page . '&update-cost-unit=' . $cost_unit->id ) ); ?>">
		<table>
			<tr>
				<td style="width: 250px;"><?php echo esc_html__( 'Cost center name', 'mareike' ); ?>:</td>
				<td><input type="text" style="width: 450px;" id="costunit-name" value="<?php echo esc_html( $cost_unit->cost_unit_name ); ?>" name="costunit-name" /></td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'E-mail Address (for notifications)', 'mareike' ); ?>:</td>
				<td><input type="text" id="costunit-email"  value="<?php echo esc_html( $cost_unit->contact_email ); ?>" name="costunit-email" style="width: 450px;"/></td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'Distance allowance', 'mareike' ); ?></td>
				<td><?php echo esc_html( mareike_format_amount( $cost_unit->distance_allowance ) ); ?> Euro / km</td>
			</tr>

			<tr>
				<td colspan="2">
					<input type="checkbox" name="notify-on-new" id="notification"
					<?php echo $cost_unit->mail_on_new ? esc_html( ' checked' ) : esc_html( '' ); ?>/>
					<label for="notification"><?php echo esc_html__( 'Notify on new invoice', 'mareike' ); ?></label>
			</tr>

			<?php
			if ( CostUnit::COST_UNIT_TYPE_EVENT === (int) $cost_unit->cost_unit_type ) {
				?>
					<tr id="event-line-2">
						<td><?php echo esc_html__( 'Accept invoices until', 'mareike' ); ?>:</td>
						<td><input style="width: 150px" type="date" id="costunit_end" name="costunit-end" value="<?php echo esc_html( $cost_unit->billing_deadline ); ?>" /></td>
					</tr>
					<?php
			}
			?>
			

			<tr>
				<td colspamn="2">
					<input type="submit" class="mareike-new-costunit-button"
							value="<?php echo esc_html__( 'Save changes', 'mareike' ); ?>" />
				</td>
			</tr>
		</table>
	</form>
</div>
