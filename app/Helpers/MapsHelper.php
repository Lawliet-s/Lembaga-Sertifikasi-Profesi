<?php

namespace App\Helpers;

class MapsHelper
{
    public static function convertToEmbed($url)
    {
        if (empty($url)) {
            return $url;
        }

        if (str_contains($url, 'maps/embed?pb=')) {
            return $url;
        }

        $finalUrl = self::resolveShortUrl($url);

        $coords = self::extractCoordinates($finalUrl);
        if ($coords) {
            return 'https://www.google.com/maps?q=' . $coords . '&output=embed';
        }

        $place = self::extractPlace($finalUrl);
        if ($place) {
            return 'https://www.google.com/maps?q=' . urlencode($place) . '&output=embed';
        }

        return $url;
    }

    private static function resolveShortUrl($url)
    {
        if (!str_contains($url, 'goo.gl/maps') && !str_contains($url, 'maps.app.goo.gl')) {
            return $url;
        }

        $host = parse_url($url, PHP_URL_HOST);
        if ($host) {
            $resolvedIp = gethostbyname($host);
            if ($resolvedIp !== $host) {
                if (filter_var($resolvedIp, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
                    return $url;
                }
            }
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_NOBODY => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        curl_exec($ch);
        $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);

        return $finalUrl ?: $url;
    }

    private static function extractCoordinates($url)
    {
        if (preg_match('/@(-?\d+\.?\d*),(-?\d+\.?\d*)/', $url, $m)) {
            return $m[1] . ',' . $m[2];
        }
        return null;
    }

    private static function extractPlace($url)
    {
        if (preg_match('/\/place\/([^\/@?]+)/', $url, $m)) {
            return urldecode($m[1]);
        }
        if (preg_match('/[?&]q=([^&]+)/', $url, $m)) {
            return urldecode($m[1]);
        }
        return null;
    }
}
