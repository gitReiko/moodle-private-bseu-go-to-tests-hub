<?php 

namespace Blocks\GoToTestsHub;

class DataGetter 
{
    private $userCohortId;
    private $cohortName;
    private $courses;
    private $testHubId;

    function __construct()
    {
        $this->userCohortId = $this->get_user_cohort_id();
        $this->cohortName = $this->get_cohort_name();

        if(empty($this->cohortName))
        {
            $this->testHubId = Main::HUB_NOT_EXIST;
        }
        else 
        {
            $this->courses = $this->get_courses_from_database();
            $this->testHubId = $this->get_tests_hub_id_from_courses();
        }
    }

    public function get_tests_hub_id()
    {
        return $this->testHubId;
    }

    private function get_user_cohort_id() 
    {
        global $DB, $USER;
        $where = array('userid' => $USER->id);
        return $DB->get_field('cohort_members', 'cohortid', $where);
    }

    private function get_cohort_name()
    {
        global $DB;
        $where = array('id' => $this->userCohortId);
        return $DB->get_field('cohort', 'name', $where);
    }

    private function get_courses_from_database()
    {
        global $DB;
        return $DB->get_records('course', array(), '', 'id, shortname');
    }

    private function get_tests_hub_id_from_courses() 
    {
        foreach($this->courses as $course)
        {
            if(mb_stripos($this->cohortName, $course->shortname) !== false)
            {
                return $course->id;
            }
        }

        return Main::HUB_NOT_EXIST;
    }



}
