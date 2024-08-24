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
 * User Dashboard Page
 *
 * @package    block
 * @subpackage cpm_completionstatus
 * @author     Sri Sairam Pothuri <sri.sai.ram.pothuri-1@ou.edu>
 */

require_once(__DIR__.'/../../config.php');
require_once("{$CFG->libdir}/completionlib.php");

$userid = required_param('userid', PARAM_INT);
$user = $DB->get_record('user', array('id' => $userid), '*', MUST_EXIST);

// Load course from the referrer page (details.php)
$courseid = optional_param('course', 0, PARAM_INT);
if ($courseid) {
    $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
} else {
    $course = null;
}

require_login();
$context = context_user::instance($user->id);
$PAGE->set_context($context);
$PAGE->set_pagelayout('report');
$PAGE->set_url('/blocks/cpm_completionstatus/user_dashboard.php', array('userid' => $userid));
$PAGE->set_title(get_string('userdashboard', 'block_cpm_completionstatus'));
$PAGE->set_heading(fullname($user) . "'s " . get_string('dashboard', 'block_cpm_completionstatus'));

// Adding the "Back" button.
$back_url = new moodle_url('/details.php', array('course' => $course->id, 'user' => $user->id));

$back_button = html_writer::link($back_url, get_string('back', 'block_cpm_completionstatus'), array('class' => 'btn btn-secondary', 'style' => 'float: right; margin: 10px;'));

echo $OUTPUT->header();
//echo $back_button;

// Display the dashboard
echo $OUTPUT->heading('');

// Fetch the courses the user is enrolled in
$enrolled_courses = enrol_get_users_courses($user->id, true);
echo('<br>');
echo '<table class="generaltable">';
echo '<thead>';
echo '<tr>';
echo '<th>' . get_string('course') . '</th>';
echo '<th>' . get_string('status') . '</th>';
echo '<th>' . get_string('completiondate', 'block_cpm_completionstatus') . '</th>';
echo '<th>' . get_string('details') . '</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($enrolled_courses as $course) {
    $completion = new completion_info($course);
    $iscomplete = $completion->is_course_complete($user->id);
    $completiondata = $DB->get_record('course_completions', array('course' => $course->id, 'userid' => $user->id));

    echo '<tr>';
    echo '<td>' . format_string($course->fullname) . '</td>';
    echo '<td>' . ($iscomplete ? get_string('complete') : get_string('inprogress', 'completion')) . '</td>';
    echo '<td>' . ($iscomplete && $completiondata ? userdate($completiondata->timecompleted) : '-') . '</td>';
    echo '<td>';
    
    $details = '';
    $modinfo = get_fast_modinfo($course);
    $completiondetails = $completion->get_completions($user->id);

    foreach ($completiondetails as $cinfo) {
        $criteria = $cinfo->get_criteria();
        $is_activity_complete = $cinfo->is_complete();
        $modinstance = $modinfo->cms[$criteria->moduleinstance];
        $details .= format_string($modinstance->name) . ': ' . ($is_activity_complete ? get_string('complete') : get_string('inprogress', 'completion')) . '<br>';
    }
    echo nl2br($details);
    echo '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

$excel_url = new moodle_url('/blocks/cpm_completionstatus/export_excel.php', array('userid' => $user->id));
$excel_button = html_writer::link($excel_url, get_string('exportexcel', 'block_cpm_completionstatus'), array('class' => 'btn btn-primary', 'style' => 'margin-top: 20px;'));
echo $excel_button;

echo $OUTPUT->footer();
?>
