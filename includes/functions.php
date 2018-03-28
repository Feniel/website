<?php
function getId() {
    $i = 1;
    while (file_exists("../thumbs/thumb"$i".gif") {
        $i++;
    }
    return $i
?>