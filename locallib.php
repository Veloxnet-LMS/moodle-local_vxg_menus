<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

function local_vxg_menus_get_all_childrenkeys(navigation_node $navigationnode)
{
    // Empty array to hold all children.
    $allchildren = array();

    // No, this node does not have children anymore.
    if (count($navigationnode->children) == 0) {
        return array();

        // Yes, this node has children.
    } else {
        // Get own own children keys.
        $childrennodeskeys = $navigationnode->get_children_key_list();
        // Get all children keys of our children recursively.
        foreach ($childrennodeskeys as $ck) {
            $allchildren = array_merge($allchildren, local_vxg_menus_get_all_childrenkeys($navigationnode->get($ck)));
        }
        // And add our own children keys to the result.
        $allchildren = array_merge($allchildren, $childrennodeskeys);

        // Return everything.
        return $allchildren;
    }
}

function local_vxg_menus_get_assignable_roles()
{
    global $DB;

    $role_ids = $DB->get_fieldset_select('role_context_levels', 'roleid',
        'contextlevel = ? OR contextlevel = ? OR contextlevel = ?', array('10', '40', '50'));

    $insql = 'IN (' . implode(',', $role_ids) . ')';

    $sql = 'SELECT shortname FROM {role} WHERE id ' . $insql . ' ORDER BY id';

    $role_names = $DB->get_fieldset_sql($sql);

    $role_names = array_combine(array_values($role_names), array_values($role_names));

    return $role_names;

}

function local_vxg_menus_get_user_role_names()
{
    global $USER, $COURSE;

    $user_roles = get_user_roles(context_course::instance($COURSE->id), $USER->id);

    $role_names = array();
    foreach ($user_roles as $role) {
        $role_names[] = $role->shortname;
    }

    return $role_names;

}

function local_vxg_menus_get_user_role_ids()
{
    global $USER, $COURSE;

    $user_roles = get_user_roles(context_course::instance($COURSE->id), $USER->id);

    $role_ids = array();
    foreach ($user_roles as $role) {
        $role_ids[] = $role->roleid;
    }

    return $role_ids;

}

function local_vxg_menus_add_new_navigation_nodes(global_navigation $nav)
{
    global $DB, $PAGE, $COURSE, $CFG;


    $user_roles = local_vxg_menus_get_user_role_ids();

    $nodes_data = $DB->get_records('vxg_menu');

    foreach ($nodes_data as $node_data) {
        if ($nav) {

            // if disabled not show
            if ($node_data->disabled) {
                continue;
            }

            // check is user has a role for this menu
            $user_hasrole = false;
            if ($node_roles = $DB->get_records('vxg_right', array('objecttype' => 'menu', 'objectid' => $node_data->id))) {
                foreach ($node_roles as $node_role) {
                    if (in_array($node_role->roleid, $user_roles)) {
                        $user_hasrole = true;
                        continue;
                    }
                }
            } else {
                $user_hasrole = true;
            }

            $iconarr = explode('/', $node_data->icon,2);
            // Create node
            if ($user_hasrole || is_siteadmin()) {
                $id    = $node_data->id;
                $name  = $node_data->name;
                $url   = new moodle_url('/' . $node_data->url);
                $order = $node_data->menu_order;

                if (isset($node_data->icon) && !empty($node_data->icon)) {
                    $icon = new pix_icon($iconarr[1], $name, $iconarr[0]);
                } else {
                    $icon = new pix_icon('t/edit_menu', $name);
                }

                $newnode = navigation_node::create(
                    $name,
                    $url,
                    navigation_node::NODETYPE_LEAF,
                    $name,
                    'vxg_' . $id,
                    $icon
                );

                // Make visible in flatnav
                $newnode->showinflatnavigation = true;

                if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
                    $newnode->make_active();
                }

                if ($order == 1) {
                    // get the first node to add before that 
                    $first_node = $nav->get_children_key_list()[0];
                    $nav->add_node($newnode, $first_node);
                    // $nav->add_node($newnode);
                } else {
                    $nav->add_node($newnode);
                }
            }
        }

    }
}

function local_vxg_menus_get_role_id($shortname)
{
    global $DB;

    $role = $DB->get_record('role', array('shortname' => $shortname));

    return $role->id;

}

function local_vxg_menus_get_role_shortname($id)
{
    global $DB;

    $role = $DB->get_record('role', array('id' => $id));

    return $role->shortname;

}
