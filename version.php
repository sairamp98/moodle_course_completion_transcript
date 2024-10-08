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
 * Version info
 *
 * @package    block
 * @subpackage cpm_completionstatus
 * @author     Sri Sairam Pothuri <sri.sai.ram.pothuri-1@ou.edu>
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version      = 2024082100; // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires     = 2019090900; // Requires this Moodle version.
$plugin->component    = 'block_cpm_completionstatus';
$plugin->dependencies = array('report_cpm_completion' => 2022111800);
