<?php

function rubric_init() {

   // Extend system CSS with our own styles, which are defined in the rubric/css view
   elgg_extend_view('css/elgg','rubric/css');
								
   // Register a page handler, so we can have nice URLs
   elgg_register_page_handler('rubric','rubric_page_handler');
				
   // Register entity type
   elgg_register_entity_type('object','rubric');

   // Register a URL handler for rubric posts
   elgg_register_plugin_hook_handler('entity:url','object','rubric_url');
								
   // Show rubrics in groups
   add_group_tool_option('rubric',elgg_echo('rubric:enable_group_rubrics'),false);
   //elgg_extend_view('groups/tool_latest', 'rubric/group_module');
   
   // Advanced permissions
   elgg_register_plugin_hook_handler('permissions_check', 'object', 'rubric_permissions_check');

   // Register library
   elgg_register_library('rubric', elgg_get_plugins_path() . 'rubric/lib/rubric_lib.php');

   // Add a menu item to the user ownerblock
   elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'rubric_owner_block_menu');
}

function rubric_permissions_check($hook, $type, $return, $params) {
   if (($params['entity']->getSubtype() == 'rubric')||($params['entity']->getSubtype() == 'rubric_rating')) {
      $user_guid = elgg_get_logged_in_user_guid();
      $group_guid = $params['entity']->container_guid;
      $group = get_entity($group_guid);
      if ($group instanceof ElggGroup) {
         $group_owner_guid = $group->owner_guid;
         $operator=false;
         if (($group_owner_guid==$user_guid)||(check_entity_relationship($user_guid,'group_admin',$group_guid))){
            $operator=true;
         }
         if ($operator){
            return true;
	 }   
      }
   }	
}
		
/**
 * Add a menu item to the user ownerblock
*/
function rubric_owner_block_menu($hook, $type, $return, $params) {
   if (!elgg_instanceof($params['entity'], 'user')) {
      if ($params['entity']->rubric_enable != "no") {
         $url = "rubric/group/{$params['entity']->guid}/all";
         $item = new ElggMenuItem('rubric', elgg_echo('rubric:group'), $url);
         $return[] = $item;
      }
   }
   return $return;
}
/**
* Rubric page handler; allows the use of fancy URLs
*
* @param array $page from the page_handler function
* @return true|false depending on success
**/
function rubric_page_handler($page) {			
   if (isset($page[0])) {
      elgg_push_breadcrumb(elgg_echo('rubrics'));
      $base_dir = elgg_get_plugins_path() . 'rubric/pages/rubric';
      switch ($page[0]) {
         case "view":
            set_input('rubricpost', $page[1]);
            include "$base_dir/read.php";
            break;
         case "owner":
            set_input('username', $page[1]);
            include "$base_dir/index.php";
            break;
         case "group":
            set_input('container_guid', $page[1]);
            include "$base_dir/index.php";
            break;
         case "friends":
            include "$base_dir/friends.php";
            break;
         case "all":
            include "$base_dir/everyone.php";
            break;
         case "add":
            set_input('container_guid', $page[1]);
            include "$base_dir/add.php";
            break;
         case "edit":
            set_input('rubricpost', $page[1]);
            include "$base_dir/edit.php";
            break;
         default:
            return false;
      }
   } else {
      forward();
   }
   return true;
}

/**
* Populates the ->getUrl() method for rubric objects
*
* @param string $hook   'entity:url'
* @param string $type   'object'
* @param string $url    The current URL
* @param array  $params Hook parameters
* @return string rubric post URL
**/
function rubric_url($hook, $type, $url, $params) {
  $entity = $params['entity'];
  // Check that the entity is a rubric object
  if ($entity->getSubtype() !== 'rubric') {
    // This is not a rubric object, so there's no need to go further
    return;
  }
  $title = elgg_get_friendly_title($entity->title);
  $url = elgg_get_config('url');
  return $url . "rubric/view/" . $entity->getGUID() . "/" . $title;
}

function socialwire_rubric_get_rating ($student_id = null, $task_id = null, $professor_id = null) {
    $rubric_rates = elgg_get_entities_from_metadata(array(
            'type' => 'object',
            'subtype' => 'rubric_rating',
            'owner_guid' => $professor_id,
            'metadata_name_value_pairs' => array(
                    array('name' => 'student_guid', 'value' => $student_id),
                    array('name' => 'task_guid', 'value' => $task_id)),
            'metadata_case_sensitive' => false,
            'limit' => 0));
    return $rubric_rates[0];
}
					
// Make sure the rubric initialisation function is called on initialisation
elgg_register_event_handler('init','system','rubric_init');
		
// Register actions
$action_base = elgg_get_plugins_path() . 'rubric/actions/rubric';
elgg_register_action("rubric/add","$action_base/add.php");
elgg_register_action("rubric/edit","$action_base/edit.php");
elgg_register_action("rubric/delete","$action_base/delete.php");
elgg_register_action("rubric/rate","$action_base/rate.php");
elgg_register_action("rubric/copy","$action_base/copy.php");
				
?>
