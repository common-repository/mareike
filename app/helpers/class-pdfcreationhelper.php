<?php
/**
 * File: class-pdfcreationhelper.php
 *
 * Helper library: Generates PDF documents from rendered HTML pages
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Libs
 */

namespace Mareike\App\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Dompdf\Dompdf;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use EasyPdfMerger\EasyPdfMerger\PdfManage as PDFMerger;
use Mareike\FileAccess;
use ZipStream\ZipStream;
use Illuminate\Filesystem\Filesystem;

/**
 *  Helper library: Generates PDF documents from rendered HTML pages
 */
class PdfCreationHelper {

	public const ORIENTATION_PORTAIT = 'portrait';
	public const
		ORIENTATION_LANDSCAPE        = 'landscape';

	/**
	 * Creates and downloads a PDF of the invoice, and if existing, it appends the receipt
	 *
	 * @param string      $input The preparsed PDF value.
	 * @param int         $lfd_number The identifier of the invoice coressponding the cost unit.
	 * @param string|null $receipt The filename of the receipt if existing.
	 *
	 * @return string
	 */
	public static function create_abrechnung_pdf( string $input, int $lfd_number, ?string $receipt = null ): string {
		$filename = $lfd_number . '.pdf';
		if ( null === $receipt ) {
			self::execute_command( $input, self::ORIENTATION_PORTAIT, $filename, true );
			exit;
		}

		$token    = wp_rand( 100000, 999999 );
		$pdf_data = self::execute_command( $input, self::ORIENTATION_PORTAIT, $filename, false );

		$dir         = __DIR__ . '/';
		$file_access = new FileAccess();
		$file_access->put_contents( $dir . 'tmp-' . $token . '.pdf', $pdf_data, MAREIKE_WP_FS_CHMOD_FILE );
		try {
            $pdfMerger = new PDFMerger();
            $pdfMerger->addPDF($dir . 'tmp-' . $token . '.pdf');
            $pdfMerger->addPDF($receipt);

            $pdfMerger->merge();
            if ($pdfMerger->save($dir . $filename)) {
                return $dir . $filename;
            }
		} catch ( CrossReferenceException $e ) {
			$output = $filename . '.zip';
			$zip    = new ZipStream(
				outputName: $filename . '.zip',
				sendHttpHeaders: true,
			);

			$zip->addFileFromPath(
				$filename . '_antrag.pdf',
				$dir . 'tmp-' . $token . '.pdf'
			);

			$zip->addFileFromPath(
				$filename . '_beleg.pdf',
				$receipt
			);

			$zip->finish();
		} finally {
			wp_delete_file( $dir . 'tmp-' . $token . '.pdf' );
		}

		return $output;
	}

	/**
	 * Internal function: Creates the pdf content
	 *
	 * @param string $htmlfile Content to convert.
	 * @param string $orientation Orientation odf the document.
	 * @param string $filename Target filename.
	 * @param bool   $download Switch for direct download or save on filesystem.
	 *
	 * @return string|void|null
	 */
	public static function execute_command( string $htmlfile, string $orientation, string $filename, bool $download = true ) {

		$dompdf = new Dompdf();
		$dompdf->loadHtml( $htmlfile, 'UTF-8' );
		$dompdf->setPaper( 'A4', $orientation );

		$dompdf->render();
		if ( ! $download ) {
			return $dompdf->output();
		}
		$dompdf->stream( $filename );
	}
}
