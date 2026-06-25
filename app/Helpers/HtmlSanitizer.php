<?php

namespace App\Helpers;

class HtmlSanitizer
{
    private static array $allowedTags = [
        'p', 'b', 'i', 'u', 'strong', 'em', 'br', 'hr',
        'ul', 'ol', 'li', 'a', 'img',
        'table', 'tr', 'td', 'th', 'thead', 'tbody', 'tfoot',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'blockquote', 'pre', 'code', 'span', 'div', 'sub', 'sup',
    ];

    public static function sanitize(?string $input): string
    {
        if ($input === null || $input === '') {
            return '';
        }

        $input = self::removeScripts($input);
        $input = self::removeEventHandlers($input);
        $input = self::removeDangerousUrls($input);
        $input = self::removeDangerousTags($input);

        $allowed = '<' . implode('><', self::$allowedTags) . '>';
        return strip_tags($input, $allowed);
    }

    public static function plain(?string $input): string
    {
        if ($input === null || $input === '') {
            return '';
        }
        return strip_tags($input);
    }

    private static function removeScripts(string $input): string
    {
        $input = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $input);
        $input = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $input);
        return $input;
    }

    private static function removeEventHandlers(string $input): string
    {
        $input = preg_replace('/\s+on\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $input);
        return $input;
    }

    private static function removeDangerousUrls(string $input): string
    {
        $input = preg_replace('/\s+(href|src|action|formaction)\s*=\s*"(javascript|vbscript|data):[^"]*"/i', ' $1="#"', $input);
        $input = preg_replace('/\s+(href|src|action|formaction)\s*=\s*\'(javascript|vbscript|data):[^\']*\'/i', " $1='#'", $input);
        return $input;
    }

    private static function removeDangerousTags(string $input): string
    {
        return preg_replace('/<(iframe|object|embed|applet|form|input|textarea|select|button|frame|frameset|meta|link|base)\b[^>]*>.*?<\/\1>/is', '', $input);
    }
}
