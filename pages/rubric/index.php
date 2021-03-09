<?php

gatekeeper();
if (is_callable('group_gatekeeper')) 
   group_gatekeeper();

$owner = elgg_get_page_owner_entity();

if (!$owner) {
   forward('rubric/all');
}

$owner_guid = $owner->getGUID();

elgg_push_breadcrumb($owner->name);

if ($owner instanceof ElggGroup){
   $operator=false;
   $group_guid = $owner_guid;
   $group = get_entity($group_guid);
   $group_owner_guid = $group->owner_guid;
   $user_guid = elgg_get_logged_in_user_guid();
   if (($group_owner_guid==$user_guid)||(check_entity_relationship($user_guid,'group_admin',$group_guid))){
      $operator=true;
   }
   if ($operator){
      elgg_register_title_button('rubric','add');
   }
} else {
   elgg_register_title_button('rubric','add');
}

$offset = get_input('offset');
if (empty($offset)) {
   $offset = 0;
}
$limit = 10;

$rubrics = elgg_get_entities(array('type'=>'object','subtype'=>'rubric','limit'=>false,'container_guid'=>$owner_guid,'order_by'=>'e.time_created desc'));

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

$title = elgg_echo('rubric:user', array($owner->name));

$filter_context = '';
if ($owner->getGUID() == elgg_get_logged_in_user_guid()) {
   $filter_context = 'mine';
}

$params = array('filter_context' => $filter_context,'content' => $content,'title' => $title,
);

if (elgg_instanceof($owner, 'group')) {
        $params['filter'] = '';
}

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
		
?>