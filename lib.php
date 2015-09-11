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
 * Moodle's ucsf theme, an example of how to make a Bootstrap theme
 *
 * DO NOT MODIFY THIS THEME!
 * COPY IT FIRST, THEN RENAME THE COPY AND MODIFY IT INSTEAD.
 *
 * For full information about creating Moodle themes, see:
 * http://docs.moodle.org/dev/Themes_2.0
 *
 * @package    theme
 * @subpackage UCSF
 * @author     Lambda Soulutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Parses CSS before it is cached.
 *
 * This function can make alterations and replace patterns within the CSS.
 *
 * @param string $css The CSS
 * @param theme_config $theme The theme config object.
 * @return string The parsed CSS The parsed CSS.
 */


function theme_ucsf_process_css($css, $theme) {
    
    // Set the background image for the logo.
    $logo = $theme->setting_file_url('logo', 'logo');
    $css = theme_ucsf_set_logo($css, $logo);

    // Set custom CSS.
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    $css = theme_ucsf_set_customcss($css, $customcss);
    
    // Block settings
    // Set block width for large desktop
    if (!empty($theme->settings->block_width_desktop)) {
        $block_width = $theme->settings->block_width_desktop;
    } else {
        $block_width = '';
    }
    $css = theme_ucsf_block_width($css, '[[setting:block_width_desktop]]', $block_width);
    
    // Block width for portrait tablet to landscape and desktop
    if (!empty($theme->settings->block_width_portrait_tablet)) {
        $block_width_portrait_tablet = $theme->settings->block_width_portrait_tablet;
    } else {
        $block_width_portrait_tablet = '';
    }
    $css = theme_ucsf_block_width($css, '[[setting:block_width_portrait_tablet]]', $block_width_portrait_tablet);

    return $css;
}

