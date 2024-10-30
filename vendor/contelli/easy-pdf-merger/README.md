# lara-pdf-merger

Drop-in replacement for the original package from [deltaaskii/lara-pdf-merger](https://github.com/deltaaskii/lara-pdf-merger) that was updated to work under *PHP 8.2 and above*

Original written by http://pdfmerger.codeplex.com/team/view

This fork ist built to work outside laravel projects.

### Improvements 

* Code polishing for PHP 8 compatibility
* Code source refactoring
* Enabling the Facade use
* Adding duplex merge feature
* Seperate save operation from the merge
  
## Installation

* Require this package in your composer.json by adding those lines

```
composer require contelli/easy-pdf-merger
```

* Run  this commend in your terminal
```bash
composer update
``
## Usage

```php

require_once 'src/EasyPdfMerger/PdfManage.php';

use EasyPdfMerger\EasyPdfMerger\PdfManage as PDFMerger;

//...

$pdfMerger = new PDFMerger(); //Initialize the merger

$pdfMerger->addPDF('samplepdfs/one.pdf', '1, 3, 4');
$pdfMerger->addPDF('samplepdfs/two.pdf', '1-2');
$pdfMerger->addPDF('samplepdfs/three.pdf', 'all');

//You can optionally specify a different orientation for each PDF
$pdfMerger->addPDF('samplepdfs/one.pdf', '1, 3, 4', 'L');
$pdfMerger->addPDF('samplepdfs/two.pdf', '1-2', 'P');

$pdfMerger->merge(); //For a normal merge (No blank page added)

// OR..
$pdfMerger->duplexMerge(); //Merges your provided PDFs and adds blank pages between documents as needed to allow duplex printing

// optional parameter can be passed to the merge functions for orientation (P for protrait, L for Landscape). 
// This will be used for every PDF that doesn't have an orientation specified

$pdfMerger->save("file_path.pdf");

// OR...
$pdfMerger->save("file_name.pdf", "download");
// REPLACE 'download' WITH 'browser', 'download', 'string', or 'file' for output options

```

## Authors
* [TiDschi](https://github.com/TiDschi)
* [RamonSmit](https://github.com/RamonSmit)
* [MarwenSami](https://github.com/MarwenSami)


## Credits
* **deltaaskii** [deltaaskii/lara-pdf-merger](https://github.com/deltaaskii/lara-pdf-merger)
* **DALTCORE** [DALTCORE/lara-pdf-merger](https://github.com/DALTCORE/lara-pdf-merger)
* **Contelli** [contelli/easy-pdf-merger](https://github.com/TiDschi/pdf-merger)
