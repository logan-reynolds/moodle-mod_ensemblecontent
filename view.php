<?php
/**
 * Ensemble Content Module
 *
 * Authors:
 * 	Boyan Kostadinov (boyan [at] ensembleVideo [dot] com)
 * 
 * @package   mod_ensemblecontent
 * @copyright 2012 Symphony Video, Inc 
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n = optional_param('n', 0, PARAM_INT);  // ensembleContent instance ID - it should be named as the first character of the module

if ($id) {
    $cm = get_coursemodule_from_id('ensemblecontent', $id, 0, false, MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $content = $DB->get_record('ensemblecontent', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $content = $DB->get_record('ensemblecontent', array('id' => $n), '*', MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $ensembleContent->course), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('ensemblecontent', $content->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = get_context_instance(CONTEXT_MODULE, $cm->id);
$PAGE->set_context($context);

// show some info for guests
if (isguestuser()) {
    $PAGE->set_title(format_string($content->name));

    echo $OUTPUT->header();
    echo $OUTPUT->confirm('<p>'.get_string('view_noguests', 'ensemblecontent').'</p>'.get_string('liketologin'),
            get_login_url(), $CFG->wwwroot.'/course/view.php?id='.$course->id);

    echo $OUTPUT->footer();
    exit;
}

//$moderator = has_capability('mod/bigbluebuttonbn:moderate', $context);

add_to_log($course->id, 'ensemblecontent', 'view', "view.php?id={$cm->id}", $content->name, $cm->id);

/// Print the page header

$PAGE->set_url('/mod/ensemblecontent/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($content->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_button(update_module_button($cm->id, $course->id, get_string('modulename', 'ensemblecontent')));
$PAGE->set_context($context);
$PAGE->set_cacheable(false);

// Output starts here
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever
if ($content->intro) { 
    echo $OUTPUT->box(format_module_intro('ensemblecontent', $content, $cm->id), 'generalbox mod_introbox', 'recordingsbnintro');
}

echo $OUTPUT->heading($content->name);
echo $OUTPUT->box_start('generalbox boxaligncenter', 'dates');
echo $content->embedcode;
echo $OUTPUT->box_end();

// Finish the page
echo $OUTPUT->footer();
?>