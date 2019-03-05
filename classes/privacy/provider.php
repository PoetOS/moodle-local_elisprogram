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

        if (empty($contextlist->count())) {
            return;
        }

        // Export ELIS program data.
        $data = new \stdClass();
        $user = $contextlist->get_user();
        $context = \context_user::instance($user->id);

        self::add_program_user_data($data, $user->id);
        self::add_class_enrolment_data($data, $user->id);
        self::add_class_learning_objective_data($data, $user->id);
        self::add_instructor_data($data, $user->id);
        self::add_program_data($data, $user->id);
        self::add_track_data($data, $user->id);
        self::add_notifylog_data($data, $user->id);
        self::add_userset_data($data, $user->id);
        self::add_waitlist_data($data, $user->id);
        self::add_student_log_data($data, $user->id);
        self::add_certificate_data($data, $user->id);
        self::add_deepsight_data($data, $user->id);

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
     * @param string $table The table with the user and class id's.
     * @param string $select Optional extra SELECT items.
     * @param string $join Optional extra JOIN items.
     * @return array
     */
    private static function user_class_data(int $userid, string $table, string $select = '', string $join = '') {
        global $DB;

        $select = 'SELECT cd.*, cr.name as classname' . $select;
        $join = ' INNER JOIN {' . $table . '} cd ON cd.userid = um.cuserid ' .
            'INNER JOIN {local_elisprogram_cls} cl ON cd.classid = cl.id ' .
            'INNER JOIN {local_elisprogram_crs} cr ON cl.courseid = cr.id ' . $join;
        $sql = $select . ' FROM {local_elisprogram_usr_mdl} um ' . $join . ' WHERE um.muserid = :userid';
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

    /**
     * Add the user program data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_program_user_data(\stdClass $data, int $userid) {
        if (!empty($workflowdata = self::program_user_data($userid))) {
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
    }

    /**
     * Add the user class enrolment data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_class_enrolment_data(\stdClass $data, int $userid) {
        global $CFG;
        require_once($CFG->dirroot.'/local/elisprogram/lib/setup.php');
        require_once(\elispm::lib('data/student.class.php'));

        $completestatustext = [
            STUSTATUS_NOTCOMPLETE => get_string('class_notcompleted', 'local_elisprogram'),
            STUSTATUS_FAILED => get_string('failed', 'local_elisprogram'),
            STUSTATUS_PASSED => get_string('passed', 'local_elisprogram'),
        ];
        if ($enroldata = self::user_class_data($userid, 'local_elisprogram_cls_enrol')) {
            $data->classenrolments = [];
            foreach ($enroldata as $enrolrecord) {
                $data->classenrolments[] = [
                    'classname' => $enrolrecord->classname,
                    'enrolmenttime' => \core_privacy\local\request\transform::datetime($enrolrecord->enrolmenttime),
                    'completetime' => \core_privacy\local\request\transform::datetime($enrolrecord->completetime),
                    'endtime' => \core_privacy\local\request\transform::datetime($enrolrecord->endtime),
                    'completestatusid' => $completestatustext[$enrolrecord->completestatusid],
                    'grade' => $enrolrecord->grade,
                    'credits' => $enrolrecord->credits,
                ];
            }
        }
    }

    /**
     * Add the user class learning objective data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_class_learning_objective_data(\stdClass $data, int $userid) {
        $select = ', cc.name as loname, cc.description as lodescription, cc.completion_grade as lograde ';
        $join = 'LEFT JOIN {local_elisprogram_crs_cmp} cc ON cd.completionid = cc.id ';
        if ($gradedata = self::user_class_data($userid, 'local_elisprogram_cls_graded', $select, $join)) {
            $data->learningobjectives = [];
            foreach ($gradedata as $record) {
                $data->learningobjectives[] = [
                    'classname' => $record->classname,
                    'learningobjectivename' => $record->loname,
                    'learningobjectivedescription' => $record->lodescription,
                    'gradeachieved' => $record->grade,
                    'minimumrequiredgrade' => $record->lograde,
                    'timegraded' => \core_privacy\local\request\transform::datetime($record->timegraded),
                    'timemodified' => \core_privacy\local\request\transform::datetime($record->timemodified),
                ];
            }
        }
    }

    /**
     * Add the user instructor data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_instructor_data(\stdClass $data, int $userid) {
        if ($records = self::user_class_data($userid, 'local_elisprogram_cls_nstrct')) {
            $data->instructorclasses = [];
            foreach ($records as $record) {
                $data->instructorclasses[] = [
                    'classname' => $record->classname,
                    'assigntime' => \core_privacy\local\request\transform::datetime($record->assigntime),
                    'completetime' => \core_privacy\local\request\transform::datetime($record->completetime),
                ];
            }
        }
    }

    /**
     * Add the user program data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_program_data(\stdClass $data, int $userid) {
        global $DB;

        $sql = 'SELECT pa.*, p.name, p.description ' .
            'FROM {local_elisprogram_usr_mdl} um ' .
            'INNER JOIN {local_elisprogram_pgm_assign} pa ON um.cuserid = pa.userid ' .
            'INNER JOIN {local_elisprogram_pgm} p ON pa.curriculumid = p.id ' .
            'WHERE um.muserid = :userid';
        $params = ['userid' => $userid];
        if ($records = $DB->get_records_sql($sql, $params)) {
            $data->learningprograms = [];
            foreach ($records as $record) {
                $data->learningprograms[] = [
                    'programname' => $record->name,
                    'programdescription' => $record->description,
                    'completed' => $record->completed,
                    'credits' => $record->credits,
                    'certificatecode' => $record->certificatecode,
                    'timecreated' => \core_privacy\local\request\transform::datetime($record->timecreated),
                    'timemodified' => \core_privacy\local\request\transform::datetime($record->timemodified),
                    'timecompleted' => \core_privacy\local\request\transform::datetime($record->timecompleted),
                    'timeexpired' => \core_privacy\local\request\transform::datetime($record->timeexpired),
                ];
            }
        }
    }

    /**
     * Add the user track data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_track_data(\stdClass $data, int $userid) {
        global $DB;

        $sql = 'SELECT ut.*, t.name, t.description ' .
            'FROM {local_elisprogram_usr_mdl} um ' .
            'INNER JOIN {local_elisprogram_usr_trk} ut ON um.cuserid = ut.userid ' .
            'INNER JOIN {local_elisprogram_trk} t ON ut.trackid = t.id ' .
            'WHERE um.muserid = :userid';
        $params = ['userid' => $userid];
        if ($records = $DB->get_records_sql($sql, $params)) {
            $data->tracks = [];
            foreach ($records as $record) {
                $data->tracks[] = [
                    'trackname' => $record->name,
                    'trackdescription' => $record->description,
                ];
            }
        }
    }

    /**
     * Add the user notify log data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_notifylog_data(\stdClass $data, int $userid) {
        global $DB;

        $sql = 'SELECT nl.* ' .
            'FROM {local_elisprogram_usr_mdl} um ' .
            'INNER JOIN {local_elisprogram_notifylog} nl ON um.cuserid = nl.userid ' .
            'WHERE um.muserid = :userid';
        $params = ['userid' => $userid];
        if ($records = $DB->get_records_sql($sql, $params)) {
            $data->notifylogs = [];
            foreach ($records as $record) {
                $data->notifylogs[] = [
                    'event' => $record->event,
                    'data' => $record->data,
                    'timecreated' => \core_privacy\local\request\transform::datetime($record->timecreated),
                ];
            }
        }
    }

    /**
     * Add the user userset data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_userset_data(\stdClass $data, int $userid) {
        global $DB;

        $sql = 'SELECT ua.*, u.display ' .
            'FROM {local_elisprogram_usr_mdl} um ' .
            'INNER JOIN {local_elisprogram_uset_asign} ua ON um.cuserid = ua.userid ' .
            'INNER JOIN {local_elisprogram_uset} u ON ua.clusterid = u.id ' .
            'WHERE um.muserid = :userid';
        $params = ['userid' => $userid];
        $leaderstr = [0 => get_string('no'), 1 => get_string('yes')];
        if ($records = $DB->get_records_sql($sql, $params)) {
            $data->usersets = [];
            foreach ($records as $record) {
                $data->usersets[] = [
                    'name' => $record->display,
                    'leader' => $leaderstr[$record->leader],
                ];
            }
        }
    }

    /**
     * Add the user waitlist data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_waitlist_data(\stdClass $data, int $userid) {
        if ($records = self::user_class_data($userid, 'local_elisprogram_waitlist')) {
            $data->waitlist = [];
            foreach ($records as $record) {
                $data->waitlist[] = [
                    'classname' => $record->classname,
                    'timecreated' => \core_privacy\local\request\transform::datetime($record->timecreated),
                    'timemodified' => \core_privacy\local\request\transform::datetime($record->timemodified),
                    'position' => $record->position,
                ];
            }
        }
    }

    /**
     * Add the user student log data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_student_log_data(\stdClass $data, int $userid) {
        global $DB;

        $sql = 'SELECT rs.*, cr.name as classname ' .
            'FROM {local_elisprogram_usr_mdl} um ' .
            'INNER JOIN {local_elisprogram_res_stulog} rs ON um.cuserid = rs.userid ' .
            'INNER JOIN {local_elisprogram_res_clslog} rc ON rs.classlogid = rc.id ' .
            'INNER JOIN {local_elisprogram_cls} cl ON rc.classid = cl.id ' .
            'INNER JOIN {local_elisprogram_crs} cr ON cl.courseid = cr.id ' .
            'WHERE um.muserid = :userid';
        $params = ['userid' => $userid];
        if ($records = $DB->get_records_sql($sql, $params)) {
            $data->studentlogs = [];
            foreach ($records as $record) {
                $data->studentlogs[] = [
                    'classname' => $record->classname,
                    'action' => $record->action,
                    'daterun' => $record->daterun,
                ];
            }
        }
    }

    /**
     * Add the user certificate data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_certificate_data(\stdClass $data, int $userid) {
        global $DB;

        $sql = 'SELECT ci.* ' .
            'FROM {local_elisprogram_usr_mdl} um ' .
            'INNER JOIN {local_elisprogram_certissued} ci ON um.cuserid = ci.cm_userid ' .
            'WHERE um.muserid = :userid';
        $params = ['userid' => $userid];
        if ($records = $DB->get_records_sql($sql, $params)) {
            $data->certificates = [];
            foreach ($records as $record) {
                $data->certificates[] = [
                    'certcode' => $record->certcode,
                    'timeissued' => \core_privacy\local\request\transform::datetime($record->timeissued),
                    'timecreated' => \core_privacy\local\request\transform::datetime($record->timecreated),
                ];
            }
        }
    }

    /**
     * Add the user deepsight data.
     *
     * @param \stdClass $data The data structure to add to.
     * @int $userid The Moodle userid for the data.
     */
    private static function add_deepsight_data(\stdClass $data, int $userid) {
        global $DB;

        $sql = 'SELECT ds.* ' .
            'FROM {local_elisprogram_usr_mdl} um ' .
            'INNER JOIN {local_elisprogram_deepsight} ds ON um.cuserid = ds.userid ' .
            'WHERE um.muserid = :userid';
        $params = ['userid' => $userid];
        $defaultstr = [0 => get_string('no'), 1 => get_string('yes')];
        if ($records = $DB->get_records_sql($sql, $params)) {
            $data->savedsearches = [];
            foreach ($records as $record) {
                $data->savedsearches[] = [
                    'pagename' => $record->pagename,
                    'name' => $record->name,
                    'isdefault' => $defaultstr[$record->isdefault],
                    'data' => $record->data,
                    'fieldsort' => $record->fieldsort,
                ];
            }
        }
    }
}