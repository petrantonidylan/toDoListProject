<?php

function errorHandling ($idError){
    switch ($idError) {
        case '001':
            $error = "The deadline must be later than the current date.";
            break;
        default :
            $error = "No error.";
            break;
    }
    return $error;
}

?>