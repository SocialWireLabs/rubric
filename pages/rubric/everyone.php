<?php

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('rubrics'));

elgg_register_title_button();

$offset = get_input('offset');		
if (empty($offset)) {
   $offset = 0;
}		
$limit = 10;

$rubrics = elgg_get_entities(array('type'=>'object','subtype'=>'rubric','limit'=>false,'order_by'=>'e.time_created desc'));

if (empty($rubrics)) {
   $num_rubrics=0;
} else {
   $num_rubrics=count($rubrics);
}

$k=0;
$item=$offset;
$rubrics_range=array();
while (($k<$limit)&&($item<$num_rubrics)){
   $rubrics_range[$k]=$rubrics[$item];
   $k=$k+1;
   $item=$item+1;
}
   
if ($num_rubrics>0){
   $vars=array('count'=>$num_rubrics,'limit'=>$limit,'offset'=>$offset,'full_view'=>false);
   $content .= elgg_view_entity_list($rubrics_range,$vars);
} else {
   $content = '<p>' . elgg_echo('rubric:none') . '</p>';
}

$title = elgg_echo('rubric:all');

$body = elgg_view_layout('content', array('filter_context' => 'all','content' => $content,'title' => $title));

echo elgg_view_page($title, $body);
		
?>