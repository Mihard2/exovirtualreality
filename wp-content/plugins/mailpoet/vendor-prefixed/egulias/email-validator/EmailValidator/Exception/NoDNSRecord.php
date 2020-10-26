<?php

namespace MailPoetVendor\Egulias\EmailValidator\Exception;

if (!defined('ABSPATH')) exit;


class NoDNSRecord extends \MailPoetVendor\Egulias\EmailValidator\Exception\InvalidEmail
{
    const CODE = 5;
    const REASON = 'No MX or A DSN record was found for this email';
}
