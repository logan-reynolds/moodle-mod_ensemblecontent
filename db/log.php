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

global $DB;

$logs = array(
    array('module'=>'ensemblecontent', 'action'=>'add', 'mtable'=>'ensemblecontent', 'field'=>'name'),
    array('module'=>'ensemblecontent', 'action'=>'update', 'mtable'=>'ensemblecontent', 'field'=>'name'),
    array('module'=>'ensemblecontent', 'action'=>'view', 'mtable'=>'ensemblecontent', 'field'=>'name'),
    array('module'=>'ensemblecontent', 'action'=>'view all', 'mtable'=>'ensemblecontent', 'field'=>'name')
);
?>