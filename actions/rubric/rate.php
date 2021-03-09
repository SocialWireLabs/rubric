<?php

gatekeeper();

$rubric_rating_guid = get_input('rating_guid', false);

$user_guid = elgg_get_logged_in_user_guid();

// Get input data
$container_guid = get_input('container_guid');
$rubric_guid = get_input('rubric_guid');
$rubric = get_entity($rubric_guid);
$student_guid = get_input('student_guid');
$task_guid = get_input('task_guid');
$this_coordinates = get_input('coordinates');
$this_coordinates = explode(";",$this_coordinates);
$coordinates = array();
$i=0;
foreach ($this_coordinates as $coordinate){
   $coordinates[$i] = $coordinate;
   $i=$i+1;
}
$percentage = get_input('percentage');

if (!$rubric_rating_guid) {
   $rating = new ElggObject();
   $rating->subtype = 'rubric_rating';
   $rating->owner_guid = $user_guid;
   $rating->container_guid = $container_guid;
   $container = get_entity($container_guid);
   if ($container instanceof ElggGroup)
       $rating->access_id = $container->group_acl;
   $rating->rubric_guid = $rubric_guid;
   $rating->task_guid = $task_guid;
   $rating->student_guid = $student_guid;
   $rating->coordinates = $coordinates;
   $rating->percentage = $percentage;
   if (!$rating->save()) {
      register_error(elgg_echo("rubric:rating_error_save"));
      forward($_SERVER['HTTP_REFERER']);
   }
} else {
   //$access = elgg_set_ignore_access(true);     
   $rating = get_entity($rubric_rating_guid);
   $rating->coordinates = $coordinates;
   $rating->percentage = $percentage;
   //elgg_set_ignore_access($access);
}

// Success message
system_message(elgg_echo("rubric:rated"));
forward(REFERER);

?>
