<?php

require_once('../../../config.php');

$context = context_user::instance($USER->id);
if (!has_capability('block/refinedtools:send_sso_meeting_link', $context)) {
    header('Content-Type: application/json');
    echo json_encode( array( 'error' => 'noaccess' ) );
    exit(1);
}

$userid = optional_param('userid', 0, PARAM_INT);
$eventid = optional_param('eventid', 0, PARAM_INT);

$user = $userid ? $DB->get_record( 'user', array( 'id' => $userid ) ) : 0;
if( !$user ){
    header('Content-Type: application/json');
    echo json_encode( array( 'error' => 'nouser' ) );
    exit(1);
}

$event = $eventid ? $DB->get_record( 'event', array( 'id' => $eventid ) ) : 0;
if( !$event ){
    header('Content-Type: application/json');
    echo json_encode( array( 'error' => 'noevent' ) );
    exit(1);

}

$context = context_course::instance($event->courseid);
if( is_enrolled($context, $user->id) ){
    $content = getEnrolledContent( $user, $event );
}else{
    $content = getUnenrolledContent( $user, $event );
}

header('Content-Type: application/json');
echo json_encode( array( 'content' => $content ) );

function getEnrolledContent( $user, $event ){
    global $CFG, $DB;

    $course = $DB->get_record( 'course', array( 'id' => $event->courseid ) );

    $content = '<h3>Event Sign On Link</h3>';
    $content.= '<br />'.$user->firstname.' '.$user->lastname.' is enrolled in ';
    $content.= isset( $course->id ) ? "$course->fullname, " : '';
    $content.= ' which has the following event scheduled '.$event->name;

    require_once( $CFG->dirroot.'/mod/connectmeeting/connectlib.php' );
    require_once( $CFG->dirroot.'/local/reminders/lib.php' );
    $tok = '&token=' . urlencode( base64_encode($user->username . '||' . urlencode( connect_encrypt( REMINDERS_PASSKEY ) ) ) );
    $eventurl = empty( $event->acurl ) ? '' : $CFG->wwwroot.'/filter/connect/launch.php?acurl=' . $event->acurl . $tok;

    $content.= "<br /><br />Event Link:<br />$eventurl<br /><br />";

    $content.= "<a href='#' id='send-event-reminder'>Email Link</a>";

    return $content;
}

function getUnenrolledContent( $user, $event ){
    global $DB;

    $course = $DB->get_record( 'course', array( 'id' => $event->courseid ) );

    $content = '<h3>User Not Enrolled</h3>';
    $content.= '<br />'.$user->firstname.' '.$user->lastname.' is not enrolled in the course, ';
    $content.= isset( $course->id ) ? "$course->fullname, " : '';
    $content.= ' which contains this activity.  Would you like to enroll them?<br /><br /><a href="#" id="enrol-current-user">Click Here To Enrol This User</a>';

    return $content;
}
