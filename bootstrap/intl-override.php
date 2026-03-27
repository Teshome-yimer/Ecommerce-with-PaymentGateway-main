<?php

// Override intl functions to prevent errors
if (!extension_loaded('intl')) {
    // Mock NumberFormatter class
    if (!class_exists('NumberFormatter')) {
        class NumberFormatter
        {
            const CURRENCY = 1;
            const DECIMAL = 2;
            const PERCENT = 3;
            
            public function __construct($locale, $style) {}
            public function format($value) { return (string) $value; }
            public static function create($locale, $style) { return new self($locale, $style); }
            public function formatCurrency($value, $currency) { return $currency . ' ' . $value; }
        }
    }
    
    // Mock Locale class
    if (!class_exists('Locale')) {
        class Locale
        {
            const DEFAULT_LOCALE = 'en';
            public static function getDefault() { return 'en'; }
            public static function setDefault($locale) { return true; }
        }
    }
    
    // Mock IntlDateFormatter class
    if (!class_exists('IntlDateFormatter')) {
        class IntlDateFormatter
        {
            const FULL = 0;
            const LONG = 1;
            const MEDIUM = 2;
            const SHORT = 3;
            const NONE = -1;
            
            public function __construct($locale, $datetype, $timetype) {}
            public function format($value) { return date('Y-m-d H:i:s', $value); }
        }
    }
}
