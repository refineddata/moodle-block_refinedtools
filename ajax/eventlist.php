<?php
define('AJAX_SCRIPT', true);
require_once(dirname(__FILE__) . '/../../../config.php');

if (!isloggedin() or isguestuser()) {
    die('Invalid access.');
}

$context = context_user::instance($USER->id);
if (!has_capability('block/refinedtools:send_sso_meeting_link', $context)) {
    exit(1);
}

/*
 * Pagination
 */
$sLimit = "";
if ( isset( $_GET['start'] ) && $_GET['length'] != '-1' ){
    $sLimit = "LIMIT ".intval( $_GET['start'] ).", ".intval( $_GET['length'] );
}


/*
 * Ordering
 */
$aColumns = array(
    '0' => 'id',
    '1' => 'name',
    '2' => 'timestart',
    '3' => 'timeduration'
);


$sOrder = "";
if( isset( $_GET['order'] ) ){
    $sOrder = "ORDER BY  ";

    foreach( $_GET['order'] as $key => $value ){
        $columnIdx = intval($_GET['order'][$key]['column']);
        $requestColumn = $_GET['columns'][$columnIdx];
        if( $requestColumn['orderable'] == 'true' && isset( $aColumns[$columnIdx] ) ){
            $dir = $_GET['order'][$key]['dir'] === 'asc' ? 'ASC' : 'DESC';
            $sOrder .= "`".$aColumns[$columnIdx]."` ".$dir.", ";
        }
    }

    $sOrder = substr_replace( $sOrder, "", -2 );
    if( $sOrder == "ORDER BY" ){
        $sOrder = "";
    }
}


/*
 * Filtering
 * NOTE this does not match the built-in DataTables filtering which does it
 * word by word on any field. It's possible to do here, but concerned about efficiency
 * on very large tables, and MySQL's regex functionality is very limited
 */
$sWhere = "";
$sWhereArray = array('');
$fColumns = array(
    '0' => 'id',
    '1' => 'name',
    '2' => 'timestart',
    '3' => 'timeduration'
);


/* Individual column filtering */
/*foreach( $fColumns as $key => $value ){
    //      $columnIdx = intval($_GET['order'][$key]['column']);
    if( isset($_GET['columns'][$key]['searchable']) && $_GET['columns'][$key]['searchable'] == "true" && $_GET['columns'][$key]['search']['value'] != '' ){
        $sWhere .= " AND ";
            $sWhere .= "LOWER(".$fColumns[$key].") LIKE ? ";
            array_push( $sWhereArray, '%'.strtolower($_GET['columns'][$key]['search']['value']).'%' );
    }
}*/

if( isset($_GET['search']['value']) && $_GET['search']['value'] != "" ){
    $sWhere = " AND (";
    foreach( $fColumns as $key => $value ){
        $sWhere .= "LOWER(".$fColumns[$key].") LIKE ? OR ";
        array_push( $sWhereArray, '%'.strtolower($_GET['search']['value']).'%' );
    }   
    $sWhere = substr_replace( $sWhere, "", -3 );
    $sWhere .= ')';
}

//$sql = "UPDATE {user} SET updatedinrs=$value WHERE id=?";
//$DB->execute($sql, array($param['external_user_id']));
$now = time();
$totalArray = array( "SELECT SQL_CALC_FOUND_ROWS * FROM {event} WHERE timestart+timeduration>$now $sWhere $sOrder $sLimit", $sWhereArray );

$events = call_user_func_array( array( $DB, 'get_records_sql' ), $totalArray );

$filterCount = $DB->get_record_sql('SELECT FOUND_ROWS() as filteredrows');
$iFilteredTotal = $filterCount->filteredrows;

$totalRows = $DB->get_record_sql('SELECT COUNT(id) as totalrows FROM {event} WHERE timestart+timeduration>'.$now);
$iTotal = $totalRows->totalrows;

$output = array (
    "draw" => isset( $_GET ['draw'] ) ? intval ( $_GET ['draw'] ) : '',
    "recordsTotal" => $iTotal,
    "recordsFiltered" => $iFilteredTotal,
    "data" => array ()
);

foreach( $events as $event ){
    $trow = array ();
    
    $trow[] = $event->id;
    $trow[] = $event->name;
    $trow[] = date( 'Y/m/d h:s', $event->timestart );
    $trow[] = number_format( $event->timeduration/60/60, 2 );

    $output['data'][] = $trow;
}

echo json_encode($output);
exit(1);
?>
