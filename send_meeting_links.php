<?php  // $Id: view.php
require_once('../../config.php');
global $USER, $SITE, $DB, $OUTPUT, $CFG;

require_login();

$context = context_user::instance($USER->id);
if (!has_capability('block/refinedtools:send_sso_meeting_link', $context)) {
    redirect( "$CFG->wwwroot", '', 0 );
}

$PAGE->set_url('/blocks/refinedtools/send_meeting_links.php');
$PAGE->set_pagelayout('standard');
$PAGE->set_context( $context );

$PAGE->set_title( get_string( 'sso_link_title', 'block_refinedtools' ) );
$PAGE->set_heading( get_string( 'sso_link_heading', 'block_refinedtools' ) );

$PAGE->requires->jquery_plugin('datatables', 'block_refinedtools');
$PAGE->requires->jquery_plugin('datatables-css', 'block_refinedtools');
$PAGE->requires->js('/blocks/refinedtools/js/sendlinks.js');

echo $OUTPUT->header();

echo "<div id='User-Selection-List'>";
echo "<h3>Select a User</h3>";
echo get_string( 'sso_user_list_heading', 'block_refinedtools' ) . "<br /><br />";
echo createDatatablesShell( 'Datatables-Users', array( 'ID', 'Username', 'First Name', 'Last Name', 'Email' ) );
echo "</div>";

echo "<div id='Event-Selection-List' style='display: none;'>";
echo "<h3>Select an Event</h3>";
echo "Click on an Events row to select it<br /><br />";
echo "<a href='#' id='backtouserlist'>Back</a><br /><br />";
echo createDatatablesShell( 'Datatables-Events', array( 'ID', 'Name', 'Date', 'Duration ( Hours )' ) );
echo "</div>";

echo "<div id='hiddenform'>";
echo "<input id='selected-user' type='hidden' value='0' />";
echo "<input id='selected-event' type='hidden' value='0' />";
echo "</div>";

echo "<div id='Link-Form'>";
echo "<a href='#' id='backtoeventlist'>Back</a><br /><br />";
echo "<div id='Link-Form-Content'>";
echo "</div>";
echo "</div>";

echo "<div id='Complete-Sending' style='display: none;'>";
echo "<h3>Complete</h3>";
echo "Email has been sent.  Would you like to search for another user?<br /><br />";
echo "<table width=100%><tr><td><a href='#' id='reset-page'>Reset Form</a></td><td style='text-align:right;'><a href='$CFG->wwwroot'>Return to Front Page</a></td></tr></table>";
echo "</div>";

echo "<div id='Complete-No-Reminder' style='display: none;'>";
echo "<h3>No Reminder</h3>";
echo "<a href='#' id='backtolinkform'>Back</a><br /><br />";
echo "There is no reminder message attached to this event.  Would you like to search for another user?<br /><br />";
echo "<a href='#' id='reset-page'>Reset Form</a> <div style='align:right;'><a href='$CFG->wwwroot'>Return to Front Page</a></div>";
echo "</div>";

echo $OUTPUT->footer();


function createDatatablesShell( $id, $header ){
    $table = new html_table();
    $table->id = $id;
    $table->class = 'generaltable dataTable no-footer';

    $table->head = array();
    $table->align = array();
    $table->size = array();

    $data = array();

    $size = 100/count($header);

    foreach( $header as $item ){
        $table->head[] = $item;
        $table->align[] = 'LEFT';
        $table->size[] = "$size%";

        $data[] = '';
    }

    $table->width = "100%";

    $table->data[] = $data;

    return html_writer::table( $table );   
}
