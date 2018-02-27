<?php

function table_html($array) {
    $table = '<table class="table"><tr>';
    foreach(array_keys($array[0]) as $key) {
        $table .= '<th>' . $key . '</th>';
    }
    $table .= '</tr>';
    foreach($array as $row) {
        $table .= '<tr>';
        foreach($row as $value) {
            $table .= '<td>' . $value . '</td>';
        }
        $table .= '</tr>';
    }
    $table .= '</table>';
    
    return $table;
}