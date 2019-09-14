<?php
/**
 * Learning designer (LDJ file) import plugin.
 * Moodle callbacks functions.
 *
 * @package     local_learningdesigner_import
 * @category    string
 * @copyright   2019 Nadav Kavalerchik <nadavkav@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * This function extends the course navigation
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass        $course     The course to object for the tool
 * @param context         $context    The context of the course
 * @return void
 */
function local_learningdesigner_import_extend_navigation_course($navigation, $course, $context) {

    if (has_capability('moodle/course:manageactivities', $context)) {

        $url = new moodle_url('/local/learningdesigner_import/import_ld.php',
            array('courseid' => $course->id, 'section' => 1));
        $node = navigation_node::create(get_string('importld', 'local_learningdesigner_import'), $url, navigation_node::TYPE_SETTING,
            null, null, new pix_icon('i/report', get_string('importld', 'local_learningdesigner_import')));
        $navigation->add_node($node);
    }
}