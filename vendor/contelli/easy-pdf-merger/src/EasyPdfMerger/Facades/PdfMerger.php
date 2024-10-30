<?php namespace EasyPdfMerger\EasyPdfMerger\Facades;

use Illuminate\Support\Facades\Facade;

class PdfMerger extends Facade {
	
    protected static function getFacadeAccessor()
    {
        return 'pdf-merger';
    }
} 