function theme_ucsf_block_width($css, $tag, $block_width) {
    $replacement = $block_width;
    if (is_null($replacement)) {
        $replacement = '';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Adds the logo to CSS.
 *
 * @param string $css The CSS.
 * @param string $logo The URL of the logo.
 * @return string The parsed CSS
 */
function theme_ucsf_set_logo($css, $logo) {
    $tag = '[[setting:logo]]';
    $replacement = $logo;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_ucsf_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    global $DB;
    $CATEGORILABELIMAGE = array();

    $sql = "SELECT cc.id
        FROM {course_categories} cc";

    $course_categories =  $DB->get_records_sql($sql);
    foreach ($course_categories as $cat) {
        $CATEGORILABELIMAGE[]= "categorylabelimage".$cat->id;        
    }


    if ($context->contextlevel == CONTEXT_SYSTEM) {
        $theme = theme_config::load('ucsf');
        if ($filearea === 'logo') {
            return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
        } else if ($filearea === 'bannerimage') {
            return $theme->setting_file_serve('bannerimage', $args, $forcedownload, $options);
        } else if ($filearea === 'tile1image') {
            return $theme->setting_file_serve('tile1image', $args, $forcedownload, $options);
        } else if ($filearea === 'tile2image') {
            return $theme->setting_file_serve('tile2image', $args, $forcedownload, $options);
        } else if ($filearea === 'tile3image') {
            return $theme->setting_file_serve('tile3image', $args, $forcedownload, $options);
        } else if ($filearea === 'tile4image') {
            return $theme->setting_file_serve('tile4image', $args, $forcedownload, $options);
        } else if ($filearea === 'tile5image') {
            return $theme->setting_file_serve('tile5image', $args, $forcedownload, $options);
        } else if ($filearea === 'tile6image') {
            return $theme->setting_file_serve('tile6image', $args, $forcedownload, $options);
        }else if ($filearea === 'tile7image') {
            return $theme->setting_file_serve('tile7image', $args, $forcedownload, $options);
        }else if ($filearea === 'tile8image') {
            return $theme->setting_file_serve('tile8image', $args, $forcedownload, $options);
        }else if ($filearea === 'tile9image') {
            return $theme->setting_file_serve('tile9image', $args, $forcedownload, $options);
        }else if ($filearea === 'tile10image') {
            return $theme->setting_file_serve('tile10image', $args, $forcedownload, $options);
        }else if (in_array($filearea,  $CATEGORILABELIMAGE)) {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else {
            send_file_not_found();
        }
    } else {
        send_file_not_found();
    }
}

/**
 * Adds any custom CSS to the CSS before it is cached.
 *
 * @param string $css The original CSS.
 * @param string $customcss The custom CSS to add.
 * @return string The CSS which now contains our custom CSS.
 */
function theme_ucsf_set_customcss($css, $customcss) {
    $tag = '[[setting:customcss]]';
    $replacement = $customcss;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

/**
 * Returns an object containing HTML for the areas affected by settings.
 *
 * @param renderer_base $output Pass in $OUTPUT.
 * @param moodle_page $page Pass in $PAGE.
 * @return stdClass An object with the following properties:
 *      - navbarclass A CSS class to use on the navbar. By default ''.
 *      - heading HTML to use for the heading. A logo if one is selected or the default heading.
 *      - footnote HTML to use as a footnote. By default ''.
 */
function theme_ucsf_get_html_for_settings(renderer_base $output, moodle_page $page) {
    global $CFG;
    $return = new stdClass;

    $return->navbarclass = '';
    if (!empty($page->theme->settings->invert)) {
        $return->navbarclass .= ' navbar-inverse';
    }

    if (!empty($page->theme->settings->logo)) {
        $return->heading = html_writer::link($CFG->wwwroot, '', array('title' => get_string('home'), 'class' => 'logo'));
    } else {
        $return->heading = $output->page_heading();
    }

    $return->copyright = '';
    if (!empty($page->theme->settings->copyright)) {
        $return->copyright = $page->theme->settings->copyright;
    }

    $return->footnote = '';
    if (!empty($page->theme->settings->footnote)) {
        $return->footnote = $page->theme->settings->footnote;
    }

    return $return;
}

function theme_ucsf_get_setting($setting, $format = false)
{
    static $theme;
    if (empty($theme)) {
        $theme = theme_config::load('ucsf');
    }
    if (empty($theme->settings->$setting)) {
        return false;
    } else if (!$format) {
        return $theme->settings->$setting;
    } else if ($format === 'format_text') {
        return format_text($theme->settings->$setting);
    } else {
        return format_string($theme->settings->$setting);
    }
}

/**
 * Returns an object containing HTML for the areas affected by category customization settings.
 *
 * @param renderer_base $output Pass in $OUTPUT.
 * @param moodle_page $page Pass in $PAGE.
 * @return stdClass An object with the following properties:
 *      - enablecustomization: true if Category Customization is enabled. By default false.
 *      - categorylabel: String to use for the Top Level Category Label. By default ''.
 *      - displaycoursetitle: The course title will appear on the course page for all courses, 
*         unless the course title is set NOT to display on configured categories.
 *      - displaycustommenu: Hide Custom Menu when logged out. By default returns custom menu.
 */
function theme_ucsf_get_global_settings(renderer_base $output, moodle_page $page) {
    global $CFG, $COURSE, $CATEGORIES;
    $return = new stdClass;

    $return->categorylabel = '';
    $return->coursetitle = '';
    $return->displaycustommenu = $output->custom_menu();

    /* 
    *   Help/Feedback Links
    *   Pulling the number of links dynamically from the Help/Feedback Settings inside Theme Settings
    */

    $target = '';
    

    $helpfeedbacktitle = null;

    if(!isset($page->theme->settings->helpfeedbacktitle) || $page->theme->settings->helpfeedbacktitle == "") {

        $helpfeedbacktitle = 'Help/Feedback';

    } else {
        $helpfeedbacktitle = $page->theme->settings->helpfeedbacktitle;
    }
    $helpfeedback = null;
    
    for ($i = 1; $i <= $page->theme->settings->numberoflinks; $i++ ) {
        $helpfeedbacklink = theme_ucsf_get_setting('helpfeedback' . $i . 'link');
        $helpfeedbacklinklabel = theme_ucsf_get_setting('helpfeedback' . $i . 'linklabel');
        $helpfeedbacklinktarget = theme_ucsf_get_setting('helpfeedback' . $i . 'linktarget');

        if (!empty($helpfeedbacklink)) {
            if(!empty($helpfeedbacklinklabel)) {
                if ($helpfeedbacklinktarget == true) {
                    $target = 'target = "_blank"';
                    $helpfeedback .= '<li role="presentation"><a title="'.$helpfeedbacklinklabel.'" href="'.$helpfeedbacklink.'" '.$target.'>'.$helpfeedbacklinklabel.'</a></li>
                    <li class="divider"></li>';
                }else{
                    $target = 'target = "_self"';
                    $helpfeedback .= '<li role="presentation"><a title="'.$helpfeedbacklinklabel.'" href="'.$helpfeedbacklink.'" '.$target.'>'.$helpfeedbacklinklabel.'</a></li><li class="divider">';
                }
            }else{
                $helpfeedback .=  '<li role="presentation"><a href="' . $helpfeedbacklink . '" ' . $target . '>'.$helpfeedbacklink.'</a></li><li class="divider">';
            }
        }
    }
    if ($page->theme->settings->enablehelpfeedback == 1 && $helpfeedback != false) {
        $return->helpfeedbacklink = '<div class="dropdown helpfeedback-box"><a class="dropdown-toggle" data-toggle="dropdown">'.$helpfeedbacktitle.'<span class="caret"></span></a>'
                . '<ul class="dropdown-menu help-feedback pull-right" role="menu">'
                . $helpfeedback
                . '</ul></div>';
    } else {
        $return->helpfeedbacklink ='';
    }

    // customization enable
    $return->enablecustomization = false;
    if ($page->theme->settings->enablecustomization) {
        $return->enablecustomization = true;
    }



    // category customization enabled
    if($return->enablecustomization) {

        // set toplevel category label
        $return->categorylabel = '';
        if (!empty($page->theme->settings->toplevelcategorylabel)) {
            $return->categorylabel = '<div class="category-label pull-left"><div class="category-label-text">'.$page->theme->settings->toplevelcategorylabel.'</div></div>';
        }
        // get course category id
        $COURSECATEGORY = 0;
        if ($page->pagelayout=="coursecategory" && isset($_REQUEST["categoryid"]))
            $COURSECATEGORY = $_REQUEST["categoryid"];
        else
            $COURSECATEGORY = $COURSE->category;

        // Help/Feedback Links
        if ($COURSECATEGORY != 0) {

            $target = '';

            if(theme_ucsf_get_setting('cathelpfeedbacktitle'.$COURSECATEGORY) == null || theme_ucsf_get_setting('cathelpfeedbacktitle'.$COURSECATEGORY) == "") {

                $helpfeedbacktitle = 'Help/Feedback';

            } else {
                $helpfeedbacktitle = theme_ucsf_get_setting('cathelpfeedbacktitle'.$COURSECATEGORY);
            }

            $cathelpfeedback = null;
            $catnumberoflinks = theme_ucsf_get_setting('catnumberoflinks'.$COURSECATEGORY);
            
            for ($i = 1; $i <= $page->theme->settings->numberoflinks; $i++ ) {
                $helpfeedbacklink = theme_ucsf_get_setting('cathelpfeedback' . $i . 'link' . $COURSECATEGORY);
                $helpfeedbacklinklabel = theme_ucsf_get_setting('cathelpfeedback' . $i . 'linklabel' . $COURSECATEGORY);
                $helpfeedbacklinktarget = theme_ucsf_get_setting('cathelpfeedback' . $i . 'linktarget' . $COURSECATEGORY);

                if (!empty($helpfeedbacklink)) {
                    if(!empty($helpfeedbacklinklabel)) {
                        if ($helpfeedbacklinktarget == true) {
                            $target = 'target = "_blank"';
                            $cathelpfeedback .= '<li role="presentation"><a title="'.$helpfeedbacklinklabel.'" href="'.$helpfeedbacklink.'" '.$target.'>'.$helpfeedbacklinklabel.'</a></li><li class="divider">';
                        }else{
                            $target = 'target = "_self"';
                            $cathelpfeedback .= '<li role="presentation"><a title="'.$helpfeedbacklinklabel.'" href="'.$helpfeedbacklink.'" '.$target.'>'.$helpfeedbacklinklabel.'</a></li><li class="divider">';}
                    }else{
                        $cathelpfeedback .=  '<li role="presentation"><a href="'.$helpfeedbacklink.'" '.$target.'>'.$helpfeedbacklink.'</a></li><li class="divider">';
                    }
                }
            }
            if($cathelpfeedback != null){
                if (theme_ucsf_get_setting('catenablehelpfeedback'.$COURSECATEGORY) == 1) {
                    $return->helpfeedbacklink = '<div class="dropdown helpfeedback-box"><a class="dropdown-toggle" data-toggle="dropdown">'.$helpfeedbacktitle.'<span class="caret"></span></a>'
                            . '<ul class="dropdown-menu help-feedback pull-right" role="menu">'
                            . $cathelpfeedback
                            . '</ul></div>';
                } else {
                    $return->helpfeedbacklink;
                }
            }
        }

        // set course title
        $return->coursetitle = '';
        if(!empty($page->theme->settings->displaycoursetitle))
            if ($page->theme->settings->displaycoursetitle)
                if(!empty($COURSE->fullname))
                    $return->coursetitle = '<div class="custom_course_title">'. $COURSE->fullname . '</div>';
            
        if(!is_null($COURSECATEGORY && $COURSECATEGORY!=0)) {
            $displaycustomcoursetitle = "displaycoursetitle".$COURSECATEGORY;
            if(isset($page->theme->settings->$displaycustomcoursetitle))
                if(!$page->theme->settings->$displaycustomcoursetitle)             
                    $return->coursetitle = '';
        }

        // category labels
        theme_ucsf_get_category_roots($COURSECATEGORY);
        $COURSECATEGORY = theme_ucsf_get_first_category_customization($page);

        // override top level category label with custom category label
        if(!is_null($COURSECATEGORY && $COURSECATEGORY!=0)) {
            $categorylabelcustom = "categorylabel".$COURSECATEGORY;
            $categorylabelimagecustom = "categorylabelimage".$COURSECATEGORY;
            $categorylabelimageheightcustom = "categorylabelimageheight".$COURSECATEGORY;
            $categorylabelimagealtcustom = "categorylabelimagealt".$COURSECATEGORY;
            $categorylabelimagetitlecustom = "categorylabelimagetitle".$COURSECATEGORY;

            if (!empty($page->theme->settings->$categorylabelcustom)) {
            
                $categorylabelimage = "";
                $imgheight = "";
                $imgalt = "";
                $imgtitle = "";

                if (!empty($page->theme->settings->$categorylabelimagecustom)) {
                    $categorylabelimage = '<div class="category-label-image"><img src="'.$page->theme->setting_file_url('categorylabelimage'.$COURSECATEGORY, 'categorylabelimage'.$COURSECATEGORY).'"';
                }
                if (!empty($page->theme->settings->$categorylabelimageheightcustom)) {
                    $categorylabelimage.= 'height="'.$page->theme->settings->$categorylabelimageheightcustom.'"';
                }
                if (!empty($page->theme->settings->$categorylabelimagealtcustom)) {
                    $categorylabelimage.= 'alt="'.$page->theme->settings->$categorylabelimagealtcustom.'"';
                }
                if (!empty($page->theme->settings->$categorylabelimagetitlecustom)) {
                    $categorylabelimage.= 'title="'.$page->theme->settings->$categorylabelimagetitlecustom.'"';
                }
                if (!empty($page->theme->settings->$categorylabelimagecustom)) {
                    $categorylabelimage.= '/></div>';
                }
                         
                $return->categorylabel = '<div class="category-label pull-left">'.$categorylabelimage.'<div class="category-label-text">'.$page->theme->settings->$categorylabelcustom.'</div></div>';
            }
        }

        // set link label to category page
        $linklabeltocategorypage = "linklabeltocategorypage".$COURSECATEGORY;
        if (isset($page->theme->settings->$linklabeltocategorypage))
            if($page->theme->settings->$linklabeltocategorypage)
                $return->categorylabel = '<a href="'.$CFG->wwwroot.'/course/index.php?categoryid='.$COURSECATEGORY.'"">'.$return->categorylabel.'</a>';
            else 
                $return->categorylabel = $return->categorylabel;

    }    

    // display custom menu
    $return->displaycustommenu = $output->custom_menu();
    if ($page->theme->settings->hidecustommenuwhenloggedout) {
        if(!isloggedin())
            $return->displaycustommenu = '';
    }

    // logo
    $return->logo = '<img title="UCSF | CLE" alt="UCSF | CLE" src="'.$output->pix_url('ucsf-logo', 'theme_ucsf').'"/>';

    // menu background clean css
    $menubackgroundcleen = ""; 

    if($return->categorylabel == '') {
        $menubackgroundcleen = "menu-background-cleen";
    }
    
    $return->menubackgroundcleen = $menubackgroundcleen;

    return $return;
}

function theme_ucsf_get_category_roots($categoryid) {
    global $CATEGORIES, $DB;

    $sql = "SELECT cc.parent, cc.name 
        FROM {course_categories} cc            
        WHERE cc.id = ".$categoryid."";

    $course_categories =  $DB->get_records_sql($sql);
    foreach ($course_categories as $cat) {
        $CATEGORIES[]= $categoryid;
        theme_ucsf_get_category_roots($cat->parent);
    }
}

function theme_ucsf_get_first_category_customization(moodle_page $page) {
    global $CATEGORIES, $DB;

    $categories = get_config('theme_ucsf');
    $all_categories = '';
    $all_categories_array = array();
    if(!empty($categories->all_categories)){
        $all_categories = $categories->all_categories;
        $all_categories_array = explode(",", $all_categories);
    }

    if(is_array($CATEGORIES)) {    
        foreach ($CATEGORIES as $cat) {
            if(in_array($cat, $all_categories_array)) {
                $categorylabelcustom = "categorylabel".$cat;
                if (!empty($page->theme->settings->$categorylabelcustom)) {
                    return $cat;
                }            
            }
        }
    }

    return 0;
}

function theme_ucsf_get_first_category_customization_menu(moodle_page $page) {
    global $CATEGORIES, $DB;

    $categories = get_config('theme_ucsf');
    $all_categories = '';
    $all_categories_array = array();
    if(!empty($categories->all_categories)){
        $all_categories = $categories->all_categories;
        $all_categories_array = explode(",", $all_categories);
    }

    if(is_array($CATEGORIES)) {    
        foreach ($CATEGORIES as $cat) {
            if(in_array($cat, $all_categories_array)) {
                $categorycustommenu = "custommenu".$cat;
                if (!empty($page->theme->settings->$categorycustommenu)) {
                    return $cat;
                }            
            }
        }
    }

    return 0;
}

function theme_ucsf_get_alerts(renderer_base $output, moodle_page $page) {
    global $CFG, $COURSE;
    
    $hasalert1 = false;
    $hasalert2 = false;
    $hasalert3 = false;
    $hasalert4 = false;
    $hasalert5 = false;
    $hasalert6 = false;
    $hasalert7 = false;
    $hasalert8 = false;
    $hasalert9 = false;
    $hasalert10 = false;
    
    $number_of_alerts = isset($page->theme->settings->number_of_alerts) ? intval($page->theme->settings->number_of_alerts) : '';
    
    for ($i = 0; $i <= $number_of_alerts; $i++) {
        
        $category = theme_ucsf_get_setting('categories_list_alert'.$i);
        // get theme comfiguration
        $COURSECATEGORY = 0;
        if ($page->pagelayout=="coursecategory" && isset($_REQUEST["categoryid"]))
            $COURSECATEGORY = $_REQUEST["categoryid"];
        else
            $COURSECATEGORY = $COURSE->category;

        // ALERTS
        // Creating start date.
        $start_date     = (null !== (theme_ucsf_get_setting('start_date'.$i))) ? theme_ucsf_get_setting('start_date'.$i) : ''; 
        $start_hour     = (null !== (theme_ucsf_get_setting('start_hour'.$i))) ? theme_ucsf_get_setting('start_hour'.$i) : '';  
        $start_minute   = (null !== (theme_ucsf_get_setting('start_minute'.$i))) ? theme_ucsf_get_setting('start_minute'.$i) : ''; 
        // Creating a timestamp.
       
        
        // Do not set false if the value is 0.
        if ($start_minute == false) {
            $start_minute = '00';
        }
        
        $start_date_format = date($start_date .' '.$start_hour.':'.$start_minute.':00');
        $start_date_timestamp   = strtotime($start_date_format);
        // Setting start hour and minute.
            
        // Creating end date.
        $end_date   = (null !== (theme_ucsf_get_setting('end_date'.$i))) ? theme_ucsf_get_setting('end_date'.$i) : ''; 
        $end_hour     = (null !== (theme_ucsf_get_setting('end_hour'.$i))) ? theme_ucsf_get_setting('end_hour'.$i) : '';  
        $end_minute   = (null !== (theme_ucsf_get_setting('end_minute'.$i))) ? theme_ucsf_get_setting('end_minute'.$i) : ''; 
        
        // Do not set false if the value is 0.
        if ($end_minute == false) {
            $end_minute = '00';
        }
        
        $end_date_format = date($end_date .' '.$end_hour.':'.$end_minute.':00');
        
        // Creating a timestamp.
        $end_date_timestamp = strtotime($end_date_format);
        
        // Do not set false if the value is 0.
        if ($end_minute == false) {
            $end_minute = '00';
        }
        
         // Get end hours and minutes from settings and put them into timestamp.
        $end_hour_and_minute = $end_hour. ":" .$end_minute;
        $end_hour_and_minute_timestamp = strtotime($end_hour_and_minute);
        
        // Start creating current date format.
        $date_class = new DateTime();
        // Final result in timestamp for currnet date.
        $current_date_timestamp = $date_class->getTimestamp();
        
        // Get current hours and minutes from settings and put them into timestamp.
        $current_hour = date('G');
        $current_minute = date('i');
        $currnet_hour_and_minute = $current_hour. ":" .$current_minute;
        $currnet__hour_and_minute_timestamp = strtotime($currnet_hour_and_minute);
        
        $recurring_alert = theme_ucsf_get_setting('recurring_alert'.$i);

        $enable_alert = theme_ucsf_get_setting('enable'.$i.'alert');
        
        if ($COURSECATEGORY == $category || $category == 0) {
            if((!isset($_SESSION["alerts"]["alert".$i]) || $_SESSION["alerts"]["alert".$i] != 0)) {
                
                // Never end alerts
                if ($recurring_alert == '1') {
                    if ($enable_alert == 1) {
                        $_SESSION["alerts"]["alert".$i] = 1;
                        for($j = 0; $j <= 5; $j ++) {
                            ${'hasalert'.$i} = true;
                        }
                    }
                }
                
                // One time alert.
                if ($recurring_alert == '2') {
                    if ($enable_alert == 1) {
                        $_SESSION["alerts"]["alert".$i] = 1;
                        for($j = 0; $j <= 5; $j ++) {
                            if ($start_date_timestamp <= $currnet__hour_and_minute_timestamp && $end_date_timestamp >= $current_date_timestamp) {
                                    ${'hasalert'.$i} = true;
                            }
                        }
                    }
                
            // Daily alert.
            } elseif ($recurring_alert == '3') {
                
                // Creating start date.
                $start_date = (null !== (theme_ucsf_get_setting('start_date_daily'.$i))) ? theme_ucsf_get_setting('start_date_daily'.$i) : ''; 
                $start_date_timestamp = strtotime($start_date);

                // Creating end date.
                $end_date   = (null !== (theme_ucsf_get_setting('end_date_daily'.$i))) ? theme_ucsf_get_setting('end_date_daily'.$i) : ''; 
                
                // Final result in timestamp for end date.
                $end_date_timestamp = strtotime($end_date);
                
                // Start hour and minute for daily settings.
                $start_daily_hour   = (null !== (theme_ucsf_get_setting('start_only_hour_daily'.$i))) ? theme_ucsf_get_setting('start_only_hour_daily'.$i) : ''; 
                
                $start_daily_minute   = (null !== (theme_ucsf_get_setting('start_only_minute_daily'.$i))) ? theme_ucsf_get_setting('start_only_minute_daily'.$i) : ''; 
                if ($start_daily_minute == false) {
                    $start_daily_minute = '00';
                }
                
                // End hour and minute for daily settings.
                $end_daily_hour   = (null !== (theme_ucsf_get_setting('end_only_hour_daily'.$i))) ? theme_ucsf_get_setting('end_only_hour_daily'.$i) : ''; 
                $end_daily_minute   = (null !== (theme_ucsf_get_setting('end_only_minute_daily'.$i))) ? theme_ucsf_get_setting('end_only_minute_daily'.$i) : ''; 
                if ($end_daily_minute == false) {
                    $end_daily_minute = '00';
                }
                
                // Get start hours and minutes from settings and put them into timestamp.
                $start_hour_and_minute = $start_daily_hour. ":" .$start_daily_minute;
                $start_hour_and_minute_timestamp = strtotime($start_hour_and_minute);
                
                // Get end hours and minutes from settings and put them into timestamp.
                $end_hour_and_minute = $end_daily_hour. ":" .$end_daily_minute;
                $end_hour_and_minute_timestamp = strtotime($end_hour_and_minute);
                
                // Get current hours and minutes from settings and put them into timestamp.
                $current_hour = date('G');
                $current_minute = date('i');
                $currnet_hour_and_minute = $current_hour. ":" .$current_minute;
                $currnet__hour_and_minute_timestamp = strtotime($currnet_hour_and_minute);
                
                $enable_alert = theme_ucsf_get_setting('enable'.$i.'alert');
                if ($enable_alert == 1) {
                    if ($start_date_timestamp < $current_date_timestamp || $end_date_timestamp > $current_date_timestamp || $end_date_timestamp == $current_date_timestamp) {
                        if ($start_hour_and_minute_timestamp <= $currnet__hour_and_minute_timestamp && $end_hour_and_minute_timestamp >= $currnet__hour_and_minute_timestamp) {
                        
                                    ${'hasalert'.$i} = true;
                        }
                    }
                }
            // Weekly alert.
            } elseif ($recurring_alert == '4') {
                
                // Get settings for weekday and put them into timestamp.
                if (theme_ucsf_get_setting('show_week_day'.$i) == '0') {
                    $weekday = 'Sunday';
                    $weekday_timestamp = strtotime($weekday);
                } elseif (theme_ucsf_get_setting('show_week_day'.$i) == '1') {
                    $weekday = 'Monday';
                    $weekday_timestamp = strtotime($weekday);
                } elseif (theme_ucsf_get_setting('show_week_day'.$i) == '2') {
                    $weekday = 'Tuesday';
                    $weekday_timestamp = strtotime($weekday);
                } elseif (theme_ucsf_get_setting('show_week_day'.$i) == '3') {
                    $weekday = 'Wednesday';
                    $weekday_timestamp = strtotime($weekday);
                } elseif (theme_ucsf_get_setting('show_week_day'.$i) == '4') {
                    $weekday = 'Thursday';
                    $weekday_timestamp = strtotime($weekday);
                } elseif (theme_ucsf_get_setting('show_week_day'.$i) == '5') {
                    $weekday = 'Friday';
                    $weekday_timestamp = strtotime($weekday);
                } elseif (theme_ucsf_get_setting('show_week_day'.$i) == '6') {
                    $weekday = 'Saturday';
                    $weekday_timestamp = strtotime($weekday);
                } 
                // Current weekday converted to the timestamp.
                $current_weekday = date('D');
                $current_weekday_timestamp = strtotime($current_weekday);
                
                $start_date     = (null !== (theme_ucsf_get_setting('start_date_weekly'.$i))) ? theme_ucsf_get_setting('start_date_weekly'.$i) : '';   
                $start_date_timestamp   = strtotime($start_date);
                
                 // Setting start hour and minute.
                $start_hour     = (null !== (theme_ucsf_get_setting('start_hour_weekly'.$i))) ? theme_ucsf_get_setting('start_hour_weekly'.$i) : '';  
                $start_minute   = (null !== (theme_ucsf_get_setting('start_minute_weekly'.$i))) ? theme_ucsf_get_setting('start_minute_weekly'.$i) : ''; 
                
                // Do not set false if the value is 0.
                if ($start_minute == false) {
                    $start_minute = '00';
                }
                
                 // Get start hours and minutes from settings and put them into timestamp.
                $start_hour_and_minute = $start_hour. ":" .$start_minute;
                $start_hour_and_minute_timestamp = strtotime($start_hour_and_minute);
                
                // Creating end date.
                $end_date     = (null !== (theme_ucsf_get_setting('end_date_weekly'.$i))) ? theme_ucsf_get_setting('end_date_weekly'.$i) : '';
                $end_date_timestamp = strtotime($end_date);
        
                // Get current hours and minutes from settings and put them into timestamp.
                $current_hour = date('G');
                $current_minute = date('i');
                $currnet_hour_and_minute = $current_hour. ":" .$current_minute;
                $currnet__hour_and_minute_timestamp = strtotime($currnet_hour_and_minute);
                
                 // Setting end hour and minute.
                $end_hour     = (null !== (theme_ucsf_get_setting('end_hour_weekly'.$i))) ? theme_ucsf_get_setting('end_hour_weekly'.$i) : '';  
                $end_minute   = (null !== (theme_ucsf_get_setting('end_minute_weekly'.$i))) ? theme_ucsf_get_setting('end_minute_weekly'.$i) : ''; 
                
                // Do not set false if the value is 0.
                if ($end_minute == false) {
                    $end_minute = '00';
                }
                
                 // Get end hours and minutes from settings and put them into timestamp.
                $end_hour_and_minute = $end_hour. ":" .$end_minute;
                $end_hour_and_minute_timestamp = strtotime($end_hour_and_minute);
                
                $enable_alert = theme_ucsf_get_setting('enable'.$i.'alert');
                if ($enable_alert == 1) {
                    if ($weekday_timestamp == $current_weekday_timestamp) {
                        if ($start_date_timestamp < $current_date_timestamp && $end_date_timestamp > $current_date_timestamp) {
                            $_SESSION["alerts"]["alert".$i] = 1;
                            for($j = 0; $j <= 5; $j ++) {
                                if ($start_hour_and_minute_timestamp < $currnet__hour_and_minute_timestamp && $end_hour_and_minute_timestamp > $currnet__hour_and_minute_timestamp) {
                                    ${'hasalert'.$i} = true;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    $alert=null;

    if ($hasalert1) {
        $alert.= '<div class="useralerts alert alert-'.$page->theme->settings->alert1type.' alert1">';
        $alert.='<a class="close" data-dismiss="alert" data-target-url="'.$CFG->wwwroot.'" href="#">×</a>';
        $alert.='<span class="title">'.$page->theme->settings->alert1title.'</span>'.$page->theme->settings->alert1text;
        $alert.='</div>';
    }

    if ($hasalert2) {
        $alert.= '<div class="useralerts alert alert-'.$page->theme->settings->alert2type.' alert2">';
        $alert.='<a class="close" data-dismiss="alert" data-target-url="'.$CFG->wwwroot.'" href="#">×</a>';
        $alert.='<span class="title">'.$page->theme->settings->alert2title.'</span>'.$page->theme->settings->alert2text;
        $alert.='</div>';
    }

    if ($hasalert3) {
        $alert.= '<div class="useralerts alert alert-'.$page->theme->settings->alert3type.' alert3">';
        $alert.='<a class="close" data-dismiss="alert" data-target-url="'.$CFG->wwwroot.'" href="#">×</a>';
        $alert.='<span class="title">'.$page->theme->settings->alert3title.'</span>'.$page->theme->settings->alert3text;
        $alert.='</div>';
    }

    if ($hasalert4) {
        $alert.= '<div class="useralerts alert alert-'.$page->theme->settings->alert4type.' alert3">';
        $alert.='<a class="close" data-dismiss="alert" data-target-url="'.$CFG->wwwroot.'" href="#">×</a>';
        $alert.='<span class="title">'.$page->theme->settings->alert4title.'</span>'.$page->theme->settings->alert4text;
        $alert.='</div>';
    }

    if ($hasalert5) {
        $alert.= '<div class="useralerts alert alert-'.$page->theme->settings->alert5type.' alert3">';
        $alert.='<a class="close" data-dismiss="alert" data-target-url="'.$CFG->wwwroot.'" href="#">×</a>';
        $alert.='<span class="title">'.$page->theme->settings->alert5title.'</span>'.$page->theme->settings->alert5text;
        $alert.='</div>';
    }

    if ($hasalert6) {
        $alert.= '<div class="useralerts alert alert-'.$page->theme->settings->alert6type.' alert3">';
        $alert.='<a class="close" data-dismiss="alert" data-target-url="'.$CFG->wwwroot.'" href="#">×</a>';
        $alert.='<span class="title">'.$page->theme->settings->alert6title.'</span>'.$page->theme->settings->alert6text;
        $alert.='</div>';
    }

    if ($hasalert7) {
        $alert.= '<div class="useralerts alert alert-'.$page->theme->settings->alert7type.' alert3">';
        $alert.='<a class="close" data-dismiss="alert" data-target-url="'.$CFG->wwwroot.'" href="#">×</a>';
        $alert.='<span class="title">'.$page->theme->settings->alert7title.'</span>'.$page->theme->settings->alert7text;
        $alert.='</div>';
    }

    if ($hasalert8) {
        $alert.= '<div class="useralerts alert alert-'.$page->theme->settings->alert8type.' alert3">';
        $alert.='<a class="close" data-dismiss="alert" data-target-url="'.$CFG->wwwroot.'" href="#">×</a>';
        $alert.='<span class="title">'.$page->theme->settings->alert8title.'</span>'.$page->theme->settings->alert8text;
        $alert.='</div>';
    }

    if ($hasalert9) {
        $alert.= '<div class="useralerts alert alert-'.$page->theme->settings->alert9type.' alert3">';
        $alert.='<a class="close" data-dismiss="alert" data-target-url="'.$CFG->wwwroot.'" href="#">×</a>';
        $alert.='<span class="title">'.$page->theme->settings->alert9title.'</span>'.$page->theme->settings->alert9text;
        $alert.='</div>';
    }

    if ($hasalert10) {
        $alert.= '<div class="useralerts alert alert-'.$page->theme->settings->alert10type.' alert3">';
        $alert.='<a class="close" data-dismiss="alert" data-target-url="'.$CFG->wwwroot.'" href="#">×</a>';
        $alert.='<span class="title">'.$page->theme->settings->alert10title.'</span>'.$page->theme->settings->alert10text;
        $alert.='</div>';
    }

    if( $hasalert1 || $hasalert2 || $hasalert3 || $hasalert4 || $hasalert5  || $hasalert6  || $hasalert7  || $hasalert8  || $hasalert9 || $hasalert10) {
        $alert = '<div class="alerts">'. $alert . '</div>';
    } else if ($page->pagelayout=="frontpage") {
        $alert = '<div class="alerts"></div>';
    }

}
return $alert;
}





function theme_ucsf_get_category_label_image(renderer_base $output, moodle_page $page) {
    $categorylabelimage = "";

    if(!empty($page->theme->settings->categorylabelimage))
        $categorylabelimage = '<img src="'.$page->theme->setting_file_url('categorylabelimage', 'categorylabelimage').'" alt="'.$page->theme->settings->bannerimagealt.'" title="'.$page->theme->settings->bannerimagetitle.'" class="banner-image">';

    return $categorylabelimage;
}

function theme_ucsf_get_banner(renderer_base $output, moodle_page $page) {
    $banner = null;


    $bannerimage = "";
    if(!empty($page->theme->settings->bannerimage))
        $bannerimage = '<img src="'.$page->theme->setting_file_url('bannerimage', 'bannerimage').'" alt="'.$page->theme->settings->bannerimagealt.'" title="'.$page->theme->settings->bannerimagetitle.'" class="banner-image">';

    $bannertext = "";
    if(!empty($page->theme->settings->banner))
        $bannertext = $page->theme->settings->banner;

    if(!empty($page->theme->settings->bannerimage) || !empty($page->theme->settings->banner))
        $banner = '<div class="banner">'.$bannertext.'<div class="banner-image-container">'.$bannerimage.'</div></div>';

    return $banner;
}

function theme_ucsf_get_tiles(renderer_base $output, moodle_page $page) {
    $tiles = null;
    $tilesinnerfirst = null;
    $tilesinnersecond = null;
    $myarr = [null, null, null, null, null, null];

    for ($i = 1; $i <= $page->theme->settings->numberoftiles; $i++){
    $test = theme_ucsf_get_setting('positionoftile'. $i) - 1;
        if (theme_ucsf_get_setting('tile' . $i . 'select') == 1){

            if(theme_ucsf_get_setting('positionoftile'. $i) != false){
                $myarr[$test] = $i;
            }else if(theme_ucsf_get_setting('positionoftile'. $i) == false) {
                array_push($myarr, $i);
            }
        }
    }

    foreach($myarr as $key=>$val) {
        if ($val === null)
            unset($myarr[$key]);
    }

    if(count($myarr) == 4 || count($myarr) == 2){
        foreach($myarr as $index => $arr){
            if ($index < 2) {
                ${'tile' . $arr . 'image'} = "";
                if(!empty(theme_ucsf_get_setting('tile' . $arr . 'image'))) {
                    ${'tile' . $arr . 'image'} = '<img src="'.$page->theme->setting_file_url('tile' . $arr . 'image', 'tile' . $arr . 'image').'" alt="'.theme_ucsf_get_setting('tile' . $arr . 'imagealt').'" title="'.theme_ucsf_get_setting('tile' . $arr . 'imagetitle').'" class="tile-image">'; 
                }
                if(!empty(theme_ucsf_get_setting('tile' . $arr . 'content')) || !empty(theme_ucsf_get_setting('tile' . $arr . 'image'))) {
                    $tileborder = 'tile-border';
                }
                if($arr == null) {
                    $tileborder = '';
                }
                $tilesinnerfirst .='<div class="span6 tile '.$tileborder.' tile-even">'.theme_ucsf_get_setting('tile' . $arr . 'content').'<div class="tile-image-container">'.${'tile' . $arr . 'image'}.'</div></div>';
            } else if($index >1){
                ${'tile' . $arr . 'image'} = "";
                if(!empty(theme_ucsf_get_setting('tile' . $arr . 'image'))) {
                    ${'tile' . $arr . 'image'} = '<img src="'.$page->theme->setting_file_url('tile' . $arr . 'image', 'tile' . $arr . 'image').'" alt="'.theme_ucsf_get_setting('tile' . $arr . 'imagealt').'" title="'.theme_ucsf_get_setting('tile' . $arr . 'imagetitle').'" class="tile-image">';
                }
                if(!empty(theme_ucsf_get_setting('tile' . $arr . 'content')) || !empty(theme_ucsf_get_setting('tile' . $arr . 'image'))) {
                    $tileborder = 'tile-border';
                }
                if($arr == null) {
                    $tileborder = '';
                }

                $tilesinnersecond .='<div class="span6 tile '.$tileborder.' tile-even">'.theme_ucsf_get_setting('tile' . $arr . 'content').'<div class="tile-image-container">'.${'tile' . $arr . 'image'}.'</div></div>';
            }
        }
    }else{
        foreach($myarr as $index => $arr) {
            if($index < 3){
                ${'tile' . $arr . 'image'} = "";
                if(!empty(theme_ucsf_get_setting('tile' . $arr . 'image'))) {
                    ${'tile' . $arr . 'image'} = '<img src="'.$page->theme->setting_file_url('tile' . $arr . 'image', 'tile' . $arr . 'image').'" alt="'.theme_ucsf_get_setting('tile' . $arr . 'imagealt').'" title="'.theme_ucsf_get_setting('tile' . $arr . 'imagetitle').'" class="tile-image">';
                }
                if(!empty(theme_ucsf_get_setting('tile' . $arr . 'content')) || !empty(theme_ucsf_get_setting('tile' . $arr . 'image'))) {
                    $tileborder = 'tile-border';
                }
                if($arr == null) {
                    $tileborder = '';
                }

                $tilesinnerfirst .='<div class="span4 tile '.$tileborder.'">'.theme_ucsf_get_setting('tile' . $arr . 'content').'<div class="tile-image-container">'.${'tile' . $arr . 'image'}.'</div></div>';
            } else if($index < 6) {
                ${'tile' . $arr . 'image'} = "";
                if(!empty(theme_ucsf_get_setting('tile' . $arr . 'image'))) {
                    ${'tile' . $arr . 'image'} = '<img src="'.$page->theme->setting_file_url('tile' . $arr . 'image', 'tile' . $arr . 'image').'" alt="'.theme_ucsf_get_setting('tile' . $arr . 'imagealt').'" title="'.theme_ucsf_get_setting('tile' . $arr . 'imagetitle').'" class="tile-image">';
                }
                if(!empty(theme_ucsf_get_setting('tile' . $arr . 'content')) || !empty(theme_ucsf_get_setting('tile' . $arr . 'image'))) {
                    $tileborder = 'tile-border';
                }
                if($arr == null) {
                    $tileborder = '';
                }

                $tilesinnersecond .='<div class="span4 tile '.$tileborder.'">'.theme_ucsf_get_setting('tile' . $arr . 'content').'<div class="tile-image-container">'.${'tile' . $arr . 'image'}.'</div></div>';
            }
        }
    }

        $tiles .= '<div class="row-fluid">'.$tilesinnerfirst.'</div>';
        $tiles .= '<div class="row-fluid">'.$tilesinnersecond.'</div>';

        return $tiles;
}


/**
 * All theme functions should start with theme_ucsf_
 * @deprecated since 2.5.1
 */
function ucsf_process_css() {
    throw new coding_exception('Please call theme_'.__FUNCTION__.' instead of '.__FUNCTION__);
}

/**
 * All theme functions should start with theme_ucsf_
 * @deprecated since 2.5.1
 */
function ucsf_set_logo() {
    throw new coding_exception('Please call theme_'.__FUNCTION__.' instead of '.__FUNCTION__);
}

/**
 * All theme functions should start with theme_ucsf_
 * @deprecated since 2.5.1
 */
function ucsf_set_customcss() {
    throw new coding_exception('Please call theme_'.__FUNCTION__.' instead of '.__FUNCTION__);
}

function theme_ucsf_page_init(moodle_page $page) {
    $page->requires->jquery();
    $page->requires->jquery_plugin('alert', 'theme_ucsf');  
}
