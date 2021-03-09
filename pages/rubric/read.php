<?php

gatekeeper();
if (is_callable('group_gatekeeper')) 
   group_gatekeeper();

$rubricpost = get_input('rubricpost');
$rubric = get_entity($rubricpost);

if ($rubric) {
   elgg_set_page_owner_guid($rubric->getContainerGUID());
   $container = elgg_get_page_owner_entity();

   if (elgg_instanceof($container, 'group')) {
      elgg_push_breadcrumb($container->name, "rubric/group/$container->guid/all");
   } else {
      elgg_push_breadcrumb($container->name, "rubric/owner/$container->username");
   }
   elgg_push_breadcrumb($rubric->title);

   $title = elgg_echo('rubric:readpost');		

   $content = elgg_view('object/rubric',array('full_view' => true, 'entity' => $rubric));
   $content .= '<div id="comments">' . elgg_view_comments ($rubric) . '</div>';

   $body = elgg_view_layout('content', array('filter' => '','content' => $content,'title' => $title));

   echo elgg_view_page($title, $body);

} else {
   register_error( elgg_echo('rubric:notfound'));
   forward();
}
		
?>