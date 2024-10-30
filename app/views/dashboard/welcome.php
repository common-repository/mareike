<?php
/**
 * File: welcome.php
 *
 * Contains welcome text for out plugin
 *
 * @since 2024-07-18
 * @license GPL-3.0-or-later
 *
 * @package mareike/Dashboard/Views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="mareike-invoice">
<h3>
	mareike
</h3>

<div class="mareike-welcome">

	<h4><?php echo esc_html__( 'Welcome to our Plugin!', 'mareike' ); ?></h4>
	<h5><?php echo esc_html__( 'Problem faced by many associations', 'mareike' ); ?></h5>

	<p><?php echo esc_html__( 'Many associations know the problem: Whenever they organize an event, members have to pay for stuff and want to get their money back.', 'mareike' ); ?></p>

	<h5><?php echo esc_html__( 'The Solution', 'mareike' ); ?></h5>

	<p><?php echo esc_html__( 'This tool helps by adding invoices or registering travel costs and also helps to create bank CSV data.', 'mareike' ); ?></p>

	<h5><?php echo esc_html__( 'Features', 'mareike' ); ?></h5>
	<ul>
		<li><b><?php echo esc_html__( 'Add invoices:', 'mareike' ); ?></b> <?php echo esc_html__( 'Record and manage all incurred invoices.', 'mareike' ); ?></li>
		<li><b><?php echo esc_html__( 'Register travel costs:', 'mareike' ); ?></b> <?php echo esc_html__( 'Document and manage all travel costs.', 'mareike' ); ?></li>
		<li><b><?php echo esc_html__( 'Create bank CSV data:', 'mareike' ); ?></b> <?php echo esc_html__( 'Generate the required CSV files for bank transfers.', 'mareike' ); ?></li>
		<li><b><?php echo esc_html__( 'Download invoices as PDF:', 'mareike' ); ?></b> <?php echo esc_html__( 'As a treasurer, you can easily download all invoices as PDF files.', 'mareike' ); ?></li>
	</ul>

	<h5><?php echo esc_html__( 'Note', 'mareike' ); ?></h5>

	<p><?php echo esc_html__( 'This tool was created for German legal purposes, so keep in mind that you have to modify the settings if you use it in another country.', 'mareike' ); ?></p>

</div>
<hr />
<div class="mareike-welcome">
	<?php echo esc_html__( 'We wish you much success in using our plugin and look forward to your feedback!', 'mareike' ); ?>
</div>
</div>
