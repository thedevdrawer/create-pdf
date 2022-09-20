<?php
/**
 * Tutorial uses MPDF. You can find more information here: https://mpdf.github.io/
 * run "composer require mpdf/mpdf" to install first or if you download this entire project, run "composer update" to pull it from the current composer file.
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/includes/Foo.php';

$mpdf = new \Mpdf\Mpdf();
/**
 * Password protect document
 */
$mpdf->SetProtection([], 'UserPassword', 'Password');

/**
 * Set file properties
 */
$mpdf->SetTitle('The DevDrawer Is Awesome');
$mpdf->SetAuthor('The DevDrawer');

/**
 * Setup header and footer content / properties, split content left, right, and center with a pipe |
 */
$mpdf->defaultheaderline = 0;
$mpdf->setHeader('|Document Title|');
$mpdf->defaultfooterline = 0;
$mpdf->setFooter('Document Title|{DATE F j, Y}|{PAGENO}');

/**
 * Add external stylesheet
 */
$stylesheet = file_get_contents('style.css');
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

/**
 * Add a watermark
 */
$mpdf->SetWatermarkText('THE DEV DRAWER');
$mpdf->showWatermarkText = true;
$mpdf->watermarkTextAlpha = .1;

/**
 * Add content using direct or string method
 */
$mpdf->WriteHTML('<h1>Hello World</h1>');

$table = '
<table border="1" cellpadding="10" cellspacing="0">
<tr>
<td>Cell 1</td>
<td>Cell 2</td>
</tr>
<tr>
<td>Cell 3</td>
<td>Cell 4</td>
</tr>
</table>
';
$mpdf->WriteHTML($table);

/**
 * Add a barcode
 */
$mpdf->WriteHTML('<br><barcode code="123-456-7890" text="ISBN" class="barcode" />');
/**
 * Add a new page break
 */
$mpdf->AddPage();

/**
 * Add content from a class
 */
$mpdf->WriteHTML((new Foo())->bar());

/**
 * Output the file (blank for screen, D for download, F for file save)
 */
$mpdf->Output();
//$mpdf->Output('filename.pdf', 'D');
//$mpdf->Output('filename.pdf', 'F');