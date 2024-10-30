<?php
/**
 * File addressdatenform.php
 *
 * Template to get personal data for a new invoice
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
<label style="font-size: 8pt;"><b><?php echo esc_html__( 'Your name', 'mareike' ); ?>
		(<?php echo esc_html__( 'No nickname', 'mareike' ); ?>):</b></label><br />
<input type="text" onkeyup="mareike_check_contact_name();" class="mareike-text" id="contact_name" name="contact_name" value="<?php echo esc_html( $name ); ?>" style="width: 550px;" /><br />

<label style="font-size: 8pt;"><b><?php echo esc_html__( 'E-mail address', 'mareike' ); ?>
		(<?php echo esc_html__( 'For clarification', 'mareike' ); ?>):</b></label><br />
<input type="text" class="mareike-text" name="contact_email" value="<?php echo esc_html( $email ); ?>" style="width: 550px;" /><br />

<span id="decision" style="display: none;">
	<label style="font-size: 8pt;">
		<b><?php echo esc_html__( 'Do you want to donate the amount?', 'mareike' ); ?></b>
	</label><br />
		<button class="mareike-button" style="border-radius: 0; width: 100px;" onclick="mareike_open_donation();"><?php echo esc_html__( 'Yes' ); ?></button class="mareike-button">
		<button class="mareike-button" style="border-radius: 0; width: 100px;" onclick="mareike_open_payment();"><?php echo esc_html__( 'No' ); ?></button class="mareike-button">
</span>

<span id="confirm_donation" style="display: none;"><br /><br />
	<input type="radio" name="confirmation_radio" value="donation" id="confirmation_radio_donation">
	<label for="confirmation_radio_donation">
	<?php
	echo nl2br( esc_textarea( PageTextReplacementHelper::get_single_text( 'CONFIRMATION_DONATE' ) ) );
	?>
	</label>
</span>

<span id="confirm_payment" style="display: none">
	<label style="font-size: 8pt;"><b><?php echo esc_html__( 'Account owner', 'mareike' ); ?>:</b></label><br />
		<input type="text" class="mareike-text" name="account_owner" id="account_owner" value="<?php echo esc_html( $account_owner ); ?>" style="width: 550px;" /><br />

	<label style="font-size: 8pt;"><b><?php echo esc_html__( 'IBAN', 'mareike' ); ?>:</b></label><br />
		<input type="text" class="mareike-text" id="account_iban" name="account_iban" value="<?php echo esc_html( $iban ); ?>" style="width: 550px;" /><br />
	<span id="final_iban_check"><br />
		<input type="radio" name="confirmation_radio" value="payment" id="confirmation_radio_payment">
			<label for="confirmation_radio_payment">
				<?php
				echo nl2br( esc_textarea( PageTextReplacementHelper::get_single_text( 'CONFIRMATION_PAYMENT' ) ) );
				?>
			</label>
	</span>
</span>

<br />
<input type="submit" class="mareike-button" id="submit_button" style="display: none;" />
