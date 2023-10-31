<?php

function text($line, $args = [])
{
    if (empty($line)) return "";
    helper("cookie");
    $locale = get_cookie("locale");
    return lang("Display.{$line}", $args, $locale);
}

function str_censor($str)
{
    if (!$str) return $str;
    $target = $str;
    $count = round(strlen($target) * 0.3);
    $output = substr_replace($target, str_repeat('*', $count), strlen($target) - round($count * 1.5), $count);
    return $output;
}

function is_master($role)
{
    return $role == ROLE_MASTER;
}

function is_agent($role)
{
    return $role == ROLE_AGENT;
}

function is_admin($role)
{
    return $role == ROLE_ADMIN;
}
