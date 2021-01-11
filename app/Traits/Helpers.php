<?php
namespace App\Traits;

trait Helpers
{
    function notificationMsg($type, $message) {
        session([$type => $message]);
    }
}
