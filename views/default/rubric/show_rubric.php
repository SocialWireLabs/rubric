<div class="rubrics_gallery">

<?php

elgg_load_library('rubric');

if (isset($vars['entity'])) {
    //muestra
    if ($vars['view_type'] == 'show') {
       echo show_rubric($vars['entity'])."<br>";
    }
    //para puntuar
    elseif ($vars['view_type'] == 'rate') {
       echo rate_rubric($vars['entity'], elgg_get_site_url(), $vars['student_guid'], $vars['task_guid'], $vars['container_guid'])."<br>";
    }
    //puntuada
    elseif ($vars['view_type'] == 'rated') {
       echo rated_rubric($vars['entity'], $vars['rating'])."<br>";
    }
    //para editar puntuación
    elseif ($vars['view_type'] == 'edit_rated') {
       echo edit_rated_rubric($vars['entity'], $vars['rating'], elgg_get_site_url())."<br>";
    }
}
?>
</div>
<script language='javascript'>
function seleccionar(i, j, rows, cols) {
   for (x=1; x<cols; x++) {
      var cell = i + "" + x;
      var celda = document.getElementById(cell);
      if (x == j) {
         celda.className = "seleccionada";
      } else {
         celda.className = "celda";
      }
   }
   valorar(cols,rows);
}

function valorar(cols,rows) {
   var cell;
   var celda;
   var total = 0;
   var p;
   var w;
   var pts;
   var puntos;
   var rating_form = "";
   var coordinates = "";
   for (i=1; i<rows; i++) {
      for (j=1; j<cols; j++) {
         cell = i + "" + j;
         celda = document.getElementById(cell);
         if (celda.className == "seleccionada") {
            p = "p"+j;
            pts = document.getElementById(p);
            w = "w"+i;
            weight = document.getElementById(w);
            puntos = pts.value * weight.value;
            total += parseInt(puntos);
	    coordinates += j+";";
            break;
         }
      }
   }
   var max = cols-1;
   max = "p" + max;
   max = document.getElementById(max).value;
   var percentage = Math.round(total)/100;
   var d = document.getElementById('puntuaciontotal');
   var r = document.getElementById('rubric_rating_form');
   var message = "<div id='pt' style='background:#D0FFD0; border:1px solid #66CC00; padding: 5px'>Total: " + percentage + " %</div>";
   rating_form += "<input type=\"hidden\" name=\"percentage\" value=\""+ percentage +"\">";
   rating_form += "<input type=\"hidden\" name=\"coordinates\" value=\""+ coordinates +"\">";
   d.innerHTML = message;
   r.innerHTML += rating_form;
}
</script>
