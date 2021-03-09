<?php

gatekeeper();

$rubricpost = get_input('guid');

$rubric = get_entity($rubricpost);
$container = get_entity($rubric->container_guid);
$owner = get_entity($rubric->getOwnerGUID());
	
if ($rubric->getSubtype() == "rubric" && $rubric->canEdit()) {
   // Delete it!
   $deleted = $rubric->delete();
   if ($deleted > 0) {
      system_message(elgg_echo("rubric:deleted"));
   } else {
      register_error(elgg_echo("rubric:notdeleted"));
   }
   $url = elgg_get_site_url();
   if ($container instanceof ElggGroup) {
      forward($url . 'rubric/group/' . $container->username);
   } else {
      forward($url . 'rubric/owner/' . $owner->username);
   }
}
	
?>
