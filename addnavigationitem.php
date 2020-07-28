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

require_once '../../config.php';
require_once $CFG->libdir . '/adminlib.php';
require_once 'forms.php';

global $DB;

$menuid = optional_param('menuid', 0, PARAM_INT);

admin_externalpage_setup('local_vxg_all_menu');

if ($menuid == 0) {
    $heading = get_string('add_new', 'local_vxg_menus');
} else {
    $heading = get_string('edit', 'local_vxg_menus');
}
$PAGE->set_title($heading);
$PAGE->set_heading($heading);

$PAGE->requires->js_call_amd('local_vxg_menus/icon_picker', 'init');
$PAGE->requires->css('/local/vxg_menus/styles.css');

$selected_roles = $DB->get_records('vxg_right', array('objecttype' => 'menu', 'objectid' => $menuid), '', 'roleid');

$selected_roles_array = array();
foreach ($selected_roles as $selected_role) {
    $selected_roles_array[] = local_vxg_menus_get_role_shortname($selected_role->roleid);
}

if ($menuid != 0) {
    $menu = $DB->get_record('vxg_menu', array('id' => $menuid));
}

if (isset($menu) && !empty($menu->icon)) {
    $iconarr = explode('/', $menu->icon,2);
    $iconname = $iconarr[1];
    $iconcomp = $iconarr[0];
} else {
    $iconname = 't/edit_menu';
    $iconcomp = 'core';
}

$mform            = new local_add_nav_item_form(null, array('selected_roles' => $selected_roles_array, 'iconname' => $iconname, 'iconcomp' => $iconcomp));
$toform['menuid'] = $menuid;
$mform->set_data($toform);

$redirecturl = new moodle_url('/local/vxg_menus/all_menu.php');
if ($mform->is_cancelled()) {

    redirect($redirecturl);
} else if ($data = $mform->get_data()) {

    if ($menuid == 0) {

        $node             = new stdClass();
        $node->name       = $data->name;
        $node->lang       = $data->lang;
        $node->url        = $data->url;
        $node->disabled   = $data->disabled;
        $node->icon       = $data->icon;
        $node->menu_order = $data->menu_order;

        $newid = $DB->insert_record('vxg_menu', $node);

        if (isset($data->roles) && !empty($data->roles)) {

            foreach ($data->roles as $shortname) {
                $roleid = local_vxg_menus_get_role_id($shortname);

                $roles             = new stdClass();
                $roles->objecttype = 'menu';
                $roles->roleid     = $roleid;
                $roles->objectid   = $newid;

                $DB->insert_record('vxg_right', $roles);

            }
        }

    } else {

        $node             = new stdClass();
        $node->id         = $menuid;
        $node->name       = $data->name;
        $node->lang       = $data->lang;
        $node->url        = $data->url;
        $node->disabled   = $data->disabled;
        $node->icon       = $data->icon;
        $node->menu_order = $data->menu_order;

        $DB->update_record('vxg_menu', $node);
        $DB->delete_records('vxg_right', array('objecttype' => 'menu', 'objectid' => $menuid));

        if (isset($data->roles) && !empty($data->roles)) {

            foreach ($data->roles as $shortname) {
                $roleid = local_vxg_menus_get_role_id($shortname);

                $roles             = new stdClass();
                $roles->objecttype = 'menu';
                $roles->roleid     = $roleid;
                $roles->objectid   = $node->id;

                $DB->insert_record('vxg_right', $roles);

            }
        }
    }

    redirect($redirecturl);
}

echo $OUTPUT->header();
if ($menuid != 0) {
    $mform->set_data($menu);
}
$mform->display();
echo $OUTPUT->footer();
