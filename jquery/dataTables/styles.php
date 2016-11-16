<?php 
header("Content-type: text/css; charset: UTF-8"); 
require_once( "../../../../config.php" );
global $CFG;

$imagepath = "$CFG->wwwroot/blocks/refinedtools/jquery/dataTables/images";

$PAGE->set_context(context_system::instance());
?> 
.dataTables_wrapper {
	position: relative;
	clear: both;
	zoom: 1; /* Feeling sorry for IE */
}

.dataTables_processing {
	position: absolute;
	top: 50%;
	left: 50%;
	width: 250px;
	height: 30px;
	margin-left: -125px;
	margin-top: -15px;
	padding: 14px 0 2px 0;
	border: 1px solid #ddd;
	text-align: center;
	color: #999;
	font-size: 14px;
	background-color: white;
}

.dataTables_length {
	width: 40%;
	float: left;
}

.dataTables_filter {
	width: 50%;
	float: right;
	text-align: right;
}

.dataTables_info {
	width: 60%;
	float: left;
}

.dataTables_paginate {
	float: right;
	text-align: right;
}

/* Pagination nested */
.paginate_disabled_previous, .paginate_enabled_previous,
.paginate_disabled_next, .paginate_enabled_next {
	height: 19px;
	float: left;
	cursor: pointer;
	*cursor: hand;
	color: #111 !important;
}
.paginate_disabled_previous:hover, .paginate_enabled_previous:hover,
.paginate_disabled_next:hover, .paginate_enabled_next:hover {
	text-decoration: none !important;
}
.paginate_disabled_previous:active, .paginate_enabled_previous:active,
.paginate_disabled_next:active, .paginate_enabled_next:active {
	outline: none;
}

.paginate_disabled_previous,
.paginate_disabled_next {
	color: #666 !important;
}
.paginate_disabled_previous, .paginate_enabled_previous {
	padding-left: 23px;
}
.paginate_disabled_next, .paginate_enabled_next {
	padding-right: 23px;
	margin-left: 10px;
}

.paginate_disabled_previous {
	background: url('<?php echo $imagepath;?>/back_disabled.png') no-repeat top left;
}

.paginate_enabled_previous {
	background: url('<?php echo $imagepath;?>/back_enabled.png') no-repeat top left;
}
.paginate_enabled_previous:hover {
	background: url('<?php echo $imagepath;?>/back_enabled_hover.png') no-repeat top left;
}

.paginate_disabled_next {
	background: url('<?php echo $imagepath;?>/forward_disabled.png') no-repeat top right;
}

.paginate_enabled_next {
	background: url('<?php echo $imagepath;?>/forward_enabled.png') no-repeat top right;
}
.paginate_enabled_next:hover {
	background: url('<?php echo $imagepath;?>/forward_enabled_hover.png') no-repeat top right;
}



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DataTables sorting
 */

.sorting_asc {
	background: url('<?php echo $imagepath;?>/sort_asc.png') no-repeat center right !important;
}

.sorting_desc {
	background: url('<?php echo $imagepath;?>/sort_desc.png') no-repeat center right !important;
}

.sorting {
	background: url('<?php echo $imagepath;?>/sort_both.png') no-repeat center right !important;
}

.sorting_asc_disabled {
	background: url('<?php echo $imagepath;?>/sort_asc_disabled.png') no-repeat center right !important;
}

.sorting_desc_disabled {
	background: url('<?php echo $imagepath;?>/sort_desc_disabled.png') no-repeat center right !important;
}
 
table.display thead th:active,
table.display thead td:active {
	outline: none;
}





/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Misc
 */
.dataTables_scroll {
	clear: both;
}

.dataTables_scrollBody {
	*margin-top: -1px;
	-webkit-overflow-scrolling: touch;
}

.top .dataTables_info {
	float: none;
}

.clear {
	clear: both;
}

.dataTables_empty {
	text-align: center;
}

.example_alt_pagination div.dataTables_info {
	width: 40%;
}

.paging_full_numbers {
	width: 400px;
	height: 22px;
	line-height: 22px;
}

.paging_full_numbers a:active {
	outline: none
}

.paging_full_numbers a:hover {
	text-decoration: none;
}

.paging_full_numbers a.paginate_button,
 	.paging_full_numbers a.paginate_active {
	border: 1px solid #aaa;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	padding: 2px 5px;
	margin: 0 3px;
	cursor: pointer;
	*cursor: hand;
	color: #333 !important;
}

.paging_full_numbers a.paginate_button {
	background-color: #ddd;
}

.paging_full_numbers a.paginate_button:hover {
	background-color: #ccc;
	text-decoration: none !important;
}

.paging_full_numbers a.paginate_active {
	background-color: #99B3FF;
}

table.dataTable {
    border-collapse: separate;
    border-spacing: 0;
    clear: both;
    margin: 0 auto;
    width: 100%;
}

