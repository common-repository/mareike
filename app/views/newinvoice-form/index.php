<?php
/**
 * File index.php
 *
 * Main template for new invoices, includes sub templates
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

<form method="post" action="#" enctype="multipart/form-data" onsubmit="return mareike_is_all_filled();">
    <h1>
        <?php
            echo esc_html__('Add new invoice', 'mareike');
        ?>
    </h1>
	<input type="hidden" id="mareike-nonce" name="mareike_nonce" value="<?php echo esc_html( wp_create_nonce() ); ?>" />
	<input type="hidden" name="sent" value="true" />

    <div id="mareike-new-invoice-main-description">
        <?php
        echo nl2br( esc_textarea( PageTextReplacementHelper::get_single_text( 'INFO_NEW_INVOICE' ) ) );
        ?>
    </div>

	<div id="mareike_new_invoice_index_table">

		<div class="" onclick="mareike_select_event('auslagenform');" class="mareike-div-selector">
			<h3><?php echo esc_html__( 'Expense accounting', 'mareike' ); ?></h3>
			<?php
			echo nl2br( esc_textarea( PageTextReplacementHelper::get_single_text( 'INFO_EXPENSE_ACCOUNTING' ) ) );
			?>
		</div>
		<div class=""   onclick="mareike_select_event('fahrtkostenform');" class="mareike-div-selector">
			<h3><?php echo esc_html__( 'Travel expense accounting', 'mareike' ); ?></h3>
			<?php
			echo nl2br( esc_textarea( PageTextReplacementHelper::get_single_text( 'INFO_TRAVEL_EXPENSE_ACCOUNTING' ) ) );
			?>
		</div>
	</div>


	<div id="eventauswahl">
		<div id="eventdaten_header">
			<span id="eventdaten_header_text"><?php echo esc_html__( 'Sekect event', 'mareike' ); ?></span>
			<span onclick="mareike_print_screen()" id="eventdaten_close" class="dashicons dashicons-dismiss"></span>
		</div>
		<div id="eventdaten_content">
			<label style="display: none" id="modus"></label>
			<select class="mareike-select" id="veranstaltung" name="veranstaltung" style="width: 400px;">
				<optgroup label="<?php echo esc_html__( 'Current jobs', 'mareike' ); ?>">
					<?php
					foreach ( $jobs as $event ) {
						?>
						<option value="<?php echo esc_html( $event->id ); ?>"><?php echo esc_html( $event->cost_unit_name ); ?></option>
						<?php

					}
					?>
				</optgroup>

				<optgroup label="<?php echo esc_html__( 'Current events', 'mareike' ); ?>">
				<?php
				foreach ( $events as $event ) {
					?>
					<option value="<?php echo esc_html( $event->id ); ?>"><?php echo esc_html( $event->cost_unit_name ); ?></option>
					<?php

				}
				?>
				</optgroup>
			</select>
			<button class="mareike-button" onclick="mareike_nextpage(document.getElementById('modus').innerHTML);">
				<?php echo esc_html__( 'Continue', 'mareike' ); ?>
			</button>
		</div>
	</div>

    <div id="addressdaten">
        <div id="addressdaten_header">
            <span id="addressdaten_header_text">Bitte gib noch deine Daten ein</span>
            <span onclick="mareike_print_screen()" id="addressdaten_close" class="dashicons dashicons-dismiss"></span>
        </div>
        <div id="addressdaten_content">
            <?php
            require __DIR__ . '/addressdatenform.php';
            ?>
        </div>
    </div>

    <div id="fahrtkostenform">
        <?php
        require __DIR__ . '/fahrtkostenform.php';
        ?>
    </div>

    <div id="hider" onclick="mareike_print_screen();"></div>

    <div id="auslagenform">
        <?php
        require __DIR__ . '/auslagenform.php';
        ?>
    </div>
</form>
