<?php

gatekeeper();
if (is_callable('group_gatekeeper')) 
   group_gatekeeper();

$rubricpost = get_input('rubricpost');
$rubric = get_entity($rubricpost);
$user_guid = elgg_get_logged_in_user_guid();
$user = get_entity($user_guid);

$container_guid = $rubric->container_guid;
$container = get_entity($container_guid);

$page_owner = $container;
if (elgg_instanceof($container, 'object')) {
   $page_owner = $container->getContainerEntity();
}
elgg_set_page_owner_guid($page_owner->getGUID());

if (elgg_instanceof($container, 'group')) {
   elgg_push_breadcrumb($container->name, "rubric/group/$container->guid/all");
} else {
   elgg_push_breadcrumb($container->name, "rubric/owner/$container->username");
}
elgg_push_breadcrumb($rubric->title, $rubric->getURL());
elgg_push_breadcrumb(elgg_echo('edit'));

if ($rubric && $rubric->canEdit()){
   $title = elgg_echo('rubric:editpost');
   $content = elgg_view('forms/rubric/edit', array('entity' => $rubric));
} 

$body = elgg_view_layout('content', array('filter' => '','content' => $content,'title' => $title));
echo elgg_view_page($title, $body);
		
?>