<?php
/**
 * Learning designer (LDJ file) import plugin.
 *
 * @package     local_learningdesigner_import
 * @category    string
 * @copyright   2019 Nadav Kavalerchik <nadavkav@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/// Helper functions
///

/**
 * Add course module of type Label
 *
 * @param $text string
 * @param $section integer
 * @param $course object
 */
function add_label($text, $section, $course) {
    global $DB;

    $mod = new \stdClass();
    $mod->modulename = 'label';
    $module = $DB->get_record('modules', ['name' => $mod->modulename]);
    $mod->module = $module->id;
    $mod->section = $section;
    $mod->completion = 1;
    $mod->visible = 1;
    $mod->introeditor['text'] = $text;
    $mod->introeditor['format'] = FORMAT_HTML;
    $label = add_moduleinfo($mod, $course);
}