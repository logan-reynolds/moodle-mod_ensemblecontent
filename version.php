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

$module->version   = 2011112900;      // The current module version (Date: YYYYMMDDXX)
$module->requires  = 2010112400;      // Requires this Moodle version
$module->cron      = 0;               // Period for cron to check this module (secs)
$module->component = 'mod_ensemblecontent'; // To check on upgrade, that module sits in correct place
$module->maturity = MATURITY_BETA;      // [MATURITY_STABLE | MATURITY_RC | MATURITY_BETA | MATURITY_ALPHA]
$module->release  = '1.0.0';
?>