<?php

$full = elgg_extract('full_view', $vars, FALSE);
$rubric = elgg_extract('entity', $vars, FALSE);
$rubricpost = $rubric->getGUID();

if (!$rubric) {
   return TRUE;
}

$user_guid = elgg_get_logged_in_user_guid();
$user = get_entity($user_guid);
$user_name = $user->name;
$owner = $rubric->getOwnerEntity();
$owner_guid = $owner->getGUID();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array('href' => $owner->getURL(),'text' => $owner->name,'is_trusted' => true));
$author_text = elgg_echo('byline', array($owner_link));
$tags = elgg_view('output/tags', array('tags' => $rubric->tags));
$date = elgg_view_friendly_time($rubric->time_created);
$metadata = elgg_view_menu('entity', array('entity' => $rubric,'handler' => 'rubric','sort_by' => 'priority','class' => 'elgg-menu-hz'));
$subtitle = "$author_text $date $comments_link";

if ($full) {
   $params = array('entity' => $rubric,'title' => $title,'metadata' => $metadata,'subtitle' => $subtitle,'tags' => $tags);
   $params = $params + $vars;
   $summary = elgg_view('object/elements/summary', $params);
   $body = "";

   //Import
   $user_groups = array();
   $user_groups = elgg_get_entities(array('type' => 'group', 'subtype' => 0, 'limit' => false, 'owner_guid' => $user_guid));
$options = array('relationship' => 'group_admin', 'relationship_guid' => $user_guid,'inverse_relationship' => false, 'type' => 'group');
   $other_user_groups = elgg_get_entities_from_relationship($options);
   if ($user_groups) {
      $user_groups = array_merge($user_groups,$other_user_groups);
   } else {
      $user_groups = $other_user_groups;
   }

   $select = "<select name=\"container_guid\">";
   $select .= "<option value=\"$user_guid\">$user_name </option>"; 
   foreach ($user_groups as $one_user_group){
      $one_user_group_guid = $one_user_group->getGUID();
      $one_user_group_name = $one_user_group->name;
      $select .= "<option value=\"$one_user_group_guid\">$one_user_group_name </option>"; 
   }
   $select .= "</select>";

   $body_form = "<br>" . elgg_echo("rubric:copy_to") . ": ";

   $body_form .= $select . "<br><br>";

   $body_form .= elgg_view('input/hidden', array('name' => 'rubricpost', 'value' => $rubricpost));

   $body_form .= elgg_view('input/submit', array('value' => elgg_echo("rubric:copy"), 'name' => 'submit'));
	
   $url = elgg_get_site_url();
   $show_body_form = elgg_view('input/form', array('action' => $url . "action/rubric/copy", 'body' => $body_form, 'enctype' => 'multipart/form-data'));

   $show_body_form .= elgg_view('input/securitytoken');
   
   $body = $show_body_form;

   $body .= elgg_view('rubric/show_rubric', array('entity' => $rubric, 'view_type' => 'show'));
   echo elgg_view('object/elements/full', array('summary' => $summary,'icon' => $owner_icon,'body' => $body));

} else {
   $params = array('entity' => $rubric,'title' => $title, 'metadata' => $metadata,'subtitle' => $subtitle,'tags' => $tags);
   $params = $params + $vars;
   $list_body = elgg_view('object/elements/summary', $params);
   echo elgg_view_image_block($owner_icon, $list_body);
}

?>
