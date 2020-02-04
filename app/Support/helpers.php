<?php
if (!function_exists('classValidOrInvalidForInput')) {
    /**
     * Class Valid or Invalid for input
     *
     * @param  string $field Name of input
     * @param  Illuminate\Support\ViewErrorBag $errors
     * 
     * @return string
     */
    function classValidOrInvalidForInput($field,$errors) {
        if($errors->has($field))
            return ' form-control is-invalid ';

        if(old($field) !== null)
            return ' form-control is-valid ';

        return ' form-control ';
    }
}

if (!function_exists('classValidOrInvalidForCheck')) {

    /**
     * Class Valid or Invalid for checkbox
     *
     * @param  string $field Name of input
     * @param  Illuminate\Support\ViewErrorBag $errors
     * 
     * @return string
     */
    function classValidOrInvalidForCheck($field,$errors) {
        if($errors->has($field))
            return ' form-check-input is-invalid ';

        if(old($field) !== null)
            return ' form-check-input is-valid ';

        return ' form-check-input ';
    }
}