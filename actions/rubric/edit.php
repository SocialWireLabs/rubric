<?php

gatekeeper();

$rubric_guid = get_input('rubric_guid');
$rubric = get_entity($rubric_guid);

if ($rubric->getSubtype() == "rubric" && $rubric->canEdit()) {
   
   $user_guid = elgg_get_logged_in_user_guid();

   $title = get_input('title');
   $tags = get_input('rubrictags');
   $tagarray = string_to_tag_array($tags);
   $access_id = get_input('access_id');

   $rows = (int) get_input('rows');
   $cols = (int) get_input('cols');

   $criteria_value = get_input('criteria_value');
   $criteria_name = get_input('criteria_name');
   $criteria_desc = get_input('criteria_desc');
   $level_value = get_input('level_value');
   $level_desc = get_input('level_desc');
   $criteria_level_desc = get_input('criteria_level_desc');
   
   $container = get_entity($rubric->container_guid);  

   // Cache to the session
   elgg_make_sticky_form('edit_rubric');

   if (empty($title)) {
       register_error(elgg_echo("rubric:title_blank"));
       forward($_SERVER['HTTP_REFERER']);
   }

   if (!empty($criteria_value)){
      if (is_array($criteria_value)){
         foreach ($criteria_value as $one_criteria_value){
            if (!is_numeric($one_criteria_value)){
	       register_error(elgg_echo("rubric:error_criteria_value"));
               forward($_SERVER['HTTP_REFERER']);
	    }
         }
      } else {
         if (!is_numeric($criteria_value)){
            register_error(elgg_echo("rubric:error_criteria_value"));
            forward($_SERVER['HTTP_REFERER']);
         }
      }
   }
   if (array_sum($criteria_value) != 100) {
      register_error(elgg_echo("rubric:error_criteria_sum"));
      forward($_SERVER['HTTP_REFERER']);
   }

   if (!empty($level_value)){
      if (is_array($level_value)){
         foreach ($level_value as $one_level_value){
            if (!is_numeric($one_level_value)){
	       register_error(elgg_echo("rubric:error_level_value"));
               forward($_SERVER['HTTP_REFERER']);
	    }
         }
      } else {
         if (!is_numeric($level_value)){
            register_error(elgg_echo("rubric:error_level_value"));
            forward($_SERVER['HTTP_REFERER']);
         }
      }
   }
   if (max($level_value) > 100) {
      register_error(elgg_echo("rubric:error_level_value"));
      forward($_SERVER['HTTP_REFERER']);
   }

   if (!empty($criteria_name)){
      if (is_array($criteria_name)){
         foreach ($criteria_name as $one_criteria_name){
            if (empty($one_criteria_name)){
	       register_error(elgg_echo("rubric:error_criteria_name"));
               forward($_SERVER['HTTP_REFERER']);
	    }
         }
      } 
   } else {
      register_error(elgg_echo("rubric:error_criteria_name"));
      forward($_SERVER['HTTP_REFERER']);
   }

   if (!empty($level_desc)){
      if (is_array($level_desc)){
         foreach ($level_desc as $one_level_desc){
            if (empty($one_level_desc)){
	       register_error(elgg_echo("rubric:error_level_desc"));
               forward($_SERVER['HTTP_REFERER']);
	    }
         }
      } 
   } else {
      register_error(elgg_echo("rubric:error_level_desc"));
      forward($_SERVER['HTTP_REFERER']);
   }

   $criteria_value = implode(chr(26),$criteria_value);
   $criteria_name = implode(chr(26),$criteria_name);
   $criteria_desc = implode(chr(26),$criteria_desc);
   $level_value = implode(chr(26),$level_value);
   $level_desc = implode(chr(26),$level_desc);
   $criteria_level_desc = implode(chr(26),$criteria_level_desc);

   // Get owning user
   $owner = get_entity($rubric->getOwnerGUID());

   $rubric->access_id = $access_id;

   $rubric->title = $title;

   // Save the rubric post
   if (!$rubric->save()) {
      register_error(elgg_echo("rubric:error_save"));
      forward($_SERVER['HTTP_REFERER']);
   }
   
   $rubric->rows = $rows;
   $rubric->cols = $cols;
   $rubric->criteria_value = $criteria_value;
   $rubric->criteria_name = $criteria_name;
   $rubric->criteria_desc = $criteria_desc;
   $rubric->level_value = $level_value;
   $rubric->level_desc = $level_desc;
   $rubric->criteria_level_desc = $criteria_level_desc;

   if (is_array($tagarray)) {
      $rubric->tags = $tagarray;
   }

   // Remove the rubric post cache
   elgg_clear_sticky_form('edit_rubric');
  		 
   //Success message
   system_message(elgg_echo("rubric:updated"));
   // Add to river
   //add_to_river('river/object/rubric/update','update',$user_guid,$rubric_guid);
   
   // Forward
   $url = elgg_get_site_url();
   if ($container instanceof ElggGroup) {
      forward($url . "rubric/group/" . $container->getGUID());
   } else {
      forward($url . "rubric/owner/" . $owner->username);
   }
}
?>
