<?php

    $array = ['a', 'b', 'c', 1, 2, 3];

    function recherche($recherche) {
        global $array;
        $i = 1;
        foreach($array as $value) {
            if ($value == $recherche) {
                return "La position de $value est $i";
            }
            $i++;
        }
        return "Aucun résultat trouvé";
    }

    function select($name, $options, $option_vide = false) {
        $select = '<select name="' . $name . '">';
        if ($option_vide)
            $select .= '<option value=""></option>';
        foreach($options as $key => $value)
            $select .= '<option value="' . $value . '">' . $key . '</option>';
        $select .= '</select>';

        return $select;
    }


    $2y$11$q5MkhSBtlsJcNEVsYh64a.aCluzHnGog7TQAKVmQwO9C8xb.t89F.