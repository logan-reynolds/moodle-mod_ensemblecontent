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

defined('MOODLE_INTERNAL') || die();

////////////////////////////////////////////////////////////////////////////////
// Moodle core API                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * Returns the information on whether the module supports a feature
 *
 * @see plugin_supports() in lib/moodlelib.php
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed true if the feature is supported, null if unknown
 */
function ensemblecontent_supports($feature) {
    switch($feature) {
        case FEATURE_IDNUMBER:                  return false;
        case FEATURE_GROUPS:                    return false;
        case FEATURE_GROUPINGS:                 return false;
        case FEATURE_GROUPMEMBERSONLY:          return flase;
        case FEATURE_MOD_INTRO:                 return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS:   return false;
        case FEATURE_GRADE_HAS_GRADE:           return false;
        case FEATURE_GRADE_OUTCOMES:            return false;
        case FEATURE_MOD_ARCHETYPE:             return MOD_ARCHETYPE_RESOURCE;
        default:                                return null;
    }
}

/**
 * Saves a new instance of the ensembleContent into the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param object $content An object from the form in mod_form.php
 * @param mod_ensemblecontent_mod_form $mform
 * @return int The id of the newly inserted ensembleContent record
 */
function ensemblecontent_add_instance(stdClass $content, mod_ensemblecontent_mod_form $mform = null) {
    global $DB;

    $content->timecreated = time();

    return $DB->insert_record('ensemblecontent', $content);
}

/**
 * Updates an instance of the ensembleContent in the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param object $ensembleContent An object from the form in mod_form.php
 * @param mod_ensemblecontent_mod_form $mform
 * @return boolean Success/Fail
 */
function ensemblecontent_update_instance(stdClass $ensembleContent, mod_ensemblecontent_mod_form $mform = null) {
    global $DB;

    $ensembleContent->timemodified = time();
    $ensembleContent->id = $ensembleContent->instance;

    # You may have to add extra stuff in here #

    return $DB->update_record('ensemblecontent', $ensembleContent);
}

/**
 * Removes an instance of the ensembleContent from the database
 *
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 */
function ensemblecontent_delete_instance($id) {
    global $DB;

    if (! $ensembleContent = $DB->get_record('ensemblecontent', array('id' => $id))) {
        return false;
    }

    # Delete any dependent records here #

    $DB->delete_records('ensemblecontent', array('id' => $ensembleContent->id));

    return true;
}

/**
 * Returns a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @return stdClass|null
 */
function ensemblecontent_user_outline($course, $user, $mod, $ensembleContent) {
    $return = new stdClass();
    $return->time = 0;
    $return->info = '';

    return $return;
}

/**
 * Prints a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @return string HTML
 */
function ensemblecontent_user_complete($course, $user, $mod, $ensembleContent) {
    return '';
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in ensembleContent activities and print it out.
 * Return true if there was output, or false is there was none.
 *
 * @return boolean
 */
function ensemblecontent_print_recent_activity($course, $viewfullnames, $timestart) {
    return false;  //  True if anything was printed, otherwise false
}

/**
 * Returns all activity in ensembleContents since a given time
 *
 * @param array $activities sequentially indexed array of objects
 * @param int $index
 * @param int $timestart
 * @param int $courseid
 * @param int $cmid
 * @param int $userid defaults to 0
 * @param int $groupid defaults to 0
 * @return void adds items into $activities and increases $index
 */
function ensemblecontent_get_recent_mod_activity(&$activities, &$index, $timestart, $courseid, $cmid, $userid=0, $groupid=0) {
}

/**
 * Prints single activity item prepared by {@see ensemblecontent_get_recent_mod_activity()}

 * @return void
 */
function ensemblecontent_print_recent_mod_activity($activity, $courseid, $detail, $modnames, $viewfullnames) {
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @return boolean
 * @todo Finish documenting this function
 **/
function ensemblecontent_cron () {
    return true;
}

/**
 * Returns an array of users who are participanting in this ensembleContent
 *
 * Must return an array of users who are participants for a given instance
 * of ensembleContent. Must include every user involved in the instance,
 * independient of his role (student, teacher, admin...). The returned
 * objects must contain at least id property.
 * See other modules as example.
 *
 * @param int $ensembleContentID ID of an instance of this module
 * @return boolean|array false if no participants, array of objects otherwise
 */
function ensemblecontent_get_participants($ensembleContentID) {
    return false;
}

/**
 * Returns all other caps used in the module
 *
 * @example return array('moodle/site:accessallgroups');
 * @return array
 */
function ensemblecontent_get_extra_capabilities() {
    return array('moodle/site:accessallgroups');
}

////////////////////////////////////////////////////////////////////////////////
// Gradebook API                                                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * Is a given scale used by the instance of ensembleContent?
 *
 * This function returns if a scale is being used by one ensembleContent
 * if it has support for grading and scales. Commented code should be
 * modified if necessary. See forum, glossary or journal modules
 * as reference.
 *
 * @param int $ensembleContentID ID of an instance of this module
 * @return bool true if the scale is used by the given ensembleContent instance
 */
function ensemblecontent_scale_used($ensembleContentID, $scaleid) {
    $return = false;

    return $return;
}

/**
 * Checks if scale is being used by any instance of ensembleContent.
 *
 * This is used to find out if scale used anywhere.
 *
 * @param $scaleid int
 * @return boolean true if the scale is used by any ensembleContent instance
 */
function ensemblecontent_scale_used_anywhere($scaleid) {
    $return = false;

    return $return;
}

////////////////////////////////////////////////////////////////////////////////
// File API                                                                   //
////////////////////////////////////////////////////////////////////////////////

/**
 * Returns the lists of all browsable file areas within the given module context
 *
 * The file area 'intro' for the activity introduction field is added automatically
 * by {@link file_browser::get_file_info_context_module()}
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @return array of [(string)filearea] => (string)description
 */
function ensemblecontent_get_file_areas($course, $cm, $context) {
    return array();
}

/**
 * Serves the files from the ensembleContent file areas
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @return void this should never return to the caller
 */
function ensemblecontent_pluginfile($course, $cm, $context, $filearea, array $args, $forcedownload) {
    global $DB, $CFG;

    if ($context->contextlevel != CONTEXT_MODULE) {
        send_file_not_found();
    }

    require_login($course, true, $cm);

    send_file_not_found();
}

////////////////////////////////////////////////////////////////////////////////
// Navigation API                                                             //
////////////////////////////////////////////////////////////////////////////////

/**
 * Extends the global navigation tree by adding ensembleContent nodes if there is a relevant content
 *
 * This can be called by an AJAX request so do not rely on $PAGE as it might not be set up properly.
 *
 * @param navigation_node $navref An object representing the navigation tree node of the ensembleContent module instance
 * @param stdClass $course
 * @param stdClass $module
 * @param cm_info $cm
 */
function ensemblecontent_extend_navigation(navigation_node $navref, stdclass $course, stdclass $module, cm_info $cm) {
}

/**
 * Extends the settings navigation with the ensembleContent settings
 *
 * This function is called when the context for the page is a ensembleContent module. This is not called by AJAX
 * so it is safe to rely on the $PAGE.
 *
 * @param settings_navigation $settingsnav {@link settings_navigation}
 * @param navigation_node $ensembleContentNode {@link navigation_node}
 */
function ensemblecontent_extend_settings_navigation(settings_navigation $settingsnav, navigation_node $ensembleContentNode=null) {
}
?>