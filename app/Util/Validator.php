<?php


class Validator
{

    public function is_valid_time($time)
    {
        $case_hour = '/^(?:[01][0-9]|2[0-3]):[0-5][0-9]/';
        if (!preg_match($case_hour, $time))
            return false;
        return true;
    }

    public function format_time($time)
    {
        return '00:' . $time;
    }

}