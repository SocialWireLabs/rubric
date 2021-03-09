<?php

gatekeeper();

$rubricpost = get_input('rubricpost');
$rubric = get_entity($rubricpost);
$container_guid = get_input('container_guid');
$container = get_entity($container_guid); 
$user_guid = elgg_get_logged_in_user_guid();

// Initialise a new ElggObject
$new_rubric = new ElggObject();

$new_rubric->subtype = "rubric";

$new_rubric->owner_guid = $user_guid;
$new_rubric->container_guid = $container_guid;
if ($container instanceof ElggGroup)
   $new_rubric->access_id = $container->group_acl;
else
   $new_rubric->access_id = 0;
$new_rubric->title = $rubric->title;

// Save the rubric post
if (!$new_rubric->save()) {
   register_error(elgg_echo("rubric:error_save"));
   forward($_SERVER['HTTP_REFERER']);
}

$new_rubric->rows = $rubric->rows;
$new_rubric->cols = $rubric->cols;
$new_rubric->criteria_value = $rubric->criteria_value;
$new_rubric->criteria_name = $rubric->criteria_name;
$new_rubric->criteria_desc = $rubric->criteria_desc;
$new_rubric->level_value = $rubric->level_value;
$new_rubric->level_desc = $rubric->level_desc;
$new_rubric->criteria_level_desc = $rubric->criteria_level_desc;
$new_rubric->tags = $rubric->tags;

// Success message
system_message(elgg_echo("rubric:copied"));
forward(REFERER);

?>
