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
 * Export user course completion status as Excel
 *
 * @package    block
 * @subpackage cpm_completionstatus
 * @author     Sri Sairam Pothuri <sri.sai.ram.pothuri-1@ou.edu>
 */

require_once(__DIR__.'/../../config.php');
require_once("$CFG->libdir/excellib.class.php");
require_once("$CFG->libdir/completionlib.php");

$userid = required_param('userid', PARAM_INT);
$user = $DB->get_record('user', array('id' => $userid), '*', MUST_EXIST);

require_login();
$context = context_user::instance($user->id);
$PAGE->set_context($context);
require_capability('moodle/user:viewdetails', $context);

$filename = clean_filename(fullname($user) . '_completion_status.xls');
$workbook = new MoodleExcelWorkbook("-");
$workbook->send($filename);

$worksheet = $workbook->add_worksheet(fullname($user));
$worksheet->write_string(0, 0, get_string('course'));
$worksheet->write_string(0, 1, get_string('status'));
$worksheet->write_string(0, 2, get_string('completiondate', 'block_cpm_completionstatus'));
$worksheet->write_string(0, 3, get_string('details'));

$enrolled_courses = enrol_get_users_courses($user->id, true);
$row = 1;

foreach ($enrolled_courses as $course) {
    $completion = new completion_info($course);
    $iscomplete = $completion->is_course_complete($user->id);
    $completiondata = $DB->get_record('course_completions', array('course' => $course->id, 'userid' => $user->id));
    
    $worksheet->write_string($row, 0, format_string($course->fullname));
    $worksheet->write_string($row, 1, $iscomplete ? get_string('complete') : get_string('inprogress', 'completion'));
    $worksheet->write_string($row, 2, $iscomplete && $completiondata ? userdate($completiondata->timecompleted) : '-');
    
    $details = '';
    $modinfo = get_fast_modinfo($course);
    $completiondetails = $completion->get_completions($user->id);

    foreach ($completiondetails as $cinfo) {
        $criteria = $cinfo->get_criteria();
        $is_activity_complete = $cinfo->is_complete();
        $modinstance = $modinfo->cms[$criteria->moduleinstance];
        $details .= format_string($modinstance->name) . ': ' . ($is_activity_complete ? get_string('complete') : get_string('inprogress', 'completion')) . "\n";
    }
    $worksheet->write($row, 3, $details, $workbook->add_format(array('text_wrap' => 1)));
    $row++;
}

$workbook->close();
exit;
