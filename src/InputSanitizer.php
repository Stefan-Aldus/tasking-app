<?php

namespace TaskingApp;

class InputSanitizer
{
    public static function sanitize(array|string $input): string
    {
        // If the input is an array, sanitize each value
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = trim($value);
                $input[$key] = stripslashes($value);
                $input[$key] = htmlspecialchars($value);
            }
            // If the input is a string, sanitize the string
        } else {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
        }

        return $input;
    }

    public static function checkLength(string $input, int $min, int $max = 9999): bool
    {
        // Check if the length of the input is between the min and max values
        $length = strlen($input);
        if ($length < $min || $length > $max) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkEmail(string $input): bool
    {
        // Check if the input is a valid email address
        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }
}