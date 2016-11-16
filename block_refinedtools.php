<?php //$Id: block_admin.php,v 1.100.2.14 2010/02/24 08:56:41 poltawski Exp $

class block_refinedtools extends block_list {
    function init() {
        $this->title = get_string('blocktitle', 'block_refinedtools');
    }

    function get_content() {

        global $CFG, $USER, $SITE, $COURSE, $OUTPUT, $DB;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        if (empty($this->instance->pageid)) { // sticky
            if (!empty($COURSE)) {
                $this->instance->pageid = $COURSE->id;
            }
        }

        if (empty($this->instance)) {
            return $this->content = '';
        } else if ($this->instance->pageid == SITEID) {
            // return $this->content = '';
        }

        $sysctx = context_system::instance();
        if (!empty($this->instance->pageid)) {
            $context = context_course::instance($this->instance->pageid);
            if ($COURSE->id == $this->instance->pageid) {
                $course = $COURSE;
            } else {
                $course = get_record('course', 'id', $this->instance->pageid);
            }
        } else {
            $context = $sysctx;
            $course = $SITE;
        }

        if (empty($CFG->loginhttps)) {
            $securewwwroot = $CFG->wwwroot;
        } else {
            $securewwwroot = str_replace('http:', 'https:', $CFG->wwwroot);
        }

        if (has_capability('moodle/course:update', $context)) {
            $this->content->items[] = '<a target="connect" href="' . $CFG->wwwroot . '/filter/connect/launch.php">' . get_string('launch', 'connectmeeting') . '</a>';
            $this->content->icons[] = '<img src="' . $CFG->wwwroot . '/mod/connectmeeting/pix/icon.png" class="icon" alt="Launch Adobe Connect" />';

            if (!has_capability('moodle/course:view', $context)) { // Just return
                return $this->content;
            }

            if ($DB->get_record('config_plugins', array('plugin' => 'local_reminders', 'name' => 'version'))) {
                $this->content->items[] = '<a href="' . $CFG->wwwroot . '/local/reminders/reminders.php">' . get_string('browse', 'local_reminders') . '</a>';
                $this->content->icons[] = '<img src="' . $OUTPUT->pix_url('i/email') . '" class="icon" alt="Browse Reminders" />';
            }

            if ($DB->get_record('config_plugins', array('plugin' => 'local_managers', 'name' => 'version'))) {
                $this->content->items[] = '<a href="' . $CFG->wwwroot . '/local/managers/managers.php">' . get_string('pluginname', 'local_managers') . '</a>';
                $this->content->icons[] = '<img src="' . $OUTPUT->pix_url('i/group') . '" class="icon" alt="' . get_string('pluginname', 'local_managers') . ' />';
            }

            if ($DB->get_record('config_plugins', array('plugin' => 'enrol_token', 'name' => 'version'))) {
                $this->content->items[] = '<a href="' . $CFG->wwwroot . '/enrol/token/browse.php">' . get_string('addedit', 'enrol_token') . '</a>';
                $this->content->icons[] = '<img src="' . $OUTPUT->pix_url('i/key') . '" class="icon" alt="Enrol Tokens" />';
            }

            if ($DB->get_record('config_plugins', array('plugin' => 'local_rolealerts', 'name' => 'version'))) {
                $this->content->items[] = '<a href="' . $CFG->wwwroot . '/local/rolealerts/index.php">' . get_string('pluginname', 'local_rolealerts') . '</a>';
                $this->content->icons[] = '<img src="' . $OUTPUT->pix_url('i/group') . '" class="icon" alt="' . get_string('pluginname', 'local_rolealerts') . ' />';
            }

            if (isset($CFG->local_workbook) AND $CFG->local_workbook AND $course->id != SITEID) {
                if ($DB->get_record('config_plugins', array('plugin' => 'local_webinars', 'name' => 'version')) AND $course->id != SITEID) {
                    $this->content->items[] = '<a href="' . $CFG->wwwroot . '/local/webinars/workbook.php?id=' . $course->id . '">' . get_string('workbook', 'local_webinars') . '</a>';
                    $this->content->icons[] = '<img src="' . $OUTPUT->pix_url('i/stats') . '" class="icon" alt="' . get_string('workbook', 'local_webinars') . ' />';
                }

                if ($DB->get_record('config_plugins', array('plugin' => 'local_webinars', 'name' => 'version')) AND $course->id != SITEID) {
                    $this->content->items[] = '<a href="' . $CFG->wwwroot . '/local/webinars/dashboard.php?id=' . $course->id . '">' . get_string('dashboard', 'local_webinars') . '</a>';
                    $this->content->icons[] = '<img src="' . $OUTPUT->pix_url('i/stats') . '" class="icon" alt="' . get_string('dashboard', 'local_webinars') . ' />';
                }
            }

            if (isset($CFG->tsession_autotutor) AND $course->id != SITEID) {
                $this->content->items[] = '<a href="' . $CFG->wwwroot . '/mod/tsession/tutors.php?course=' . $course->id . '">' . get_string('tutors', 'tsession') . '</a>';
                $this->content->icons[] = '<img src="' . $OUTPUT->pix_url('i/users') . '" class="icon" alt="Tutors" />';
            }

            if ( $course->id != SITEID ){
                $enrol = $DB->get_record('enrol', array('enrol' => 'rtform', 'courseid' => $course->id, 'status' => 0));
                if (!empty($enrol)){
                    $this->content->items[] = '<a href="' . $CFG->wwwroot . '/enrol/rtform/dashboard.php?id=' . $course->id . '">' . get_string('rtformdashboard', 'enrol_rtform') . '</a>';
                    $this->content->icons[] = '<img src="' . $OUTPUT->pix_url('i/users') . '" class="icon" alt="Tutors" />';
                    $this->content->items[] = '<a href="' . $CFG->wwwroot . '/enrol/rtform/workbook.php?id=' . $course->id . '">' . get_string('rtformworkbook', 'enrol_rtform') . '</a>';
                    $this->content->icons[] = '<img src="' . $OUTPUT->pix_url('i/users') . '" class="icon" alt="Tutors" />';
                }
            }

            $this->content->items[] = '<a target="_blank" href="http://support.refineddata.com">' . get_string('rt_support_center', 'block_refinedtools') . '</a>';
            $this->content->icons[] = '<img src="' . $CFG->wwwroot . '/blocks/refinedtools/pix/rds_16x16.png" class="icon" />';
        }

        if (has_capability('block/refinedtools:send_sso_meeting_link', $context)) {
            $this->content->items[] = '<a href="'.$CFG->wwwroot.'/blocks/refinedtools/send_meeting_links.php">' . get_string('sso_block_link', 'block_refinedtools') . '</a>';
            $this->content->icons[] = '<img src="' . $CFG->wwwroot . '/filter/connect/images/meeting_sm.jpg" height=16 width=16 class="icon" />';
        }

        return $this->content;
    }

    function applicable_formats() {
        return array('site' => true, 'course' => true, 'my' => true);
    }
}
