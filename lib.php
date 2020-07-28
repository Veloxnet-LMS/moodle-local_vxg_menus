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

require_once(__DIR__ . '/locallib.php');
require_once($CFG->libdir . '/badgeslib.php');

function local_vxg_menus_extend_settings_navigation(settings_navigation $settingsnav, context $context)
{
    return; // Not used anymore!
}

function local_vxg_menus_extend_navigation(global_navigation $nav)
{

    global $CFG, $PAGE, $COURSE, $USER;

    // Get vxg_menus config and user roles
    $config     = get_config('local_vxg_menus');
    $role_names = local_vxg_menus_get_user_role_names();

    // MYHOME

    // If setting checked hide role
    if (isset($config->removemyhomenode) && $config->removemyhomenode == true && !is_siteadmin()) {
        // Make form roles that are checked
        if (isset($config->myhomeroles) && !empty($config->myhomeroles)) {
            $usermyhomeroles = explode(',', $config->myhomeroles);
        }
        // if any role checked hide only for that role
        if (isset($usermyhomeroles) && !empty($usermyhomeroles) && !empty($role_names)) {
            foreach ($role_names as $role) {
                if (in_array($role, $usermyhomeroles)) {
                    $nav->showinflatnavigation = false;
                } else {
                    $nav->showinflatnavigation = true;
                    // If user has one role that are not in the cecked roles show menu
                    break;
                }
            }
        } else {
            // If no role checked hide to everyone
            $nav->showinflatnavigation = false;
        }
    }
    // Hide to admin
    if (isset($config->removemyhomenodeadmin) && $config->removemyhomenodeadmin == true && is_siteadmin()) {
        $nav->showinflatnavigation = false;
    }

    // HOME

    if (isset($config->removehomenode) && $config->removehomenode == true && !is_siteadmin()) {
        if (isset($config->homeroles) && !empty($config->homeroles)) {
            $userhomeroles = explode(',', $config->homeroles);
        }

        if ($navigation = $nav->get('home')) {

            if (isset($userhomeroles) && !empty($userhomeroles) && !empty($role_names)) {
                foreach ($role_names as $role) {
                    if (in_array($role, $userhomeroles)) {
                        $navigation->showinflatnavigation = false;
                    } else {
                        $navigation->showinflatnavigation = true;
                        break;
                    }
                }
            } else {
                $navigation->showinflatnavigation = false;
            }

        }

    }

    // Hide to admin
    if (isset($config->removehomenodeadmin) && $config->removehomenodeadmin == true && is_siteadmin()) {
        if ($navigation = $nav->get('home')) {
            $navigation->showinflatnavigation = false;
        }
    }

    // CALENDAR

    if (isset($config->removecalendarnode) && $config->removecalendarnode == true && !is_siteadmin()) {
        if (isset($config->calendarroles) && !empty($config->calendarroles)) {
            $usercalendarroles = explode(',', $config->calendarroles);
        }

        if ($navigation = $nav->find('calendar', global_navigation::TYPE_CUSTOM)) {

            if (isset($usercalendarroles) && !empty($usercalendarroles) && !empty($role_names)) {

                foreach ($role_names as $role) {
                    if (in_array($role, $usercalendarroles)) {
                        $navigation->showinflatnavigation = false;

                    } else {
                        $navigation->showinflatnavigation = true;
                        break;
                    }
                }
            } else {
                $navigation->showinflatnavigation = false;
            }
        }
    }
    // Hide to admin
    if (isset($config->removecalendaradmin) && $config->removecalendaradmin == true && is_siteadmin()) {
        if ($navigation = $nav->find('calendar', global_navigation::TYPE_CUSTOM)) {
            $navigation->showinflatnavigation = false;
        }
    }

    // PRIVATEFILES

    if (isset($config->removeprivatefilesnode) && $config->removeprivatefilesnode == true && !is_siteadmin()) {

        if (isset($config->privatefilesroles) && !empty($config->privatefilesroles)) {
            $userprivatefilesroles = explode(',', $config->privatefilesroles);
        }

        if ($navigation = $nav->find('privatefiles', global_navigation::TYPE_SETTING)) {

            if (isset($userprivatefilesroles) && !empty($userprivatefilesroles) && !empty($role_names)) {
                foreach ($role_names as $role) {
                    if (in_array($role, $userprivatefilesroles)) {
                        $navigation->showinflatnavigation = false;
                    } else {
                        $navigation->showinflatnavigation = true;
                        break;
                    }
                }
            } else {
                $navigation->showinflatnavigation = false;
            }
        }
    }

    // Hide to admin
    if (isset($config->removeprivatefilesnodeadmin) && $config->removeprivatefilesnodeadmin == true && is_siteadmin()) {
        if ($navigation = $nav->find('privatefiles', global_navigation::TYPE_SETTING)) {
            $navigation->showinflatnavigation = false;
        }
    }

    // MYCOURSES

    if (isset($config->removemycoursesnode) && $config->removemycoursesnode == true && !is_siteadmin()) {

        $mycoursesnode = $nav->get('mycourses');
        // Get mycourses menus
        $mycourseschildrennodeskeys = $mycoursesnode->get_children_key_list();

        if ($mycoursesnode) {

            if (isset($config->mycoursesroles) && !empty($config->mycoursesroles)) {
                $usermycoursesroles = explode(',', $config->mycoursesroles);
            }

            if (isset($usermycoursesroles) && !empty($usermycoursesroles) && !empty($role_names)) {

                foreach ($role_names as $role) {
                    if (in_array($role, $usermycoursesroles)) {
                        $mycoursesnode->showinflatnavigation = false;

                    } else {
                        $mycoursesnode->showinflatnavigation = true;
                        break;
                    }
                }
            } else {
                $mycoursesnode->showinflatnavigation = false;
            }
            // Hide courses under My courses
            if (!$mycoursesnode->showinflatnavigation) {

                foreach ($mycourseschildrennodeskeys as $child) {

                    if ($CFG->navshowmycoursecategories) {

                        $allchildrennodes = local_vxg_menus_get_all_childrenkeys($mycoursesnode->get($child));

                        foreach ($allchildrennodes as $cn) {
                            $mycoursesnode->find($cn, null)->showinflatnavigation = false;
                        }

                    } else {
                        $mycoursesnode->get($child)->showinflatnavigation = false;
                    }
                }
            }
        }
    }
    // Hide to admin
    if (isset($config->removemycoursesnodeadmin) && $config->removemycoursesnodeadmin == true && is_siteadmin()) {
        if ($mycoursesnode = $nav->get('mycourses')) {
            $mycoursesnode->showinflatnavigation = false;
        }

        $mycourseschildrennodeskeys = $mycoursesnode->get_children_key_list();

        if (!$mycoursesnode->showinflatnavigation) {

            foreach ($mycourseschildrennodeskeys as $child) {

                if ($CFG->navshowmycoursecategories) {

                    $allchildrennodes = local_vxg_menus_get_all_childrenkeys($mycoursesnode->get($child));

                    foreach ($allchildrennodes as $cn) {
                        $mycoursesnode->find($cn, null)->showinflatnavigation = false;
                    }

                } else {
                    $mycoursesnode->get($child)->showinflatnavigation = false;
                }
            }
        }

    }

    // PARTICIPANTS

    if (isset($config->removeparticipantsnode) && $config->removeparticipantsnode == true && !is_siteadmin()) {

        if (isset($config->participantsroles) && !empty($config->participantsroles)) {
            $userparticipantsroles = explode(',', $config->participantsroles);
        }

        if ($PAGE->context->get_course_context(false) == true && $COURSE->id != SITEID) {

            if ($participantsnode = $nav->find('participants', global_navigation::TYPE_CONTAINER)) {
                // Remove participants node (Just hiding it with the showinflatnavigation attribute does not work here).

                if (isset($userparticipantsroles) && !empty($userparticipantsroles) && !empty($role_names)) {
                    foreach ($role_names as $role) {
                        if (in_array($role, $userparticipantsroles)) {
                            $participantsnode->remove();

                        }
                    }
                } else {
                    $participantsnode->remove();
                }
            }
        }
    }
    // Hide to admin
    if (isset($config->removeparticipantsnodeadmin) && $config->removeparticipantsnodeadmin == true && is_siteadmin()) {
        if ($PAGE->context->get_course_context(false) == true && $COURSE->id != SITEID) {
            if ($participantsnode = $nav->find('participants', global_navigation::TYPE_CONTAINER)) {
                $participantsnode->remove();
            }
        }
    }

    // BADGES

    if ($CFG->enablebadges == true &&
        isset($config->removebadgesnode) &&
        $config->removebadgesnode == true && !is_siteadmin()) {

        if ($PAGE->context->get_course_context(false) == true && $COURSE->id != SITEID) {
            // Check if there is any badge in the course.
            require_once $CFG->dirroot . '/lib/badgeslib.php';

            if (isset($config->badgesroles) && !empty($config->badgesroles)) {
                $userbadgesroles = explode(',', $config->badgesroles);
            }

            // Get number of badges in course.
            $totalbadges = count(badges_get_badges(BADGE_TYPE_COURSE, $PAGE->course->id, '', '', 0, 0));

            // Only if there are no badges in course.
            if ($totalbadges == 0) {
                if ($badgesnode = $nav->find('badgesview', global_navigation::TYPE_SETTING)) {

                    if (isset($userbadgesroles) && !empty($userbadgesroles) && !empty($role_names)) {
                        foreach ($role_names as $role) {
                            if (in_array($role, $userbadgesroles)) {
                                $badgesnode->remove();
                            }
                        }
                    } else {
                        $badgesnode->remove();
                    }
                }
            }
        }

    }
    // Hide to admin
    if (isset($config->removebadgesnodeadmin) && $config->removebadgesnodeadmin == true && is_siteadmin()) {
        if ($PAGE->context->get_course_context(false) == true && $COURSE->id != SITEID) {
            if ($badgesnode = $nav->find('badgesview', global_navigation::TYPE_SETTING)) {
                $totalbadges = count(badges_get_badges(BADGE_TYPE_COURSE, $PAGE->course->id, '', '', 0, 0));
                // Only if there are no badges in course.
                if ($totalbadges == 0) {
                    $badgesnode->remove();
                }

            }
        }

    }

    // COMPETENCIES

    if (get_config('core_competency', 'enabled') == true && isset($config->removecompetenciesnode)
        && $config->removecompetenciesnode == true && !is_siteadmin()) {

        if ($PAGE->context->get_course_context(false) == true && $COURSE->id != SITEID) {

            require_once $CFG->dirroot . '/competency/classes/course_competency.php';

            if (isset($config->competenciesroles) && !empty($config->competenciesroles)) {
                $usercompetenciesroles = explode(',', $config->competenciesroles);
            }

            $totalcompetencies = core_competency\course_competency::count_competencies($PAGE->course->id);

            if ($totalcompetencies == 0) {
                if ($competenciesnode = $nav->find('competencies', global_navigation::TYPE_SETTING)) {

                    if (isset($usercompetenciesroles) && !empty($usercompetenciesroles) && !empty($role_names)) {
                        foreach ($role_names as $role) {
                            if (in_array($role, $usercompetenciesroles)) {
                                $competenciesnode->remove();
                            }
                        }
                    } else {
                        $competenciesnode->remove();
                    }
                }
            }
        }

    }

    // Hide to admin
    if (isset($config->removecompetenciesnodeadmin) && $config->removecompetenciesnodeadmin == true && is_siteadmin()) {
        if ($PAGE->context->get_course_context(false) == true && $COURSE->id != SITEID) {
            if ($competenciesnode = $nav->find('competencies', global_navigation::TYPE_SETTING)) {
                require_once $CFG->dirroot . '/competency/classes/course_competency.php';

                if (isset($config->competenciesroles) && !empty($config->competenciesroles)) {
                    $usercompetenciesroles = explode(',', $config->competenciesroles);
                }
                // Only if there are no competencies in course
                $totalcompetencies = core_competency\course_competency::count_competencies($PAGE->course->id);

                if ($totalcompetencies == 0) {
                    $competenciesnode->remove();
                }
            }
        }
    }

    // GRADES
    if (isset($config->removegradesnode) && $config->removegradesnode == true) {

        if (isset($config->gradesroles) && !empty($config->gradesroles)) {
            $usergradesroles = explode(',', $config->gradesroles);
        }

        if ($PAGE->context->get_course_context(false) == true && $COURSE->id != SITEID) {
            if ($gradesnode = $nav->find('grades', global_navigation::TYPE_SETTING)) {

                if (isset($usergradesroles) && !empty($usergradesroles) && !empty($role_names)) {
                    foreach ($role_names as $role) {
                        if (in_array($role, $usergradesroles)) {
                            $gradesnode->remove();
                        }
                    }
                } else {
                    $gradesnode->remove();
                }
            }
        }
    }

    // Hide to admin
    if (isset($config->removegradesnodeadmin) && $config->removegradesnodeadmin == true && is_siteadmin()) {
        if ($PAGE->context->get_course_context(false) == true && $COURSE->id != SITEID) {
            if ($gradesnode = $nav->find('grades', global_navigation::TYPE_SETTING)) {
                $gradesnode->remove();
            }
        }
    }

    if (isloggedin()) {
        local_vxg_menus_add_new_navigation_nodes($nav);
    }

}