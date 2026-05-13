<?php

declare(strict_types=1);

namespace App\Support;

use App\Support\Persian\I18NPersianGlyphs;

/**
 * Prepare Arabic/Persian strings for DomPDF (CPDF): glyph shaping + visual order.
 *
 * DomPDF does not apply OpenType Arabic shaping; without this, letters stay isolated
 * and can appear reversed. Output is in left-to-right visual order — use LTR + Vazir in CSS.
 */
final class PersianPdfText
{
    private static ?I18NPersianGlyphs $glyphs = null;

    /**
     * @param  int  $maxCharsPerLine  Passed to the glyph joiner (avoid wrapping names mid-word).
     * @param  bool  $hindoDigits  When true, Western digits become Arabic-Indic (usually off for names).
     */
    public static function shapeForDomPdf(?string $text, int $maxCharsPerLine = 512, bool $hindoDigits = false): string
    {
        $text = $text ?? '';

        if ($text === '') {
            return '';
        }

        if (! preg_match('/\p{Arabic}/u', $text)) {
            return $text;
        }

        self::$glyphs ??= new I18NPersianGlyphs;

        return self::$glyphs->utf8Glyphs($text, $maxCharsPerLine, $hindoDigits);
    }
}
