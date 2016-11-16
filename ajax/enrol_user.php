<?php

require_once('../../../config.php');

$context = context_user::instance($USER->id);
if (!has_capability('block/refinedtools:send_sso_meeting_link', $context)) {
    exit(1);
}

$userid = optional_param('userid', 0, PARAM_INT);
$eventid = optional_param('eventid', 0, PARAM_INT);

$user = $userid ? $DB->get_record( 'user', array( 'id' => $userid ) ) : 0;
if( !$user ) exit(1);

$event = $eventid ? $DB->get_record( 'event', array( 'id' => $eventid ) ) : 0;
if( !$event ) exit(1);

$instance = $DB->get_record('enrol', array('courseid'=>$event->courseid, 'enrol'=>'manual'), '*', MUST_EXIST);
$course = $DB->get_record('course', array('id'=>$instance->courseid), '*', MUST_EXIST);
$today = time();
$today = make_timestamp(date('Y', $today), date('m', $today), date('d', $today), 0, 0, 0);

if(!$enrol_manual = enrol_get_plugin('manual')) { exit(1); }
$timestart = $today;
$timeend = 0;
$enrolled = $enrol_manual->enrol_user($instance, $user->id, $instance->roleid, $timestart, $timeend);
    

exit(1);
