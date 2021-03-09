<div class="contentWrapper">

<?php

elgg_load_library('rubric');

$rubric=$vars['entity'];
$rubricpost=$rubric->getGUID();
$action = "rubric/edit";

if (!elgg_is_sticky_form('edit_rubric')) {
   $title = $rubric->title;
   $tags = $rubric->tags;
   $access_id = $rubric->access_id;
   $rows = $rubric->rows;
   $cols = $rubric->cols;

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
} else {
   $title = elgg_get_sticky_value('edit_rubric','title');
   $tags = elgg_get_sticky_value('edit_rubric','rubrictags');
   $access_id = elgg_get_sticky_value('edit_rubric','access_id');
   $rows = elgg_get_sticky_value('edit_rubric','rows');
   $cols = elgg_get_sticky_value('edit_rubric','cols');
   $criteria_value = elgg_get_sticky_value('edit_rubric','criteria_value');
   $criteria_name = elgg_get_sticky_value('edit_rubric','criteria_name');
   $criteria_desc = elgg_get_sticky_value('edit_rubric','criteria_desc');
   $level_value = elgg_get_sticky_value('edit_rubric','level_value');
   $level_desc = elgg_get_sticky_value('edit_rubric','level_desc');
   $criteria_level_desc = elgg_get_sticky_value('edit_rubric','criteria_level_desc');
}

elgg_clear_sticky_form('edit_rubric');
$url = elgg_get_site_url();

?>

<form action="<?php echo $url."action/".$action?>" name="edit_rubric" enctype="multipart/form-data" method="post">
<?php echo elgg_view('input/securitytoken'); ?>
        
<p>
<?php
$rubric = edit_rubric($title,$rows,$cols,$criteria_value,$level_value,$criteria_name,$criteria_desc,$level_desc,$criteria_level_desc);
echo create_rubric_with_buttons($rubric);
?>
<input type='hidden' name='rows' id='rows' value=<?php echo $rows; ?>>
<input type='hidden' name='cols' id='cols' value=<?php echo $cols; ?>>
</p>
<p>
<b><?php echo elgg_echo("tags"); ?></b>
<?php
echo elgg_view("input/tags", array("name" => "rubrictags","value" => $tags)); 
?>
</p> 
<p>
<b><?php echo elgg_echo("access"); ?></b><br>
<?php
echo elgg_view("input/access", array("name" => "access_id","value" => $access_id)); 
?>
</p> 
<input type="hidden" name="rubric_guid" value="<?php echo $rubricpost; ?>">
<?php
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('rubric:save')));
?>
</form>
</div>

<?php
$enter_criteria_name = elgg_echo('rubric:enter_criteria_name');
$enter_criteria_description = elgg_echo('rubric:enter_criteria_description');
$enter_description = elgg_echo('rubric:enter_description');
$enter_level_value = elgg_echo('rubric:enter_level_value');
$enter_level_description = elgg_echo('rubric:enter_level_description');
$col_error = elgg_echo('rubric:error_deleting_cols');
$row_error = elgg_echo('rubric:error_deleting_rows');

$js = <<<EOT
<script type="text/javascript">
contador = 1;
numfilas = $rows;
numcols = $cols;

function addrow() {
   var t, i, celda, nodo, fila, nombre;
   t = document.getElementById("datos");
   fila = t.insertRow(numfilas);
   nombre = "fila" + numfilas;
   fila.id = nombre;

   for (i=numcols; i>0; i--) {
      celda = fila.insertCell(0);
      nodo = document.createElement("table");
      nombre = "celda" + i;
      nodo.setAttribute("id",nombre);
      n = numfilas;
      if (i==1) {
         nodo.innerHTML = '<td id="celda'+n+i+'" class="celdaizq"><table id="tcelda'+n+i+'" border="1"><tr><td><input id= "nombre'+n+i+'" type="text" size="22" value="$enter_criteria_name" name="criteria_name[]"><input type="text" size="10" value="$enter_criteria_value" name="criteria_value[]"></td></tr><tr><td><textarea id="texto'+n+i+'"  name="criteria_desc[]">$enter_criteria_description</textarea></td></tr></table></td>'; 
      } else {
         nodo.innerHTML = crearNodo(i, n);
      }
      celda.appendChild(nodo);
   }
   numfilas++;
   f = document.getElementById("rows");
   f.setAttribute("value",numfilas);
   return true;
}

function addcol() {
   var t,i, celda, nodo, fila;
   for (i=0; i<numfilas; i++) {
      fila = "fila" + i;
      t = document.getElementById(fila);
      celda = t.insertCell(numcols);
      nodo = document.createElement("table");
      if (i==0) {
         n = numcols+1;
         nodo.innerHTML = '<td id="celda'+i+n+'" class="celdaarriba"><table id="tcelda'+i+n+'" border="1"><tr><td><input type="text" id="texto'+i+n+'" name = "pdesc[]" value="$enter_level_description" size="22"></td></tr><tr><td id="puntos"><center><input id= "nombre'+i+n+'" type="text" size="4" value="$enter_level_value" name="level_value[]"></center></td></tr></table></td>';
      } else {
         nodo.innerHTML = crearNodo(numcols+1, i);
      }
      celda.appendChild(nodo);
   }
   numcols++;
   f = document.getElementById("cols");
   f.setAttribute("value",numcols);
   return true;
}

function delrow() {
   var t = document.getElementById("datos");
   if (numfilas <2) {
      alert("$row_error");
   } else {
      t.deleteRow(-1);
      numfilas--;
      f = document.getElementById("rows");
      f.setAttribute("value",numfilas);
   }
   return true;
}

function delcol() {
   var fila;
   if (numcols <2) {
      alert("$col_error");
   } else {
      var t = document.getElementById("datos");
      for (i=0; i<numfilas; i++) {
         fila = "fila" + i;
         t = document.getElementById(fila);
         t.deleteCell(-1);
      }
      numcols--;
      f = document.getElementById("cols");
      f.setAttribute("value",numcols);
   }
   return true;
}

function crearNodo(j, i) {
   return '<td id="celda2" class="celda"><table id="tcelda2" border="1"><tr><td><textarea id="texto'+i+j+'" class="cell" name = "criteria_level_desc[]">$enter_description</textarea></td></tr></table></td>';
}

function crearCeldaButton() {
   return '<td id="celdaButton1" bgcolor=#DCDCDC><center><a onclick= "javascript:delete ()"; href="javascript:;"><img border= "0" alt="add" src="img/delete.png"></a></center></td>';
}

</script>
EOT;
echo $js;
?>
