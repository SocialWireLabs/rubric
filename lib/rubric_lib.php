<?php
    /*
    * Create the table for a rubric with buttons to add or remove cols or rows
    */
    function create_rubric_with_buttons($only_rubric)
    {
        $wwwroot = elgg_get_config('wwwroot');

        $rubric = "<table border=\"5px\" id=\"main-content\">";
        $rubric .= "<tr>";
        $rubric .= "<td>";
        $rubric .= "<table id=\"botones\" align = \"center\"><tr align = \"center\">";
        $rubric .= "<td><center><a onclick= \"javascript:addrow ()\";\">";
        $rubric .= "<img border= \"0\" alt=\"add\" src=\"".$wwwroot."mod/rubric/graphics/insertr.png\"> <br>". elgg_echo('rubric:add_row')."</a></center></td>";
        $rubric .= "<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>";
        $rubric .= "<td><center><a onclick= \"javascript:delrow ()\"; href=\"javascript:;\">";
        $rubric .= "<img border= \"0\" alt=\"del\" src=\"".$wwwroot."mod/rubric/graphics/delete.png\"> <br>". elgg_echo('rubric:delete_row')."</a></center></td>";
        $rubric .= "<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>";
        $rubric .= "<td><center><a onclick= \"javascript:addcol ()\"; href=\"javascript:;\">";
        $rubric .= "<img border= \"0\" alt=\"add\" src=\"".$wwwroot."mod/rubric/graphics/insertc.png\"> <br>". elgg_echo('rubric:add_col') ."</a></center>";
        $rubric .= "</td>";
        $rubric .= "<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>";
        $rubric .= "<td><center><a onclick= \"javascript:delcol ()\"; href=\"javascript:;\">";
        $rubric .= "<img border= \"0\" alt=\"del\" src=\"".$wwwroot."mod/rubric/graphics/delete.png\"> <br>". elgg_echo('rubric:delete_col') ."</a></center></td>";
        $rubric .= "</table>";
        $rubric .= "</td>";
        $rubric .= "</tr>";
        $rubric .= "<tr>";
        $rubric .= "<td>". $only_rubric;
        $rubric .= "</td>";
        $rubric .= "</tr>";
        $rubric .= "</table>";

        return $rubric;
    }

    /*
    * Create the table for a rubric
    */
    function create_rubric() {
        $rubric = "<table id='datos'>";
        for ($i=0; $i<4; $i++) {
            $rubric .=  "<tr id = 'fila".$i."'>";
            for ($j=1; $j<4 + 1; $j++) {
                // Title cell
                if (($j == 1) & ($i == 0))
                    $rubric .=  "<td id='celda1' class='celdatitulo'><table id='tcelda1' border='1'><tr><td><input type='text' id= 'nombre' size='22' value='".elgg_echo('rubric:enter_title')."' name='title'></td></tr></table></td>";
                // Left col
                elseif ($j == 1)
                    $rubric .=  "<td id='celda1' class='celdaizq'><table id='tcelda1' border='1' ><tr><td><input type='text' id= 'nombre".$i.$j."' size='22' value='".elgg_echo('rubric:enter_criteria_name')."' name='criteria_name[]'><input type='text' size='10' value='".elgg_echo('rubric:enter_criteria_value')."' name='criteria_value[]'></td></tr><tr><td><textarea id='texto".$i.$j."' name='criteria_desc[]'>".elgg_echo('rubric:enter_criteria_description')."</textarea></td></tr></table></td>";
                else {
                    // Top row
                    if ($i == 0) {
                        switch ($j) {
                            case "2": $text = elgg_echo('rubric:poor'); $t = 10; break;
                            case "3": $text = elgg_echo('rubric:fair'); $t = 50; break;
                            case "4": $text = elgg_echo('rubric:good'); $t = 100; break;
                        }
                        $rubric .=  "<td id='celda2' class='celdaarriba'><table id='tcelda".$j."' border='1'><tr><td><input type='text' id='texto".$i.$j."' name='level_desc[]' value='".$text."' size='22'></td></tr><tr><td id='puntos'><center>&nbsp;<input id= 'nombre".$i.$j."' type='text' size='4' value='".$t."' name='level_value[]'>&nbsp;</center></td></tr></table></td>";
                    }
                    // Other cell
                    else {
                        $rubric .=  "<td id='celda2' class='celda'><table id='tcelda".$j."' border='1'><tr><td><textarea class='cell' id='texto".$i.$j."' name='criteria_level_desc[]'>".elgg_echo('rubric:enter_description')."</textarea></td></tr></table></td>";
                    }
                }
            } 
            $rubric .= "</tr>";
        } 
        $rubric .= "</table>";
        return $rubric;
    }
		
    /*
    * Create the form to edit a rubric
    */
    function edit_rubric($title,$rows,$cols,$criteria_value,$level_value,$criteria_name,$criteria_desc,$level_desc,$criteria_level_desc) {
       $nc = 0;
       $nd = 0;
       $np = 0;
       $ncd = 0;
       $npd = 0;

       $r = "<table id='datos'>";
       for ($i=0; $i< $rows; $i++) {
           $r .=  "<tr id='fila".$i."'>";
           for ($j=0; $j< $cols; $j++) {
                // Celda de título
                if ($j == 0 && $i == 0) {
                    $r .= "<td id='celda1' class='celdatitulo'><table id='tcelda1' border='1'><tr><td><input type='text' id= 'nombre' size='22' value='". $title."' name='title'></td></tr></table></td>";
                }
                else {
                    // Columna izquierda
                    if ($j == 0) {
                        $t = $j + 1;
                        $r .= "<td id='celda".$t."' class='celdaizq'><table id='tcelda".$t."' border='1'><tr><td><input id= 'nombre".$i.$t."' type='text' size='22' value='". $criteria_name[$nc] ."' name='criteria_name[]'><input type='text' size='10' value='".$criteria_value[$nc]."' name='criteria_value[]'></td></tr><tr><td><textarea id='texto".$i.$t."' name='criteria_desc[]'>".$criteria_desc[$ncd]."</textarea></td></tr></table></td>";
                        $ncd++;
                        $nc++;
                    }
                    else  {
                        if ($i == 0) {
                            // Fila de arriba
                            $t = $j + 1;
                            $r .= "<td id='celda".$t."' class='celdaarriba'><table id='tcelda".$t."' border='1'><tr><td><input id='texto".$i.$t."' name='level_desc[]' size='22' value='".$level_desc[$npd]."'></td></tr><tr><td><center>&nbsp;<input id= 'nombre".$i.$t."' type='text' size='4' value='". $level_value[$np] ."' name='level_value[]'>&nbsp;%</center></td></tr></table></td>";
                            $npd++;
                            $np++;
                        }
                        else {
                                $t = $j + 1;
                                $r .= "<td id='celda".$t."' class='celda'><table id='tcelda".$t."' border='1'><tr><td><textarea class='cell' id='texto".$i.$t."' name='criteria_level_desc[]'>".$criteria_level_desc[$nd]."</textarea></td></tr></table></td>";
                                $nd++;
                        }
                    }
                }
            } 
            $r .= "</tr>";
       }
       $r .= "</table>";
       return $r;
    }

    //Shows the rubric
    function show_rubric($rubric) {
        $show_rubric .= "<table id='data' name='data'>";

        $nc = 0;
        $nd = 0;
        $np = 0;
        $ncd = 0;
        $npd = 0;

        $criteria_name = $rubric->criteria_name;
        $criteria_value = $rubric->criteria_value;
        $criteria_desc = $rubric->criteria_desc;
        $level_value = $rubric->level_value;
        $level_desc = $rubric->level_desc;
        $criteria_level_desc = $rubric->criteria_level_desc;

        $criteria_name = explode(chr(26),$criteria_name);
        $criteria_value = explode(chr(26),$criteria_value);
        $criteria_desc = explode(chr(26),$criteria_desc);
        $level_value = explode(chr(26),$level_value);
        $level_desc = explode(chr(26),$level_desc);
        $criteria_level_desc = explode(chr(26),$criteria_level_desc);

        for ($i=0; $i<$rubric->rows; $i++) {
            $show_rubric .=  "<tr>";
            for ($j=0; $j<$rubric->cols; $j++) {
                if ($j == 0 && $i == 0) {
                    $show_rubric .= "<td> <table class='celdat'> <tr> <td id='titul' name='titul'>".$rubric->title." </td> </tr></table> </td>";
                }
                else {
                    // Primera celda de la fila
                    if ($j == 0) {
                        $show_rubric .= "<td> <table class='celda'> <tr> <td id='crit'>". $criteria_name[$nc] ." (".$criteria_value[$ncd]."%)</td> </tr> <tr> <td>". $criteria_desc[$ncd] ."</td> </tr> </table> </td>";
                        $ncd++;
                        $nc++;
                    }
                    else {
                        // Primera celda de la columna
                        if ($i==0){
                            $show_rubric .= "<td> <table class='celdat'> <tr> <td>". $level_desc[$npd] ."</td> </tr> <tr> <td id='puntos'>". $level_value[$np] ." %</td> </tr>  </table> </td>";
                            $np++;
                            $npd++;
                        }
                        else {
                            $show_rubric .= "<td> <table class='celda'> <tr> <td><center><b>". $level_desc[$j-1] ."</b></center></td> </tr><tr> <td>". $criteria_level_desc[$nd] ."</td> </tr> </table> </td>";
                            $nd++;
                        }
                    }
                }
            } 
            $show_rubric .= "</tr>";
        } 
        $show_rubric .= "</table>";

        return $show_rubric;
    }

    //Shows a rubric to be rated
    function rate_rubric($rubric, $url, $student_guid, $task_guid, $container_guid) {
        $show_rubric .= "<table id='data' name='data'>";

        $nc = 0;
        $nd = 0;
        $np = 0;
        $ncd = 0;
        $npd = 0;

        $criteria_value = $rubric->criteria_value;
        $criteria_name = $rubric->criteria_name;
        $criteria_desc = $rubric->criteria_desc;
        $level_value = $rubric->level_value;
        $level_desc = $rubric->level_desc;
        $criteria_level_desc = $rubric->criteria_level_desc;

        $criteria_value = explode(chr(26),$criteria_value);
        $criteria_name = explode(chr(26),$criteria_name);
        $criteria_desc = explode(chr(26),$criteria_desc);
        $level_value = explode(chr(26),$level_value);
        $level_desc = explode(chr(26),$level_desc);
        $criteria_level_desc = explode(chr(26),$criteria_level_desc);

        for ($i=0; $i<$rubric->rows; $i++) {
            $show_rubric .=  "<tr>";
            for ($j=0; $j<$rubric->cols; $j++) {
                if ($j == 0 && $i == 0) {
                    $show_rubric .= "<td> <table class='celdat'> <tr> <td id='titul' name='titul'>".$rubric->title." </td> </tr></table> </td>";
                }
                else {
                    // Primera celda de la fila
                    if ($j == 0) {
                        $show_rubric .= "<td> <table class='celda'> <tr> <td id='crit'>". $criteria_name[$nc] ." (".$criteria_value[$ncd]."%)<input type='hidden' id='w".$i."' value='".$criteria_value[$ncd]."'></td> </tr> <tr> <td>". $criteria_desc[$ncd] ."</td> </tr> </table> </td>";
                        $ncd++;
                        $nc++;
                    }
                    else {
                        // Primera celda de la columna
                        if ($i==0){
                            $show_rubric .= "<td> <table class='celdat'> <tr> <td>". $level_desc[$npd] ."</td> </tr> <tr> <td id='puntos'><input type='hidden' id='p".$j."' value='".$level_value[$np]."'>". $level_value[$np] ." %</td> </tr>  </table> </td>";
                            $np++;
                            $npd++;
                        }
                        else {
			    $rows = $rubric->rows;
                            $cols = $rubric->cols;
                            $show_rubric .= "<td > <table class='celda' id='".$i.$j."'> <tr> <td><center><b><a id='selectCell' onClick='seleccionar(".$i.",".$j.",".$rows.",".$cols."); return false;' href='javascript:'>". $level_desc[$j-1] ."</a></b></center></td> </tr><tr> <td>".$criteria_level_desc[$nd]."</td> </tr> </table> </td>";

                            $nd++;
                        }
                    }
                }
            } 
            $show_rubric .= "</tr>";
        } 
        $show_rubric .= "</table>";

        $show_rubric .= "<br><p><table id='tablapuntuacion'><tr><td id='puntuaciontotal'></td></tr></table></p><br>";
        $rubric_form = elgg_view('input/hidden', array('name' => 'rubric_guid', 'value' => $rubric->guid));
        $rubric_form .= elgg_view('input/hidden', array('name' => 'student_guid', 'value' => $student_guid));
        $rubric_form .= elgg_view('input/hidden', array('name' => 'task_guid', 'value' => $task_guid));
        $rubric_form .= elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
	$save_rate = elgg_echo('rubric:save_rate');
        $rubric_form .= "<div id='rubric_rating_form'>".elgg_view('input/submit', array('value' => "$save_rate", 'name' => 'submit'))."</div>";

        $show_rubric_form = elgg_view('input/form', array('action' => "{$url}action/rubric/rate", 'body' => $rubric_form, 'enctype' => 'multipart/form-data'));

	$show_rubric_form .= elgg_view('input/securitytoken');

        return $show_rubric.$show_rubric_form;
    }

    //Shows a rubric rated
    function rated_rubric($rubric, $rating) {
        $show_rubric .= "<table id='data' name='data'>";

        $nc = 0;
        $nd = 0;
        $np = 0;
        $ncd = 0;
        $npd = 0;

        $criteria_name = $rubric->criteria_name;
        $criteria_value = $rubric->criteria_value;
        $criteria_desc = $rubric->criteria_desc;
        $level_value = $rubric->level_value;
        $level_desc = $rubric->level_desc;
        $criteria_level_desc = $rubric->criteria_level_desc;

        $criteria_name = explode(chr(26),$criteria_name);
        $criteria_value = explode(chr(26),$criteria_value);
        $criteria_desc = explode(chr(26),$criteria_desc);
        $level_value = explode(chr(26),$level_value);
        $level_desc = explode(chr(26),$level_desc);
        $criteria_level_desc = explode(chr(26),$criteria_level_desc);

        $coordinates = $rating->coordinates;

        for ($i=0; $i<$rubric->rows; $i++) {
            $show_rubric .=  "<tr>";
            for ($j=0; $j<$rubric->cols; $j++) {
                if ($j == 0 && $i == 0) {
                    $show_rubric .= "<td> <table class='celdat'> <tr> <td id='titul' name='titul'>".$rubric->title." </td> </tr></table> </td>";
                }
                else {
                    // Primera celda de la fila
                    if ($j == 0) {
                        $show_rubric .= "<td> <table class='celda'> <tr> <td id='crit'>". $criteria_name[$nc] ." (".$criteria_value[$ncd]."%)<input type='hidden' id='w".$i."' value='".$criteria_value[$ncd]."'></td> </tr> <tr> <td>". $criteria_desc[$ncd] ."</td> </tr> </table> </td>";
                        $ncd++;
                        $nc++;
                    }
                    else {
                        // Primera celda de la columna
                        if ($i==0){
                            $show_rubric .= "<td> <table class='celdat'> <tr> <td>". $level_desc[$npd] ."</td> </tr> <tr> <td id='puntos'><input type='hidden' id='p".$j."' value='".$level_value[$np]."'>". $level_value[$np] ." %</td> </tr>  </table> </td>";
                            $np++;
                            $npd++;
                        }
                        else {
			    $rows = $rubric->rows;
                            $cols = $rubric->cols;
                            if ($coordinates[$i-1] == $j) {
                                $show_rubric .= "<td > <table class='seleccionada' id='".$i.$j."'> <tr> <td><center><b>".$level_desc[$j-1]."</a></b></center></td> </tr><tr> <td>".$criteria_level_desc[$nd]."</td> </tr> </table> </td>";
                            } else {
                                $show_rubric .= "<td > <table class='celda' id='".$i.$j."'> <tr> <td><center><b>".$level_desc[$j-1]."</a></b></center></td> </tr><tr> <td>".$criteria_level_desc[$nd]."</td> </tr> </table> </td>";
                            }
			    $nd++;
                        }
                    }
                }
            } 
            $show_rubric .= "</tr>";
        } 
        $show_rubric .= "</table>";
	$total = elgg_echo('rubric:total');
        $show_rubric .= "<br><p><table id='tablapuntuacion'><tr><td id='puntuaciontotal'><div id='pt' style='background:#D0FFD0; border:1px solid #66CC00; padding: 5px'>$total " .$rating->percentage. " %</div></td></tr></table></p><br>";

        return $show_rubric;
    }

    //Shows a rubric rated to be edited
    function edit_rated_rubric($rubric, $rating, $url) {
        $show_rubric .= "<table id='data' name='data'>";

        $nc = 0;
        $nd = 0;
        $np = 0;
        $ncd = 0;
        $npd = 0;

        $criteria_value = $rubric->criteria_value;
        $criteria_name = $rubric->criteria_name;
        $criteria_desc = $rubric->criteria_desc;
        $level_value = $rubric->level_value ;
        $level_desc = $rubric->level_desc;
        $criteria_level_desc = $rubric->criteria_level_desc;

        $criteria_value = explode(chr(26),$criteria_value);
        $criteria_name = explode(chr(26),$criteria_name);
        $criteria_desc = explode(chr(26),$criteria_desc);
        $level_value = explode(chr(26),$level_value);
        $level_desc = explode(chr(26),$level_desc);
        $criteria_level_desc = explode(chr(26),$criteria_level_desc);

        $coordinates = $rating->coordinates;

        for ($i=0; $i<$rubric->rows; $i++) {
            $show_rubric .=  "<tr>";
            for ($j=0; $j<$rubric->cols; $j++) {
                if ($j == 0 && $i == 0) {
                    $show_rubric .= "<td> <table class='celdat'> <tr> <td id='titul' name='titul'>".$rubric->title." </td> </tr></table> </td>";
                }
                else {
                    // Primera celda de la fila
                    if ($j == 0) {
                        $show_rubric .= "<td> <table class='celda'> <tr> <td id='crit'>". $criteria_name[$nc] ." (".$criteria_value[$ncd]."%)<input type='hidden' id='w".$i."' value='".$criteria_value[$ncd]."'></td> </tr> <tr> <td>". $criteria_desc[$ncd] ."</td> </tr> </table> </td>";
                        $ncd++;
                        $nc++;
                    }
                    else {
                        // Primera celda de la columna
                        if ($i==0){
                            $show_rubric .= "<td> <table class='celdat'> <tr> <td>". $level_desc[$npd] ."</td> </tr> <tr> <td id='puntos'><input type='hidden' id='p".$j."' value='".$level_value[$np]."'>". $level_value[$np] ." %</td> </tr>  </table> </td>";
                            $np++;
                            $npd++;
                        }
                        else {
			    $rows = $rubric->rows;
                            $cols = $rubric->cols;
                            if ($coordinates[$i-1] == $j){
                                $show_rubric .= "<td > <table class='seleccionada' id='".$i.$j."'> <tr> <td><center><b><a id='selectCell' onClick='seleccionar(".$i.",".$j.",".$rows.",".$cols."); return false;' href='javascript:'>".$level_desc[$j-1]."</a></b></center></td> </tr><tr> <td>".$criteria_level_desc[$nd]."</td> </tr> </table> </td>";
                            } else {
                                $show_rubric .= "<td > <table class='celda' id='".$i.$j."'> <tr> <td><center><b><a id='selectCell' onClick='seleccionar(".$i.",".$j.",".$rows.",".$cols."); return false;' href='javascript:'>".$level_desc[$j-1]."</a></b></center></td> </tr><tr> <td>".$criteria_level_desc[$nd]."</td> </tr> </table> </td>";
                            }
			    $nd++;
                        }
                    }
                }
            } 
            $show_rubric .= "</tr>";
        } 
        $show_rubric .= "</table>";
	
        $rubric_form = elgg_view('input/hidden', array('name' => 'rating_guid', 'value' => $rating->guid));
        $rubric_form .= elgg_view('input/hidden', array('name' => 'rubric_guid', 'value' => $rubric->guid));
	$save_rate = elgg_echo('rubric:save_rate');
        $rubric_form .= "<div id='rubric_rating_form'>".elgg_view('input/submit', array('value' => "$save_rate", 'name' => 'submit'))."</div>";
        $show_rubric_form = elgg_view('input/form', array('action' => "{$url}action/rubric/rate", 'body' => $rubric_form, 'enctype' => 'multipart/form-data'));
	$show_rubric_form .= elgg_view('input/securitytoken');
        $total = elgg_echo('rubric:total');
	$show_rubric .= "<br><p><table id='tablapuntuacion'><tr><td id='puntuaciontotal'><div id='pt' style='background:#D0FFD0; border:1px solid #66CC00; padding: 5px'>$total " .$rating->percentage. " %</div></td></tr></table></p>";
	$show_rubric .= "<p>".$show_rubric_form."</p>";
        return $show_rubric;
    }
?>