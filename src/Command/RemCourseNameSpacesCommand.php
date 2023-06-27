<?php

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\I18n\FrozenTime;

/*  This file should be run only once 
    Is related to GitHub issue #73
    Removes all leading and trailing spaces from names of public shown courses
    From now on this will be done automatically on add/edit
*/

class RemCourseNameSpacesCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $this->loadModel('DhcrCore.Courses');

        $courses = $this->Courses->find('all', [
            'order' => ['Courses.id' => 'ASC']
        ])->where(
            [
                'active' => 1,
                'deleted' => 0,
                'Courses.updated >' => new FrozenTime('-489 Days'),
                'approved' => 1
            ]
        );

        $totalChanged = 0;
        foreach ($courses as $course) {
            $course->set('name', trim($course->name));
            if ($this->Courses->save($course)) {
                $totalChanged++;
            } else {
                $io->out('Error at course: ' . $course->id);
            }
        }

        $io->out('Total courses changed: ' . $totalChanged);
    }
}
