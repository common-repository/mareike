<?php
/**
 * File tab-header.php
 *
 * DESCRIPTION
 *
 * @since 2024-07-17
 * @license GPL-3.0-or-later
 *
 * @package mareike/Views/settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wrap">
	<hr class="wp-header-end">

	<h3><?php echo esc_html__( 'mareike settings', 'mareike' ); ?></h3>

	<h2 class="nav-tab-wrapper" >
			<a
					href="<?php echo esc_url( $page . '?page=mareike-settings&tab=tab2' ); ?>"
					class="nav-tab <?php echo 'tab2' === $active_tab ? esc_html( 'nav-tab-active' ) : ''; ?> "
			>
				<?php echo esc_html__( 'Text resources', 'mareike' ); ?>
			</a>

		<?php
		if ( current_user_can( 'manage_options' ) ) {
			?>
				<a
						href="<?php echo esc_url( $page . '?page=mareike-settings&tab=tab1' ); ?>"
						class="nav-tab <?php echo 'tab1' === $active_tab ? esc_html( 'nav-tab-active' ) : ''; ?> "
				>
					<?php echo esc_html__( 'Options', 'mareike' ); ?>
				</a>
			<?php } ?>
	</h2>
	<div class="tab-content">
