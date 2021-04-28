<?php


namespace App\Theme;

use Respect\Validation\Validator as v;
use libphonenumber;

class Util {
    /**
     * Format phone number string
     *
     * @see https://github.com/giggsey/libphonenumber-for-php
     *
     * @param string $phone Phone number to format
     * @param string $format What format to return. Choices are display and link.
     *
     * @return bool|string
     * @throws libphonenumber\NumberParseException
     */
    public static function formatPhone($phone = '', $format = 'display') {
        $phoneUtil = libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $phoneNumber = $phoneUtil->parse($phone, "US");
        } catch (\libphonenumber\NumberParseException $e) {
            return false;
        }

        if ($phoneUtil->isValidNumber($phoneNumber)) {
            switch ($format) {
                case 'display' :
                    return $phoneUtil->format($phoneNumber, libphonenumber\PhoneNumberFormat::NATIONAL);
                    break;
                case 'link' :
                    return $phoneUtil->format($phoneNumber, libphonenumber\PhoneNumberFormat::RFC3966);
                    break;
                default :
                    return false;
                    break;
            }
        }

        return false;
    }
}
