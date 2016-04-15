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

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form
 */
class mod_ensemblecontent_mod_form extends moodleform_mod {
    /**
    * Defines forms elements
    */
    public function definition() {
		global $CFG, $PAGE, $OUTPUT;
        $mform = $this->_form;
		
		$ensembleServerUrl = preg_replace('/\//', '\/', $CFG->EnsembleServerURL);
		//echo $OUTPUT->$ensembleServerUrl;

        //-------------------------------------------------------------------------------
        // Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));
		//$mform->addElement('header', 'general', get_string('mod_form_block_general', 'ensemblecontent'));

        // Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('contentHeading', 'ensemblecontent'), array('size'=>'64'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

		$mform->addElement('textarea', 'embedcode', get_string('embedCode', 'ensemblecontent'), array('rows'=>'8', 'cols'=>'80'));
        $mform->setType('embedcode', PARAM_RAW);
        $mform->addRule('embedcode', null, 'required', null, 'client');
        $mform->addRule('embedcode', get_string('maximumchars', '', 1000), 'maxlength', 1000, 'client');
		$mform->addRule('embedcode', get_string('mustMatchServerUrl', 'ensemblecontent'), 'regex', '/.*src="' . $ensembleServerUrl . '.*/i', 'client');

        //-------------------------------------------------------------------------------
        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();

        //-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons($cancel = true, $submitlabel=false);

        $PAGE->requires->js('/mod/ensemblecontent/js/jquery.min.js');
        $PAGE->requires->js('/mod/ensemblecontent/js/ensembleContent.js');
    }
}
?>