<?php

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\I18n\FrozenTime;

/*  This file should be run on build to create the JSON file for the seach bar
    As well it should be run automatically on regular basis */

class GenSearchListCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $this->loadModel('DhcrCore.Courses');
        $this->loadModel('Logentries');

        $io->out('~~~ Started: Generate Search List ~~~');

        $courses = $this->Courses->find('all',  [
            'contain' => ['Institutions', 'CourseTypes'],
            'order' => ['Courses.name' => 'asc']
        ])->where(
            [
                'active' => 1,
                'deleted' => 0,
                'Courses.updated >' => new FrozenTime('-489 Days'),
                'approved' => 1
            ]
        );
        $searchList = [];
        foreach ($courses as $course) {
            $searchList[] = trim($course->name) . '  -  ' . trim($course->institution->name) . '  -  ' . trim($course->course_type->name);
        }

        $file = fopen('webroot/search_list.json', 'w');
        fwrite($file, json_encode($searchList));
        fclose($file);

        $this->Logentries->createLogEntry(
            '10',
            '586',
            basename(__FILE__, '.php'),
            'Generated Search List.',
            'Total Courses: ' . sizeof($searchList)
        );

        $io->out('Total courses: ' . sizeof($searchList));
        $io->out('~~~ Finished: Generate Search List ~~~');
    }
}
