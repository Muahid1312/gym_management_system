<?php

declare(strict_types=1);

use App\Support\PersianPdfText;

if (! function_exists('persian_pdf_shape')) {
    /**
     * Shape Persian/Arabic text for DomPDF (connected glyphs, correct visual order).
     */
    function persian_pdf_shape(?string $text, int $maxCharsPerLine = 512, bool $hindoDigits = false): string
    {
        return PersianPdfText::shapeForDomPdf($text, $maxCharsPerLine, $hindoDigits);
    }
}
