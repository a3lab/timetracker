<?php

//badges must be all numbers 0-9 
//and be 12 numbers long
function validateBadge($data)
{
    $int = preg_replace('/\D/', '', $data);
    $int = makeInputSafe($int);

    if (strlen((string)$int) == 12) {
        //we have 12 ints here
        if ($int == $data) {
            return true;
        }
    }
    return false;
}

function validateName($data)
{
    $string = preg_replace('/[0-9]+/', '', $data);
    $string = makeInputSafe($string);

    if (strlen($string) < 250) {
        if ($string == $data) {
            return true;
        }
    }
    return false;
}

function makeInputSafe($data)
{
    //strip out possible SQL injestions 
    //strip out possible invalid characterss
    return $data;
}

?>