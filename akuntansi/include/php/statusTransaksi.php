<?php

function getStatusTransaksiText($status) {
    switch($status) {
        case 0:
            return "PENDING";
            break;
        case 1:
            return "ALREADY POSTED";
            break;
        case 2:
            return "WAITING FOR POSTED";
            break;
        case 3:
            return "WAITING FOR PAYMENT";
            break;
        case 4:
            return "WAITING FOR VERIFICATION";
            break;
        case 5:
            return "WAITING FOR PAYMENT";
            break;
        case 6:
            return "CLOSED";
            break;
        case -1:
            return "REJECTED";
            break;
        case -2:
            return "CANCELLED";
            break;
    }
}

?>
