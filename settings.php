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

$settings->add(
			   new admin_setting_configtext('EnsembleServerURL',
											get_string('ensembleServerUrl', 'ensemblecontent' ),
											get_string('ensembleServerUrlHelp', 'ensemblecontent' ),
											'http://cloud.ensembleVideo.com/ensemble'));

?>