<?php
/**
 * File addressdatenform.php
 *
 * Template edit additional profile data
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/views/Profile
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="mareike-invoice">

<h3><?php echo esc_html__( 'mareike', 'mareike' ); ?>
	-
	<?php echo esc_html__( 'Settings', 'mareike' ); ?></h3>
<form method="post" action="<?php echo esc_url( admin_url( 'users.php?page=mareike-profile' ) ); ?>" onsubmit="return form_filled();">
<input type="hidden" name="sent" value="true" />
<table class="form-table">
	<tr>
		<th><label for="custom_field"><?php echo esc_html__( 'First name', 'mareike' ); ?></label></th>
		<td>
			<input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $user->first_name ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><label for="custom_field"><?php echo esc_html__( 'Last name', 'mareike' ); ?></label></th>
		<td>
			<input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $user->last_name ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><label for="custom_field"><?php echo esc_html__( 'E-mail address', 'mareike' ); ?></label></th>
		<td>
			<input type="text" name="email" id="email" value="<?php echo esc_attr( $user->user_email ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><label for="custom_field"><?php echo esc_html__( 'IBAN', 'mareike' ); ?></label></th>
		<td>
			<input type="text" name="iban" id="account_iban" value="<?php echo esc_attr( get_the_author_meta( 'iban', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><label for="custom_field"><?php echo esc_html__( 'Account owner', 'mareike' ); ?></label></th>
		<td>
			<input type="text" name="account_owner" id="account_owner" value="<?php echo esc_attr( $account_owner ); ?>" class="regular-text" /><br />
		</td>
	</tr>
</table>
	<input id="mareike_Save_profile" type="submit" class="button" value="<?php echo esc_html__( 'Save changes', 'mareike' ); ?>" />
</form>
</div>
