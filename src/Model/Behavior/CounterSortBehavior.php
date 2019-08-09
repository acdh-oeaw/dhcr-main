<?php


namespace App\Model\Behavior;


use Cake\ORM\Behavior;

class CounterSortBehavior extends Behavior {
	
	public function sortByCourseCount($resultSet = array(), $direction = 'desc') {
		if(strtolower($direction == 'asc'))
			usort($resultSet, array($this, '__cmp_courseCount_asc'));
		else
			usort($resultSet, array($this, '__cmp_courseCount_desc'));
		return $resultSet;
	}
	
	private static function __cmp_courseCount_desc($a, $b) {
		if ($a['course_count'] == $b['course_count']) return 0;
		return ($a['course_count'] < $b['course_count']) ? 1 : -1;
	}
	
	private static function __cmp_courseCount_asc($a, $b) {
		if ($a['course_count'] == $b['course_count']) return 0;
		return ($a['course_count'] < $b['course_count']) ? -1 : 1;
	}
}