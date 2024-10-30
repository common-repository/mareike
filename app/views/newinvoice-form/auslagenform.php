<?php
/**
 * File auslagenform.php
 *
 * Template to print the form for expenses
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

<fieldset>
	<legend><h3 style="margin-top: 80px; width: 300px;"><?php echo esc_html__( 'What did you pay for?', 'mareike' ); ?></h3></legend>
	<input type="radio" name="kostengruppe" value="Accommodation" id="kosten_unterkunft">
	<label for="kosten_unterkunft"><?php echo esc_html__( 'Accommodation', 'mareike' ); ?></label>
	<info-icon value="
		<?php
		echo esc_html( PageTextReplacementHelper::get_single_text( 'INFO_ACCOMMODATION' ) );
		?>
		"></info-icon><br />

	<input type="radio" name="kostengruppe" value="Catering" id="kosten_verpflegung">
	<label for="kosten_verpflegung"><?php echo esc_html__( 'Catering', 'mareike' ); ?></label>
	<info-icon value="
		<?php
		echo esc_html( PageTextReplacementHelper::get_single_text( 'INFO_CATERING' ) );
		?>
		"></info-icon><br />

	<input type="radio" name="kostengruppe" value="Program" id="kosten_programm">
	<label for="kosten_programm"><?php echo esc_html__( 'Program', 'mareike' ); ?></label>
	<info-icon value="
		<?php
		echo esc_html( PageTextReplacementHelper::get_single_text( 'INFO_PROGRAM' ) );
		?>
		"></info-icon><br />

	<input type="radio" name="kostengruppe" value="Other" id="kosten_sonstiges">
	<label for="kosten_sonstiges">
		<input type="text" class="mareike-text"
				name="kostengruppe_sonstiges"
				placeholder="<?php echo esc_html__( 'Other', 'mareike' ); ?>"
				for="kosten_sonstiges" />
		<info-icon value="
			<?php
			echo esc_html( PageTextReplacementHelper::get_single_text( 'INFO_OTHER' ) );
			?>
			"></info-icon><br />
	</label>

</fieldset>

<fieldset>
	<legend><h3 style="margin-top: 80px; width: 300px;"><?php echo esc_html__( 'How much is the amount?', 'mareike' ); ?></h3></legend>
	<input type="text" class="mareike-text" id="amount" name="amount"  /> Euro
	<info-icon value="
	<?php
	echo esc_html( PageTextReplacementHelper::get_single_text( 'INFO_EXPENSE_ACCOUNTING_AMOUNT' ) );
	?>
	"></info-icon>
</fieldset>

<fieldset class="mareike-auslagen" id="receiptButton" style="display: none;border-style: none; box-shadow: none;">
	<button class="mareike-button"
			onclick="document.getElementById('receipt').click();"
			type="button">
		<?php echo esc_html__( 'Select receipt and continue', 'mareike' ); ?>
	</button>
	<input accept="application/pdf" type="file" id="receipt" name="receipt" onchange="mareike_check_filesize('receipt');" style="display: none"/>
</fieldset>
</div>
