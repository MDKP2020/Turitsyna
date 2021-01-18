<?php


namespace App\Models;


use App\Models\Group;
use App\Models\StudentGroup;
class StudentList{
    /**
     * @param string $group
     */
    public function setGroup(string $group): void
    {
        $this->group = $group;
    }
    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @return array
     */
    public function getStudents(): array
    {
        return $this->students;
    }

    public string $group;
    public array $students = array();

    public static function createStudList(Group $group) : ?StudentList{
        $student_list = new StudentList();
        $student_list->group = $group->name;
        foreach ($group->studentGroup as $item){
            $student_list->students[] = $item->student;
        }
        return $student_list;
    }

    public static function createExpulsionStudList(Group $group) : ?StudentList{
        $student_list = new StudentList();
        $student_list->group = $group->name;
        foreach ($group->studentGroup as $item){
            if( in_array($item->student, $student_list->students) ){
                $student_list->students = array_diff($student_list->students, [$item->student]);
            }
            else {
                $student_list->students[] = $item->student;
            }
        }
        if(empty($student_list->students)){
            return null;
        }
        return $student_list;
    }
}
