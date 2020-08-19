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

defined('MOODLE_INTERNAL') || die;

$string['pluginname'] = 'Vxg Menus';
$string['privacy:metadata'] = 'The Menus plugin does not store any personal data.';

// Remove nodes.
$string['setting_removemyhomenode']            = 'Home page';
$string['setting_removemyhomenode_desc']       = 'Hide Dashboard or Site home from the side navigation depending on what the user chose to be his home page.';
$string['setting_removehomenode']              = 'Site Home';
$string['setting_removehomenode_desc']         = 'Hide Site home from the side navigation.';
$string['setting_removecalendarnode']          = 'Calendar';
$string['setting_removecalendarnode_desc']     = 'Hide Calendar from the side navigation.';
$string['setting_removeprivatefilesnode']      = 'Private files';
$string['setting_removeprivatefilesnode_desc'] = 'Hide Private files from the side navigation.';
$string['setting_removemycoursesnode']         = 'My courses';
$string['setting_removemycoursesnode_desc']    = 'Hide My courses from the side navigation.';

$string['setting_removeparticipantsnode']      = 'Participants';
$string['setting_removeparticipantsnode_desc'] = 'Hide Participants from the navigation.';
$string['setting_removebadgesnode']            = 'Badges';
$string['setting_removebadgesnode_desc']       = 'Hide Badges from the navigation (Only if there are no badges in course).';

$string['setting_removecompetenciesnode']      = 'Competencies';
$string['setting_removecompetenciesnode_desc'] = 'Hide Competencies from the navigation (Only if there are no competencies in course).';
$string['setting_removegradesnode']            = 'Grades';
$string['setting_removegradesnode_desc']       = 'Hide Grades from the navigation.';

$string['hide_for_roles'] = 'With role';

// Headings.
$string['hide_side_menu_head'] = 'Hideing menu items form the side navigation from specified roles. If no role checked it will be hide form all users except Admin.
But there is an option to hide from Admin too.';
$string['hide_course_side_menu_head'] = 'Hideing menu items form the navigation wich are only visible in course pages';

// Menus.
$string['hide_menus']                 = 'Hide navigation items';
$string['setting_hide_to_admin']      = 'Hide to admin';
$string['setting_hide_to_admin_desc'] = '<br><br><br>';
$string['side_menus']                 = 'Side menu';
$string['custom_menu_items']          = 'Custom menu items';

// Custome nodes.
$string['all_menu']  = 'All Menu item';
$string['name']      = 'Name';
$string['name_help'] = 'The name that shown in the menu';
$string['lang']      = 'language';
$string['url']       = 'url';
$string['url_help']  = '<b>Example</b><br>if site is: "https://moodlesite.com"<br> url for profile is "user/profile.php"';
$string['icon']      = 'Icon';

$string['add_new']        = 'Add new';
$string['edit']           = 'Edit';
$string['delete']         = 'Delete';
$string['delete_confirm'] = 'Are you sure you want to delete this menu item?';
$string['disabled']       = 'Disable';
$string['disabled_help']       = 'If checked menu will not be shown';
$string['roles']          = 'Roles';
$string['front']          = 'After dashboard';
$string['back']           = 'After last menu';
$string['order']          = 'After';

// Icon-selection.
$string['select-icon'] = 'Choose Icon';
$string['iconselection'] = 'Icon selection';
