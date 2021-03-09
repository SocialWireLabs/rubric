<?php

$group = elgg_get_page_owner_entity();
$group_guid = $group->getGUID();
if ($group->rubric_enable == "no") {
	return true;
}

elgg_push_context('widgets');

$limit = 6; 

$rubrics = elgg_get_entities(array('type'=>'object','subtype'=>'rubric','limit'=>false,'container_guid'=>$group_guid,'order_by'=>'e.time_created desc'));

$i=0;
foreach($rubrics as $rubric) {
   if ($i==$limit)
      break;
   $content .= elgg_view('object/rubric', array('full_view' => false, 'entity' => $rubric));
   $i=$i+1;
}

elgg_pop_context();

if (!$content) {
   $content = '<p>' . elgg_echo('rubric:none') . '</p>';
}

$all_link = elgg_view('output/url', array('href' => "rubric/group/$group_guid/",'text' => elgg_echo('link:view:all'),'is_trusted' => true));

$new_link = elgg_view('output/url', array('href' => "rubric/add/$group_guid",'text' => elgg_echo('rubric:add'),'is_trusted' => true));

echo elgg_view('groups/profile/module', array('title' => elgg_echo('rubric:group'),'content' => $content,'all_link' => $all_link,'add_link' => $new_link));

?>
