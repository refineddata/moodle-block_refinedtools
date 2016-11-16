<?php

require_once('../../../config.php');

$context = context_user::instance($USER->id);
if (!has_capability('block/refinedtools:send_sso_meeting_link', $context)) {
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

require_once( $CFG->dirroot.'/mod/connectmeeting/connectlib.php' );
require_once( $CFG->dirroot.'/local/reminders/lib.php' );
$tok = '&token=' . urlencode( base64_encode($user->username . '||' . urlencode( connect_encrypt( REMINDERS_PASSKEY ) ) ) );
$eventurl = empty( $event->acurl ) ? '' : $CFG->wwwroot.'/filter/connect/launch.php?acurl=' . $event->acurl . $tok;

$data = new stdClass();
$data->url  = $eventurl;
$data->name = "$user->firstname $user->lastname";

$subject              = get_string( 'sso_email_link_subject', 'block_refinedtools' );
$message              = get_string( 'sso_email_link_message', 'block_refinedtools', $data );
$messagehtml          = text_to_html( $message, false, false, true );
$admin                = core_user::get_support_user();

email_to_user( $user, $admin, $subject, $message, $messagehtml );
  

exit(1);
