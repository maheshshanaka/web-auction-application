<?php

if (!function_exists('errorMessage')) {
    function errorMessage($errors, string $field)
    {
        if ($errors->has($field)) {

            return ' <span id="name-error' . $field . '" class="error text-danger">' . $errors->first($field) . '</span>';

        }
        return null;
    }
}

if (!function_exists('errorClass')) {
    function errorClass($errors, string $field)
    {
        if ($errors->has($field)) {
            return "is-invalid";
        }
        return null;
    }
}


if (!function_exists('saveButton')) {
    function saveButton($text = null)
    {
        return view('layouts.buttons.save',
            ['text' => $text]);
    }
}

if (!function_exists('updateButton')) {
    function updateButton($text = null)
    {
        return view('layouts.buttons.update',
            ['text' => $text]);
    }
}
