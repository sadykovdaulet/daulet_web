<?php
function result_to_array($result){
    $array = array();
    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $array[$count] = $row;
        $count++;
    }
    unset($count);
    return $array;
}