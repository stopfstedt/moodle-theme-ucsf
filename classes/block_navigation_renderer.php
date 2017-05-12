<?php

defined('MOODLE_INTERNAL') || die();

include_once ($CFG->dirroot . "/blocks/navigation/renderer.php");

/**
 * Block Navigation Renderer.
 *
 * @package theme_ucsf
 */
class theme_ucsf_block_navigation_renderer extends block_navigation_renderer {

    /**
     * @inheritdoc;
     */
    public function navigation_tree(global_navigation $navigation, $expansionlimit, array $options = array()) {

        $navigation->children = $this->tweak_my_courses($navigation->children);

        return parent::navigation_tree($navigation, $expansionlimit, $options);
    }

    /**
     * Various tweaks to the "My Courses" section of the nav block.
     * a) force the active course under "My Courses" to the top of the list.
     * b) flag the section to be hidden if no course is active.
     *
     * @param navigation_node_collection $children
     * @return navigation_node_collection
     */
    protected function tweak_my_courses(navigation_node_collection $children)
    {
        $my_courses = $children->get('mycourses');

        if (empty($my_courses)) {
            return $children;
        }

        // add a class so we can style "My courses".
        // see the "Navigation Block" section in style/custom.css
        $my_courses->classes[] = 'mycourses';

        $my_courses_children = $my_courses->children;

        $active_course = false;
        $first_course = false;

        // find the currently active course,
        // and grab the first course while at it.
        foreach ($my_courses_children as $child) {
            if (! $first_course) {
                $first_course = $child;
            }

            // yes, force-open qualifies as "active".
            if ($child->isactive || $child->forceopen) {
                $active_course = $child;
                break;
            }
        }

        // no "active" course? then hide "My courses".
        if (! $active_course) {
            $my_courses->classes[] = 'hidden';
            return $children;
        }

        // if the "active" course is not the first course in the list, then move it there.
        if ($first_course !== $active_course)  {
            $my_courses_children->remove($active_course->key);
            $my_courses_children->add($active_course, $first_course->key);
        }
        return $children;
    }
}
