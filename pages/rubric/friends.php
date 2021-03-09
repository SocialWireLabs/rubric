<?php

$owner = elgg_get_page_owner_entity();
if (!$owner) {
   forward('rubric/all');
}

elgg_push_breadcrumb($owner->name, "rubric/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$offset = get_input('offset');		
if (empty($offset)) {
   $offset = 0;
}
$limit = 10;
		
$rubrics = elgg_get_entities_from_relationship(array(
   'relationship_guid' => $owner->getGUID(),
   'type' => 'object',
   'subtype'=> 'rubric',
   'offset'=> 0,
   'limit'=> false,
   'relationship' => 'friend',
   'relationship_join_on' => 'container_guid',
));

if ($rubrics) {
   $num_rubrics = count($rubrics);
} else {
   $num_rubrics = 0;
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
   $content = elgg_echo('rubric:none');
}

$title = elgg_echo('rubric:user:friends',array($owner->name));

$params = array('filter_context' => 'friends','content' => $content,'title' => $title);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
		
?>
