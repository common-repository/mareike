<?php
/**
 * File textresources-form.php
 *
 * Template edit additional profile data
 *
 * @since 2024-07-17
 * @license GPL-3.0-or-later
 *
 * @package mareike/views/Settings
 */

use Mareike\App\Helpers\PageTextReplacementHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<form method="post" action="<?php echo esc_url( $page . '?page=mareike-settings&tab=tab2' ); ?>" onsubmit="return form_filled();">
<input type="hidden" name="sent" value="true" />
<table class="form-table mareike-settings">
	<?php
	foreach ( $possible_textressources as $text_ressource => $label ) {
		?>
		<tr>
			<th><label for="custom_field"><?php echo esc_html( $label ); ?></label></th>
			<td>
				<textarea
						name="<?php echo esc_html( $text_ressource ); ?>"
				><?php echo esc_textarea( PageTextReplacementHelper::get_single_text( $text_ressource ) ); ?></textarea>
			</td>
		</tr>
		<?php
	}
	?>

</table>
	<input id="mareike_Save_profile" type="submit" class="button" value="<?php echo esc_html__( 'Save changes', 'mareike' ); ?>" />
</form>
</div>
