<?php
/**
 * File fahrtkostenform.php
 *
 * Template to primnt the form for travel expenses
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
	<legend><h5><?php echo esc_html__( 'Please indicate your route', 'mareike' ); ?></h5></legend>
	<input type="text" class="mareike-text" id="reiseweg" name="reiseweg" style="width: 450px;"  />
	<info-icon value="
	<?php
	echo esc_html( PageTextReplacementHelper::get_single_text( 'INFO_TOUR' ) );
	?>
	"></info-icon>
</fieldset>

<fieldset id="verkehrsmittel">
	<legend>
		<h5>
			<?php
			echo esc_html__(
				'Have you traveled by public transport or a rental car and have a receipt?',
				'mareike'
			);
			?>
			<info-icon value="
			<?php
			echo esc_html( PageTextReplacementHelper::get_single_text( 'INFO_RENTAL_CAR' ) );
			?>
			"></info-icon>
		</h5>
	</legend>

	<button class="mareike-button" style="border-radius: 0; width: 300px;" onclick="mareike_open_oeffis();"><?php echo esc_html__( 'Yes' ); ?></button class="mareike-button">
	<button class="mareike-button" style="border-radius: 0; width: 300px;" onclick="mareike_open_pkw();"><?php echo esc_html__( 'No' ); ?></button class="mareike-button">
</fieldset>



<span id="oeffis" style="display: none">
	<fieldset>
		<legend><h5><?php echo esc_html__( 'How much is the amount?', 'mareike' ); ?></h5></legend>
		<input type="text" class="mareike-text" id="oepnv_amount" name="oepnv_amount"  /> Euro
		<info-icon value="
		<?php
		echo esc_html( PageTextReplacementHelper::get_single_text( 'INFO_EXPENSE_ACCOUNTING_AMOUNT' ) );
		?>
		"></info-icon>
	</fieldset>

	<fieldset  id="oepnv_receiptButton" style="display: none;border-style: none; box-shadow: none;">
		<button class="mareike-button" onclick="document.getElementById('oepnv_receipt').click();" type="button class="mareike-button"">
			<?php echo esc_html__( 'Select receipt and continue', 'mareike' ); ?></button>
		<input accept="application/pdf"
				type="file"
				id="oepnv_receipt"
				name="oepnv_receipt"
				onchange="mareike_check_filesize('oepnv_receipt');" style="display: none"/>
	</fieldset>
</span>



<span id="pkw" style="display: none;">
	<fieldset>
		<legend><h5><?php echo esc_html__( 'Information about the trip', 'mareike' ); ?></h5></legend>
		<input type="number" name="people_in_car" value="1" style="width: 60px;"/>
			<?php echo esc_html__( 'People in your vehicle', 'mareike' ); ?>
			<info-icon value="
			<?php
			echo esc_html( PageTextReplacementHelper::get_single_text( 'INFO_PEOPLE_IN_CAR' ) );
			?>
			"></info-icon><br />
		<input type="checkbox" name="materialtransport" value="1" id="materialtransport" />
			<label for="materialtransport">
				<?php echo esc_html__( 'I transported material.', 'mareike' ); ?>
			</label>
	</fieldset>



	<fieldset>
		<legend><h5><?php echo esc_html__( 'Total distance', 'mareike' ); ?><info-icon value="
								<?php
								echo esc_html( PageTextReplacementHelper::get_single_text( 'INFO_TOTAL_DISTANCE' ) );
								?>
		"></info-icon></h5></legend>
		<input type="text" class="mareike-text" id="kilometer" name="kilometer" /> km
			(<?php echo esc_html__( 'total', 'mareike' ); ?>)<br />

		<span id="kilometer_pauschale"></span> EUR / km x
		<span id="kilometer_anzahl">0</span> km =
		<b><span id="kilometer_betrag">0</span> Euro</b>
	</fieldset>

	<fieldset id="pkw_abrechnen" style="display: none;border-style: none; box-shadow: none;">
		<button class="mareike-button" onclick="mareike_show_adressdaten();"
				type="button">
			<?php echo esc_html__( 'Bill a flat rate', 'mareike' ); ?>
		</button>
	</fieldset>
</span>
