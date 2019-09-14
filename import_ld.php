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

/**
 * Learning designer (LDJ file) import plugin.
 *
 * @package     local_learningdesigner_import
 * @category    admin
 * @copyright   2019 Nadav Kavalerchik <nadavkav@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once("$CFG->dirroot/course/modlib.php");
require_once("locallib.php");

// Choose course and section
$courseid = required_param('courseid', PARAM_INT);
$section = required_param('section', PARAM_INT);

// Validate course id.
$course = get_course($courseid);
require_login($course);
//$coursename = format_string($course->fullname, true, array('context' => $context));

$context = context_course::instance($courseid);
$PAGE->set_url("$CFG->wwwroot/local/learningdesigner_import/import_ld.php");
$PAGE->set_context($context);
$PAGE->set_pagelayout('incourse');

$PAGE->set_title(get_string("mustconfirm"));
$PAGE->set_heading(get_string('importld', 'local_learningdesigner_import'));
echo $OUTPUT->header();

if (empty($_FILES["file"]["name"])) {

    $data = ['section' => $section, 'courseid' => $courseid];
    echo $OUTPUT->render_from_template('local_learningdesigner_import/import_form', $data);
    echo $OUTPUT->footer();
    die;
}

$import_ld = file_get_contents($_FILES["file"]["tmp_name"]);
$ld = json_decode($import_ld);

// Prepare outcomes.
foreach ($ld->outcomes as $outcome) {
    $outcomes[] = ['details' => $outcome->details];
}
$session_data = [
    'sessionproperties' => get_string('sessionproperties', 'local_learningdesigner_import',
        ['learningTime'=> $ld->learningTime, 'groupSize' => $ld->groupSize]),
    'description' => $ld->description,
    'aims' => $ld->aims,
    'outcomes' => $outcomes
    ];
$session_intro = $OUTPUT->render_from_template('local_learningdesigner_import/session_intro', $session_data);

// Check for caps.
require_capability('moodle/course:manageactivities', $context);

// Add "objectives' as mod/label to the course topic/section.
add_label($session_intro, 0, $course);

// TODO: LD Activities are Moodle sections?
// TODO: Ask teacher for a different mapping of LD activities to Moodle modules.

$map_ld_to_moodle = get_config('local_learningdesigner_import', 'map_ld_to_moodle');
if (!empty($map_ld_to_moodle)) {
    $ldmodules = explode("\n", $map_ld_to_moodle);
    foreach($ldmodules as $ldmodule) {
        list($ldmodulename, $moodlemodulename) = explode("=", $ldmodule);
        $learingdesign_to_moodle[$ldmodulename] = rtrim(ltrim($moodlemodulename));
    }
} else {
  $learingdesign_to_moodle = [
      'Read' => 'url', // Read watch listen
      'Collaborate' => 'wiki',
      'Discuss' => 'forum',
      'Investigate' => 'assign',
      'Practice' => 'quiz',
      'Produce' => 'assign',
  ];
}

// Add each LD "activities" to a selected course "section"
foreach($ld->activities as $activity) {
    echo $activity->title.'<br><hr>'; // debug
    // TODO: Modify section title.
    add_label($activity->title, $section, $course);

    foreach($activity->slas as $module) {
        echo 'type: '.$learingdesign_to_moodle[$module->type].'<br>'; // debug
        echo 'Description: '.$module->description.'<br><hr>'; // debug

        // Prepare resources.
        foreach ($module->resources as $resource) {
            $resources[] = ['url' => $resource->url];
        }
        $module_data = [
            'title' => $activity->title,
            'type' => $module->type,
            'description' => $module->description,
            'moduleproperties' => get_string('moduleproperties', 'local_learningdesigner_import',
                ['learningTime'=> $module->duration, 'groupSize' => $module->groupSize]),
            'resources' => $resources
        ];
        $module_intro = $OUTPUT->render_from_template('local_learningdesigner_import/module_intro', $module_data);

        // Create course modules (activities or resources)
        $mod = new \stdClass();
        $mod->modulename = $learingdesign_to_moodle[$module->type];
        $module = $DB->get_record('modules', ['name' => $mod->modulename]);
        $mod->module = $module->id;
        $mod->section = $section;
        $mod->completion = 1;
        $mod->visible = 1;
        $mod->showdescription = 1;
        $mod->cmidnumber = time();
        $mod->introeditor['text'] = $module_intro;
        $mod->introeditor['format'] = FORMAT_HTML;
        //$mod->introeditor['itemid'] = -1;
        switch ($mod->modulename) {
            case 'assign':
                $mod->submissiondrafts = 0;
                $mod->requiresubmissionstatement = 0;
                $mod->sendnotifications = 0;
                $mod->sendlatenotifications = 0;
                $mod->duedate = 0;
                $mod->cutoffdate = 0;
                $mod->gradingduedate = 0;
                $mod->allowsubmissionsfromdate = 0;
                $mod->grade = 100;
                $mod->teamsubmission = 0;
                $mod->requireallteammemberssubmit = 0;
                $mod->blindmarking = 0;
                $mod->markingworkflow = 0;
                $mod->markingallocation = 0;
                break;
            case 'page':
                $mod->display = 0;
                $mod->printheading = 0;
                $mod->printintro = 0;
                $mod->printlastmodified = 0;
                break;
            case 'forum':
                $mod->type = 0;
                break;
            case 'url':
                $mod->display = 0;
                $mod->externalurl = '';
                break;
        }
        $module = add_moduleinfo($mod, $course);
        //$module->cmidnumber = $module->id;
    }
    $section++;

}

redirect($CFG->wwwroot.'/course/view.php?id='.$courseid);
