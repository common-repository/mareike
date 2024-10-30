<?php
/**
 * File settings-form.php
 *
 * Template edit additional profile data
 *
 * @since 2024-07-17
 * @license GPL-3.0-or-later
 *
 * @package mareike/views/Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( 'You are not allowed to edit these settings.' );
}
?>



<form method="post" action="<?php echo esc_url( $page . '?page=mareike-settings&tab=tab1' ); ?>" onsubmit="return mareike_settings_form_filled();">
	<input type="hidden" name="sent" value="true" />
	<table class="form-table">
		<tr>
			<th><label for="custom_field"><?php echo esc_html__( 'Receipt directory', 'mareike' ); ?></label></th>
			<td>
				<input type="text" name="receipt_directory" value="<?php echo esc_attr( $receipt_directory ); ?>" class="regular-text" /><br />
			</td>
		</tr>
	</table>
	<input id="mareike_Save_profile" type="submit" class="button" value="<?php echo esc_html__( 'Save changes', 'mareike' ); ?>" />
	</form>
</div>