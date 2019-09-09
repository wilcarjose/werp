<?php

use Carbon\Carbon;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Illuminate\Contracts\Encryption\DecryptException;

function flash($message, $level = 'info', $class = 'info-bg')
{
    session()->flash('flash_message', $message);
    session()->flash('flash_class', $class);
    session()->flash('flash_message_level', $level);
}

function mpr($d, $echo = true)
{
    if ($echo) {
        echo '<pre>'.print_r($d, true).'</pre>';
    } else {
        return '<pre>'.print_r($d, true).'</pre>';
    }
}

function mprd($d)
{
    mpr($d);
    die;
}

function clean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function randomInteger($num=6)
{
    $value = 1;
    $start = str_pad($value, $num, '0', STR_PAD_RIGHT);
    $end   = ($start*10) - 1;
    return mt_rand($start, $end);
}

function serializeEnc($array)
{
    return encrypt(serialize($array));
}

function serializeDec($array)
{
    return unserialize(decrypt($array));
}
function truncateDateToDay($time)
{
    $reset = date_default_timezone_get();
    date_default_timezone_set('UTC');
    $stamp = strtotime('today', $time);
    date_default_timezone_set($reset);
    return $stamp;
}

function json_to_array($json)
{   
    return is_array($json) ? $json : json_decode($json, true);
}

function get_process_url($type, $id, $label = null)
{
    $route = config('werp.transaction_route')[$type].'.edit';

    return $label ? [
            'text' => $label,
            'url' => route($route, $id),
        ] : route($route, $id);
}

function get_date_format(string $date, $format = 'Y-m-d H:i:s')
{
    return Carbon::parse($date)->format($format);    
}

function get_color_by_tx_type($type)
{
    return config('werp.transaction_color')[$type];
}

function get_initials($text)
{
    $words = explode(" ", $text);

    $initials = null;

    foreach ($words as $key => $w) {
        $initials .= $w[0];
        if ($key == 1) {
            break;
        }
    }

    return strtoupper($initials);
}

function get_transaction_name($type)
{
    return trans(config('werp.doctypes.'.$type));
}

function get_transaction_initials($type)
{
    return config('werp.transaction_initials')[$type];
}
