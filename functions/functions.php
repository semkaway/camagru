<?php
session_start();

function isloggedin() {
    if ($_SESSION['user'] != '') {
        return true;
    }
    else {
        return false;
    }
}
?>