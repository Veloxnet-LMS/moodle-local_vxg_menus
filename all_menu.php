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

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir . '/tablelib.php');

global $DB, $OUTPUT, $PAGE;

admin_externalpage_setup('local_vxg_all_menu');

$PAGE->set_heading(get_string('all_menu', 'local_vxg_menus'));
$PAGE->set_title(get_string('all_menu', 'local_vxg_menus'));

$table = new table_sql('local_vxg_menus_table');

echo $OUTPUT->header();

$addurl = new moodle_url('/local/vxg_menus/addnavigationitem.php');
echo html_writer::link($addurl, html_writer::tag('button', get_string('add_new', 'local_vxg_menus'), array('class' => 'btn btn-primary')));

$table_headers = array(
        '',
        get_string('name', 'local_vxg_menus'),
        get_string('lang', 'local_vxg_menus'),
        'url',
    );


$table->define_headers($table_headers);

$url = new moodle_url('local/vxg_menus/all_menu.php');
$table->define_columns(array( '', 'name', 'lang', 'url',));
$table->define_baseurl($url);
$table->sortable(false);
$table->collapsible(false);
$table->setup();
$class = '';

$menus = $DB->get_records('vxg_menu');

foreach ($menus as $menu) {

	$row = array();
	$class = '';
    // Edit
    $edit_url = new moodle_url('/local/vxg_menus/addnavigationitem.php', array('menuid' => $menu->id));
    // Delete
    $delete_url = new moodle_url('/local/vxg_menus/delete_menu.php', array('menuid' => $menu->id));
    $deletepicurl = new moodle_url('/pix/t/delete.svg');
    $delete_link = html_writer::link($delete_url, $OUTPUT->pix_icon('t/delete', get_string('delete', 'local_vxg_menus')));
    
    $row[] = $delete_link;
    $row[] = html_writer::link($edit_url, $menu->name);
    $row[] = $menu->lang;
    $row[] = $menu->url;

    $table->add_data($row, $class);

}
$table->finish_output();
echo $OUTPUT->footer();
