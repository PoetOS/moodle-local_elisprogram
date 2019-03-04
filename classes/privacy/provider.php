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
 * ELIS core privacy API.
 *
 * @package    local_elisprogram
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2015 Remote Learner.net Inc http://www.remote-learner.net
 */

namespace local_elisprogram\privacy;

defined('MOODLE_INTERNAL') || die();

// Need this constant, and there seems to be no way to ensure it's available. This is a potential problem area.
if (!defined('CONTEXT_ELIS_USER')) {
    define('CONTEXT_ELIS_USER', 15);
}

class provider implements
    // This plugin has data.
    \core_privacy\local\metadata\provider,

    // This plugin is capable of determining which users have data within it.
    \core_privacy\local\request\core_userlist_provider,

    // This plugin currently implements the original plugin_provider interface.
    \core_privacy\local\request\plugin\provider {

    /**
     * Returns meta data about this system.
     *
     * @param   collection $items The collection to add metadata to.
     * @return  collection  The array of metadata
     */
    public static function get_metadata(\core_privacy\local\metadata\collection $collection):
    \core_privacy\local\metadata\collection {

        // Add all of the relevant tables and fields to the collection.
        $collection->add_database_table('local_elisprogram_cls_enrol', [
            'userid' => 'privacy:metadata:local_elisprogram_cls_enrol:userid',
            'classid' => 'privacy:metadata:local_elisprogram_cls_enrol:classid',
            'enrolmenttime' => 'privacy:metadata:local_elisprogram_cls_enrol:enrolmenttime',
            'completetime' => 'privacy:metadata:local_elisprogram_cls_enrol:completetime',
            'endtime' => 'privacy:metadata:local_elisprogram_cls_enrol:endtime',
            'completestatusid' => 'privacy:metadata:local_elisprogram_cls_enrol:completestatusid',
            'grade' => 'privacy:metadata:local_elisprogram_cls_enrol:grade',
            'credits' => 'privacy:metadata:local_elisprogram_cls_enrol:credits',
        ], 'privacy:metadata:local_elisprogram_cls_enrol');

        $collection->add_database_table('local_elisprogram_cls_graded', [
            'userid' => 'privacy:metadata:local_elisprogram_cls_graded:userid',
            'classid' => 'privacy:metadata:local_elisprogram_cls_graded:classid',
            'completionid' => 'privacy:metadata:local_elisprogram_cls_graded:completionid',
            'grade' => 'privacy:metadata:local_elisprogram_cls_graded:grade',
            'timegraded' => 'privacy:metadata:local_elisprogram_cls_graded:timegraded',
            'timemodified' => 'privacy:metadata:local_elisprogram_cls_graded:timemodified',
        ], 'privacy:metadata:local_elisprogram_cls_graded');

        $collection->add_database_table('local_elisprogram_cls_nstrct', [
            'userid' => 'privacy:metadata:local_elisprogram_cls_nstrct:userid',
            'classid' => 'privacy:metadata:local_elisprogram_cls_nstrct:classid',
            'assigntime' => 'privacy:metadata:local_elisprogram_cls_nstrct:assigntime',
            'completetime' => 'privacy:metadata:local_elisprogram_cls_nstrct:completetime',
        ], 'privacy:metadata:local_elisprogram_cls_nstrct');

        $collection->add_database_table('local_elisprogram_pgm_assign', [
            'userid' => 'privacy:metadata:local_elisprogram_pgm_assign:userid',
            'curriculumid' => 'privacy:metadata:local_elisprogram_pgm_assign:curriculumid',
            'completed' => 'privacy:metadata:local_elisprogram_pgm_assign:completed',
            'timecompleted' => 'privacy:metadata:local_elisprogram_pgm_assign:timecompleted',
            'timeexpired' => 'privacy:metadata:local_elisprogram_pgm_assign:timeexpired',
            'credits' => 'privacy:metadata:local_elisprogram_pgm_assign:credits',
            'certificatecode' => 'privacy:metadata:local_elisprogram_pgm_assign:certificatecode',
            'timecreated' => 'privacy:metadata:local_elisprogram_pgm_assign:timecreated',
            'timemodified' => 'privacy:metadata:local_elisprogram_pgm_assign:timemodified',
        ], 'privacy:metadata:local_elisprogram_pgm_assign');

        $collection->add_database_table('local_elisprogram_usr', [
            'username' => 'privacy:metadata:local_elisprogram_usr:username',
            'idnumber' => 'privacy:metadata:local_elisprogram_usr:idnumber',
            'firstname' => 'privacy:metadata:local_elisprogram_usr:firstname',
            'lastname' => 'privacy:metadata:local_elisprogram_usr:lastname',
            'mi' => 'privacy:metadata:local_elisprogram_usr:mi',
            'email' => 'privacy:metadata:local_elisprogram_usr:email',
            'email2' => 'privacy:metadata:local_elisprogram_usr:email2',
            'address' => 'privacy:metadata:local_elisprogram_usr:address',
            'address2' => 'privacy:metadata:local_elisprogram_usr:address2',
            'city' => 'privacy:metadata:local_elisprogram_usr:city',
            'state' => 'privacy:metadata:local_elisprogram_usr:state',
            'postalcode' => 'privacy:metadata:local_elisprogram_usr:postalcode',
            'country' => 'privacy:metadata:local_elisprogram_usr:country',
            'phone' => 'privacy:metadata:local_elisprogram_usr:phone',
            'phone2' => 'privacy:metadata:local_elisprogram_usr:phone2',
            'fax' => 'privacy:metadata:local_elisprogram_usr:fax',
            'birthdate' => 'privacy:metadata:local_elisprogram_usr:birthdate',
            'gender' => 'privacy:metadata:local_elisprogram_usr:gender',
            'language' => 'privacy:metadata:local_elisprogram_usr:language',
            'transfercredits' => 'privacy:metadata:local_elisprogram_usr:transfercredits',
            'comments' => 'privacy:metadata:local_elisprogram_usr:comments',
            'notes' => 'privacy:metadata:local_elisprogram_usr:notes',
            'timecreated' => 'privacy:metadata:local_elisprogram_usr:timecreated',
            'timeapproved' => 'privacy:metadata:local_elisprogram_usr:timeapproved',
            'timemodified' => 'privacy:metadata:local_elisprogram_usr:timemodified',
        ], 'privacy:metadata:local_elisprogram_usr');

        $collection->add_database_table('local_elisprogram_usr_trk', [
            'userid' => 'privacy:metadata:local_elisprogram_usr_trk:userid',
            'trackid' => 'privacy:metadata:local_elisprogram_usr_trk:trackid',
        ], 'privacy:metadata:local_elisprogram_usr_trk');

        $collection->add_database_table('local_elisprogram_notifylog', [
            'userid' => 'privacy:metadata:local_elisprogram_notifylog:userid',
            'event' => 'privacy:metadata:local_elisprogram_notifylog:event',
            'instance' => 'privacy:metadata:local_elisprogram_notifylog:instance',
            'fromuserid' => 'privacy:metadata:local_elisprogram_notifylog:fromuserid',
            'data' => 'privacy:metadata:local_elisprogram_notifylog:data',
            'timecreated' => 'privacy:metadata:local_elisprogram_notifylog:timecreated',
        ], 'privacy:metadata:local_elisprogram_notifylog');

        $collection->add_database_table('local_elisprogram_uset_asign', [
            'userid' => 'privacy:metadata:local_elisprogram_uset_asign:userid',
            'clusterid' => 'privacy:metadata:local_elisprogram_uset_asign:clusterid',
            'plugin' => 'privacy:metadata:local_elisprogram_uset_asign:plugin',
            'leader' => 'privacy:metadata:local_elisprogram_uset_asign:leader',
        ], 'privacy:metadata:local_elisprogram_uset_asign');

        $collection->add_database_table('local_elisprogram_waitlist', [
            'userid' => 'privacy:metadata:local_elisprogram_waitlist:userid',
            'classid' => 'privacy:metadata:local_elisprogram_waitlist:classid',
            'timecreated' => 'privacy:metadata:local_elisprogram_waitlist:timecreated',
            'timemodified' => 'privacy:metadata:local_elisprogram_waitlist:timemodified',
            'position' => 'privacy:metadata:local_elisprogram_waitlist:position',
        ], 'privacy:metadata:local_elisprogram_waitlist');

        $collection->add_database_table('local_elisprogram_usr_mdl', [
            'cuserid' => 'privacy:metadata:local_elisprogram_usr_mdl:cuserid',
            'muserid' => 'privacy:metadata:local_elisprogram_usr_mdl:muserid',
            'idnumber' => 'privacy:metadata:local_elisprogram_usr_mdl:idnumber',
        ], 'privacy:metadata:local_elisprogram_usr_mdl');

        $collection->add_database_table('local_elisprogram_res_stulog', [
            'userid' => 'privacy:metadata:local_elisprogram_res_stulog:userid',
            'classlogid' => 'privacy:metadata:local_elisprogram_res_stulog:classlogid',
            'action' => 'privacy:metadata:local_elisprogram_res_stulog:action',
            'daterun' => 'privacy:metadata:local_elisprogram_res_stulog:daterun',
        ], 'privacy:metadata:local_elisprogram_res_stulog');

        $collection->add_database_table('local_elisprogram_certissued', [
            'cm_userid' => 'privacy:metadata:local_elisprogram_certissued:cm_userid',
            'cert_setting_id' => 'privacy:metadata:local_elisprogram_certissued:cert_setting_id',
            'cert_code' => 'privacy:metadata:local_elisprogram_certissued:cert_code',
            'timeissued' => 'privacy:metadata:local_elisprogram_certissued:timeissued',
            'timecreated' => 'privacy:metadata:local_elisprogram_certissued:timecreated',
        ], 'privacy:metadata:local_elisprogram_certissued');

        $collection->add_database_table('local_elisprogram_deepsight', [
            'userid' => 'privacy:metadata:local_elisprogram_deepsight:userid',
            'contextid' => 'privacy:metadata:local_elisprogram_deepsight:contextid',
            'pagename' => 'privacy:metadata:local_elisprogram_deepsight:pagename',
            'name' => 'privacy:metadata:local_elisprogram_deepsight:name',
            'isdefault' => 'privacy:metadata:local_elisprogram_deepsight:isdefault',
            'data' => 'privacy:metadata:local_elisprogram_deepsight:data',
            'fieldsort' => 'privacy:metadata:local_elisprogram_deepsight:fieldsort',
        ], 'privacy:metadata:local_elisprogram_deepsight');

        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param   int $userid The user to search.
     * @return  contextlist   $contextlist  The list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid(int $userid): \core_privacy\local\request\contextlist {
        $contextlist = new \core_privacy\local\request\contextlist();

        // If the user exists in any of the ELIS core tables, add the user context and return it.
        if (self::user_has_elisprogram_data($userid)) {
            $contextlist->add_user_context($userid);
        }

        return $contextlist;
    }

    /**
     * Get the list of users who have data within a context.
     *
     * @param \core_privacy\local\request\userlist $userlist The userlist containing the list of users who have data in this
     * context/plugin combination.
     */
    public static function get_users_in_context(\core_privacy\local\request\userlist $userlist) {
        $context = $userlist->get_context();
        if (!$context instanceof \context_user) {
            return;
        }

        // If the user exists in any of the ELIS core tables, add the user context and return it.
        if (self::user_has_elisprogram_data($context->instanceid)) {
            $userlist->add_user($context->instanceid);
        }
    }

    /**
     * Export all user data for the specified user, in the specified contexts, using the supplied exporter instance.
     *
     * @param   approved_contextlist $contextlist The approved contexts to export information for.
     */
    public static function export_user_data(\core_privacy\local\request\approved_contextlist $contextlist) {
        global $CFG;
        require_once($CFG->dirroot.'/local/elisprogram/lib/setup.php');
        require_once(\elispm::lib('data/student.class.php'));

        if (empty($contextlist->count())) {
            return;
        }

        // Export ELIS core data.
        $data = new \stdClass();
        $data->workflows = [];
        $data->elisfields = [];
        $user = $contextlist->get_user();
        $context = \context_user::instance($user->id);

        if (!empty($workflowdata = self::program_user_data($user->id))) {
            $data->username = $workflowdata->username;
            $data->idnumber = $workflowdata->idnumber;
            $data->firstname = $workflowdata->firstname;
            $data->lastname = $workflowdata->lastname;
            $data->mi = $workflowdata->mi;
            $data->email = $workflowdata->email;
            $data->email2 = $workflowdata->email2;
            $data->address = $workflowdata->address;
            $data->address2 = $workflowdata->address2;
            $data->city = $workflowdata->city;
            $data->state = $workflowdata->state;
            $data->postalcode = $workflowdata->postalcode;
            $data->country = $workflowdata->country;
            $data->phone = $workflowdata->phone;
            $data->phone2 = $workflowdata->phone2;
            $data->fax = $workflowdata->fax;
            $data->birthdate = $workflowdata->birthdate;
            $data->gender = $workflowdata->gender;
            $data->language = $workflowdata->language;
            $data->transfercredits = $workflowdata->transfercredits;
            $data->comments = $workflowdata->comments;
            $data->notes = $workflowdata->notes;
            $data->timecreated = \core_privacy\local\request\transform::datetime($workflowdata->timecreated);
            $data->timeapproved = \core_privacy\local\request\transform::datetime($workflowdata->timeapproved);
            $data->timemodified = \core_privacy\local\request\transform::datetime($workflowdata->timemodified);
        }

        $completestatustext = [
            STUSTATUS_NOTCOMPLETE => get_string('class_notcompleted', 'local_elisprogram'),
            STUSTATUS_FAILED => get_string('failed', 'local_elisprogram'),
            STUSTATUS_PASSED => get_string('passed', 'local_elisprogram'),
        ];
        $enroldata = self::user_class_enrolment_data($user->id);
        foreach ($enroldata as $enrolrecord) {
            $data->classenrolments[] = [
                'classname' => $enrolrecord->name,
                'enrolmenttime' => \core_privacy\local\request\transform::datetime($enrolrecord->enrolmenttime),
                'completetime' => \core_privacy\local\request\transform::datetime($enrolrecord->completetime),
                'endtime' => \core_privacy\local\request\transform::datetime($enrolrecord->endtime),
                'completestatusid' => $completestatustext[$enrolrecord->completestatusid],
                'grade' => $enrolrecord->grade,
                'credits' => $enrolrecord->credits,
            ];
        }

        \core_privacy\local\request\writer::with_context($context)->export_data([
            get_string('privacy:metadata:local_elisprogram', 'local_elisprogram')
        ], $data);
    }

    /**
     * Delete all personal data for all users in the specified context.
     *
     * @param context $context Context to delete data from.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        if ($context->contextlevel == CONTEXT_USER) {
            // Because we only use user contexts the instance ID is the user ID.
            self::delete_user_data($context->instanceid);
        }
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param   approved_contextlist $contextlist The approved contexts and user information to delete information for.
     */
    public static function delete_data_for_user(\core_privacy\local\request\approved_contextlist $contextlist) {
        if (empty($contextlist->count())) {
            return;
        }

        foreach ($contextlist->get_contexts() as $context) {
            if ($context->contextlevel == CONTEXT_USER) {
                // Because we only use user contexts the instance ID is the user ID.
                self::delete_user_data($context->instanceid);
            }
        }
    }

    /**
     * Delete multiple users within a single context.
     *
     * @param \core_privacy\local\request\approved_userlist $userlist The approved context and user information to delete
     * information for.
     */
    public static function delete_data_for_users(\core_privacy\local\request\approved_userlist $userlist) {
        $context = $userlist->get_context();
        // Because we only use user contexts the instance ID is the user ID.
        if ($context instanceof \context_user) {
            self::delete_user_data($context->instanceid);
        }
    }

    /**
     * Return true if the specified userid has data in the ELIS program tables.
     *
     * @param int $userid The user to check for.
     * @return boolean
     */
    private static function user_has_elisprogram_data(int $userid) {
        global $DB;

        // All ELIS program users must have a record in the ELIS user table.
        $hasdata = false;
        if (!empty(self::program_user_data($userid))) {
            $hasdata = true;
        }

        return $hasdata;
    }

    /**
     * Return the ELIS program user record for the specified user.
     *
     * @param int $userid The user to check for.
     * @return array
     */
    private static function program_user_data(int $userid) {
        global $DB;

        $sql = 'SELECT epu.* ' .
            'FROM {local_elisprogram_usr_mdl} um ' .
            'INNER JOIN {local_elisprogram_usr} epu ON epu.id = um.cuserid ' .
            'WHERE um.muserid = :userid';
        $params = ['userid' => $userid];
        return $DB->get_record_sql($sql, $params);
    }

    /**
     * Return the class enrolment records for the specified user.
     *
     * @param int $userid The user to check for.
     * @return array
     */
    private static function user_class_enrolment_data(int $userid) {
        global $DB;

        $sql = 'SELECT ce.*, cr.name ' .
            'FROM {local_elisprogram_usr_mdl} um ' .
            'INNER JOIN {local_elisprogram_cls_enrol} ce ON ce.userid = um.cuserid ' .
            'INNER JOIN {local_elisprogram_cls} cl ON ce.classid = cl.id ' .
            'INNER JOIN {local_elisprogram_crs} cr ON cl.courseid = cr.id ' .
            'WHERE um.muserid = :userid';
        $params = ['userid' => $userid];
        return $DB->get_records_sql($sql, $params);
    }

    /**
     * Delete all plugin data for the specified user id.
     *
     * @param int $userid The Moodle user id to delete data for.
     */
    private static function delete_user_data($userid) {
        global $DB;

        $DB->delete_records('local_eliscore_wkflow_inst', ['userid' => $userid]);

        $recordsinfo = self::user_field_data($userid);
        foreach ($recordsinfo as $recordinfo) {
            $DB->delete_records($recordinfo->tablename, ['id' => $recordinfo->id]);
        }
    }
}