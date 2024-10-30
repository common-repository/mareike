<?php
/**
 * File newitem.php
 *
 * Template to create a new cost unit
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/views/CostUnit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$user = wp_get_current_user();
?>
<div class="mareike-invoice">
	<h3>
		<?php echo esc_html__( 'Add cost center', 'mareike' ); ?>
	</h3>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=mareike-create-event' ) ); ?>"
			onsubmit="return is_costunit_complete();">
		<input type="hidden" name="costunit-type" id="costunit-type" />
		<table>
			<tr>
				<td style="width: 250px;"><?php echo esc_html__( 'Cost center name', 'mareike' ); ?>:</td>
				<td><input type="text" style="width: 450px;" id="costunit-name" name="costunit-name" /></td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'E-mail Address (for notifications)', 'mareike' ); ?>:</td>
				<td><input type="text" id="costunit-email" value="<?php echo esc_attr( $user->user_email ); ?>" name="costunit-email" style="width: 450px;"/></td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'Distance allowance', 'mareike' ); ?></td>
				<td><input type="text" id="costunit-distance" name="costunit-distance" style="width: 150px" value="0,25" />Euro / km</td>
			</tr>

			<tr>
				<td colspan="2">
					<input type="checkbox" name="notify-on-new" id="notification" />
					<label for="notification"><?php echo esc_html__( 'Notify on new invoice', 'mareike' ); ?></label>
			</tr>

			<tr id="decision">
				<td colspan="2">
					<button class="mareike-new-costunit-button" onclick="new_event();">
						<?php echo esc_html__( 'Event', 'mareike' ); ?></button>

					<button class="mareike-new-costunit-button" onclick="new_job();">
						<?php echo esc_html__( 'Job', 'mareike' ); ?></button>
				</td>
			</tr>

			<tr id="event-line-1" style="display: none;">
				<td><?php echo esc_html__( 'Event start', 'mareike' ); ?>:</td>
				<td><input style="width: 150px" type="date" id="costunit_begin" name="costunit-begin" /></td>
			</tr>

			<tr id="event-line-2" style="display: none;">
				<td><?php echo esc_html__( 'Accept invoices until', 'mareike' ); ?>:</td>
				<td><input style="width: 150px" type="date" id="costunit_end" name="costunit-end" /></td>
			</tr>

			<tr id="submit-line" style="display: none;">
				<td colspamn="2">
					<input type="submit" class="mareike-new-costunit-button"
							value="<?php echo esc_html__( 'Create cost center', 'mareike' ); ?>" />
				</td>
			</tr>
		</table>
	</form>
</div>
