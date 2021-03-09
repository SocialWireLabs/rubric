.singleview {
	margin-top:10px;
}
.rubric_options {
	text-align:right;
	float:right;
	margin:5px 5px 5px 50px;
}

table#data {
  border-width: 2px;
  border-color: #DCDCDC;
  padding: 5px;
  background : #DCDCDC;
  -moz-border-radius: 5px;
}

table#data2 {
  border-width: 2px;
  border-color: #DCDCDC;
  margin-left: 5px;
  background : #FFFFFF;
  -moz-border-radius: 5px;
}

.rubrics_gallery {
	margin: 10px;
	-moz-border-radius: 8px;
	background: none repeat scroll 0 0 white;
	display: block;
	padding: 10px;
}

.boton {
   color:white;
   background: none repeat scroll 0 0 #4690D6;
   -moz-border-radius: 4px;
   font: bold 12px/100% Arial,Helvetica,sans-serif;
   border: 1px solid #4690D6;
}

.boton:hover {
   background: none repeat scroll 0 0 #0054A7;
   border-color: #0054A7;
   cursor: hand;
   cursor: pointer;
}

/* ***************************************
   Vista de galeria de una rubrica
*************************************** */

.rubrics_gallery table#evaluar{
   background: #DCDCDC;
   -moz-border-radius: 5px;
   height: 100%;
}

.rubrics_gallery .celda{
   background: #ffffff;
   border: solid #ffffff 3px;
   width: 100%;
   height: 100%;
}

.rubrics_gallery .seleccionada{
   background: #F7FE2E;
   border: solid #F7FE2E 3px;
   width: 100%;
   height: 100%;
}

.rubrics_gallery .celdat{
   background: #4682B4;
   border: solid #4682B4 3px;
   width: 100%;
   height: 100%;
   color: #FFFFFF;
}

.rubrics_gallery tr#crit{
   margin: 3em;
   height: 100%;
   border: dotted #FFFFFF 3px;
   -moz-border-radius: 5px;
}

.rubrics_gallery td{
   height: 100%;
   padding: 1px;
   border: 1px;
}

.rubrics_gallery td#puntos{
   font-weight:bold;
}

.rubrics_gallery td#crit{
   font-weight:bold;
}

.rubrics_gallery td#titul{
   border-bottom: dotted #4682B4 3px;
   background:#4682B4;
   color: #ffffff;
   font-weight:bold;
}

.texto {
   color: #a9a9a9;
}

.rubric_content {
	margin: 5px;
	-moz-border-radius: 8px;
	background: none repeat scroll 0 0 white;
	display: block;
	padding: 5px;
}

/* ***************************************
   Vista de creacion de una rubrica
*************************************** */

.rubrics_new {
   margin: 10px;
   -moz-border-radius: 8px;
   background: none repeat scroll 0 0 white;
   display: block;
   padding: 10px;
}

.nueva_rubrica #tabl{
   margin: 10px;
   padding: 10px;
   -moz-border-radius: 8px;
   color: #4682B4;
   font-family: Verdana,Arial,Helvetica,sans-serif;
   font-size: 10pt;
}

#tabl{
   margin: 10px;
   padding: 10px;
   vertical-align: middle;
}

.nueva_rubrica {
   border: 1px solid #8bb5d9;
   -moz-border-radius: 8px;
   padding: 10px;
   margin: 10px;
}

.rubrics_crear table #datos{
   font-size: 75%;
   background: #ffffff;
   position: relative;
}

.rubrics_crear td{
   height: 100%;
}

.rubrics_crear table #botones{
   font-size: 75%;
   -moz-border-radius-topleft: 5px;
   -moz-border-radius-topright: 5px;
   vertical-align:middle;
   horizontal-align:middle;
   padding: 3px;
   padding-left: 175px;
}

.celdatitulo {
   background-color: #4682B4;
   border:1px solid #dcdcdc;
   padding: 3px;
   height: 100%;
}

.celdaarriba {
   background-color: #4682B4;
   padding: 3px;
   border:1px solid #dcdcdc;
   height: 100%;
   color: white;
   align: center;
}

.celdaizq {
   background-color: #FFFFFF;
   padding: 3px;
   border:1px solid #dcdcdc;
   height: 100%;
}

.celda {
   border: #dcdcdc 1px solid;
   font-weight:bold;
   padding: 2px;
   height: 100%;
}

.celda2 {
   border: #DCDCDC 2px solid;
   width: 100%;
   height: 100%;
   clear:both;
}

.rubrics_text {
   font: 100%/1.8 "Lucida Grande",Verdana,sans-serif;
   color: #333333;
}

.rubric-content {
   overflow:auto;
   border: 1px solid #DCDCDC;
   -moz-border-radius: 5px;
}

.rubric-content table #datos{
   font-size: 75%;
   background: #ffffff;
   position: relative;
}

.rubric-content td{
   height: 100%;
}

.rubric-content table #botones{
   font-size: 75%;
   -moz-border-radius-topleft: 5px;
   -moz-border-radius-topright: 5px;
   vertical-align:middle;
   horizontal-align:middle;
   padding: 3px;
   padding-left: 175px;
}

#main-content{
   border-width: 5px;
   border-spacing: 2px;
   border-color: white;
   border-collapse: separate;
   background-color: white;
}

.cell {
   height: 70px;
}

/* ***************************************
   Vista de cargar rubrica
*************************************** */

.rubricas_form {
   margin: 10px;
   -moz-border-radius: 8px;
   background: none repeat scroll 0 0 white;
   display: block;
   padding: 10px;
}

/* ***************************************
   Vista de calificaciones (formUsuarios)
*************************************** */

#usuarios {
   background: #FFFFFF;
   -moz-border-radius: 10px;
   padding: 10px;
}

#usuarios td {
   padding:5px;
}

#usuarios td, th {
   border:1px solid #DCDCDC;
}

p.tags {
   background:transparent url(<?php echo elgg_get_site_url(); ?>_graphics/icon_tag.gif) no-repeat scroll left 2px;
   margin:7px 0 7px 0px;
   padding:0pt 0pt 0pt 16px;
   min-height:22px;
}

/* ***************************************
   Seleccionar evaluacion
*************************************** */

.rub_info {
   color: #808080;
   border-style: solid;
   border-color: #dcdcdc;
   border-width: 1px;
   margin-bottom: 15px;
   padding: 10px;
   -moz-border-radius: 3px 3px 15px 15px;
}

.rubricas_view {
   -moz-border-radius:8px 8px 8px 8px;
   background:none repeat scroll 0 0 white;
   margin:10px 10px 10px;
   padding:10px;
}

.rubricas_view h3 {
   font-size:150%;
   margin:0 0 10px;
   padding:0;
   font-weight:bold;
   color: #4690D6
}

.rubricas_view h5 {
   color: #AAAAAA;
   font-style: italic;
}

.rubricas_view .spratline {
   color:#AAAAAA;
   line-height:1em;
}
