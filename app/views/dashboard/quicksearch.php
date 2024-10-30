<?php
/**
 * File: quicksearch.php
 *
 * Contains a quick search bar
 *
 * @since 2024-07-18
 * @license GPL-3.0-or-later
 *
 * @package mareike/Dashboard/Views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;
use Mareike\App\Requests\GetMyCostUnits;
?>

<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=mareike-get-invoice' ) ); ?>">
	<input type="hidden" name="search" value="true" />
	<table class="mareike-quick-search">
		<tr>
			<td>
				<?php echo esc_html__( 'Invoice quick search', 'mareike' ); ?>
			</td>
			<td></td>
			<td><?php echo esc_html__( 'Cost center', 'mareike' ); ?></td>
			<td>
				<select name="event">
					<optgroup label="<?php echo esc_html__( 'Current jobs', 'mareike' ); ?>">

					<?php
					foreach ( GetMyCostUnits::execute( CostUnit::COST_UNIT_TYPE_JOB, true ) as $cost_unit ) {
						?>
							<option value="<?php echo esc_html( $cost_unit->id ); ?>">
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
						<option value="<?php echo esc_html( $cost_unit->id ); ?>">
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
							<option value="<?php echo esc_html( $cost_unit->id ); ?>">
							<?php echo esc_html( $cost_unit->cost_unit_name ); ?>
							</option>
							<?php
						}
						?>
					</optgroup>
				</select>
			</td
			<td></td>
			<td><?php echo esc_html__( 'Invoice number', 'mareike' ); ?> </td>
			<td><input name="continuous_cost_number" type="number"></td>
			<td><input type="submit" class="button" value="<?php echo esc_html__( 'Search' ); ?>"></td>
		</tr>
	</table>
</form>

