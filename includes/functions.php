<?php

function getId() {
    $i = 1;
    while (file_exists("../media/cont/thumbs/thumb"+ $i +".gif")) {
        $i++;
    }
    return $i;
}