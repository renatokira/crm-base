<?php

if (!function_exists('obfuscate_email')) {

    function obfuscate_email(string $email)
    {

        $split = explode('@', $email);

        $fisrt       = $split[0];
        $firstQtd    = (int) floor(strlen($fisrt) * 0.75);
        $remaining   = strlen($fisrt) - $firstQtd;
        $maskedFirst = substr($fisrt, 0, $remaining) . str_repeat('*', $firstQtd);

        $second       = $split[1];
        $firstQtd     = (int) floor(strlen($second) * 0.75);
        $remaining    = strlen($second) - $firstQtd;
        $maskedSecond = str_repeat('*', $firstQtd) . substr($second, $remaining * -1, $remaining);

        return $maskedFirst . '@' . $maskedSecond;
    }
}
