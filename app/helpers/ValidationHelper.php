<?php
class ValidationHelper {
    public static function required($value, $fieldName) {
        if (empty($value) && $value !== '0' && $value !== 0) {
            return "The {$fieldName} field is required";
        }
        return null;
    }

    public static function email($value, $fieldName) {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "The {$fieldName} field must be in a valid email format.";
        }
        return null;
    }

    public static function inList($value, $list, $fieldName) {
        if (!empty($value) && !in_array($value, $list)) {
            return "The {$fieldName} field must be one of: " . implode(', ', $list);
        }
        return null;
    }

    public static function integer($value, $fieldName) {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_INT)) {
            return "The {$fieldName} field must be an integer";
        }
        return null;
    }

    public static function float($value, $fieldName) {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_FLOAT)) {
            return "The {$fieldName} field must be a decimal number";
        }
        return null;
    }
}