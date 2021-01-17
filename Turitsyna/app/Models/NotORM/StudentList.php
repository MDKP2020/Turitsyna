<?php


namespace App\Models;


class StudentList{
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

    private string $group;
    private array $students = array();

    public static function createStudList(Group $group){
        $student_list = new StudentList();
        $student_list->group = $group->name;
        foreach ( $group->student_group() as $item){
            $student_list->students[] = $item->student();
        }
        return $student_list;
    }
}
