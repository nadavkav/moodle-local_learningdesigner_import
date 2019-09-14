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
 * Plugin administration page.
 *
 * @package     local_learningdesigner_import
 * @category    admin
 * @copyright   2019 Nadav Kavalerchik <nadavkav@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$settings = new admin_settingpage('local_learningdesigner_import',
    get_string('pluginname', 'local_learningdesigner_import'));

if ($ADMIN->fulltree) {

    $default_mapping = 'Read=url
                        Collaborate=wiki
                        Discuss=forum
                        Investigate=assign
                        Practice=quiz
                        Produce=assign';

    $settings->add(
        new admin_setting_configtextarea('local_learningdesigner_import/map_ld_to_moodle',
            get_string('map_ld_to_moodle', 'local_learningdesigner_import'),
            get_string('map_ld_to_moodle_help', 'local_learningdesigner_import'), $default_mapping));
}

$ADMIN->add('localplugins', $settings);

