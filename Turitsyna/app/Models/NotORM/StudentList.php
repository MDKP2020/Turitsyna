<?php


namespace App\Models;


class StudentList{
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
