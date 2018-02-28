<?php

function table_html($array, $updateable = false, $update_url = '') {
    $table = '<table class="table"><tr>';
    if ($updateable)
        $table .= '<th></th>';
    foreach(array_keys($array[0]) as $key) {
        $table .= '<th>' . $key . '</th>';
    }
    $table .= '</tr>';
    foreach($array as $row) {
        $table .= '<tr>';
        if ($updateable)
            $table .= '<td class="edit"><a href="' . $update_url . '?id=' . $row['id'] .'"><img src="img/edit.png"/></a></td>';
        foreach($row as $value) {
            $table .= '<td>' . $value . '</td>';
        }
        $table .= '</tr>';
    }
    $table .= '</table>';
    
    return $table;
}