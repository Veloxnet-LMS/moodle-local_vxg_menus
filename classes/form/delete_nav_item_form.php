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

namespace local_vxg_menus\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class delete_nav_item_form extends \moodleform
{

    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('static', 'confirm', get_string('delete_confirm', 'local_vxg_menus'), null);
        $mform->setType('confirm', PARAM_RAW);

        $mform->addElement('hidden', 'menuid');
        $mform->setType('menuid', PARAM_INT);

        $this->add_action_buttons(true, get_string('delete', 'local_vxg_menus'));

    }
}
