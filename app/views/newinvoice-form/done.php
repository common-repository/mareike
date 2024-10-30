<?php
/**
 * File done.php
 *
 * Template to display that an invoice was created
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/views/Invoices
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<h2><?php echo esc_html__( 'Invoice successfully created', 'mareike' ); ?></h2>
<?php echo esc_html__( 'Your cost statement has been saved successfully.', 'mareike' ); ?><br />
<?php echo esc_html__( 'If there are no queries, you will receive the amount promptly transferred to your specified bank account.', 'mareike' ); ?><br />
<?php
echo esc_html__( 'If you have marked this as a donation, we thank you in advance!', 'mareike' );
