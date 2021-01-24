<?php

namespace App\Providers;

use App\Models\Direction;
use App\Models\Group;
use App\Models\Status;
use App\Models\Student;
use App\Models\StudyYear;
use App\Models\StudentGroup;
use App\Models\StudentList;
use Illuminate\Database\Eloquent\Collection;

class StudentGroupService
{
    public function getStudentByFIO(string $name, string $surname, string $patronomyc) : ?Student{
        return Student::all()->where('name', '=', $name )
            ->where('surname', '=', $surname)
            ->where('patronomyc', '=', $patronomyc)
            ->first();
    }

    /*public function getStudentsAndGroups(Collection $groups){
        //Итоговый массив

        $result_list = array();
        $directions = Direction::all();

        //По всем направлениям обучения
        foreach ($directions as $direction){

            $tmp_arr = array();
            //По всем группам по этому направлению формируем список студентов {name: "IVT-260"; students: [..]}
            foreach($groups->where('direction_id', '=', $direction->id) as $group){
                $tmp_arr[] = StudentList::createStudList($group);
            }

            //Добавляем список групп и студентов в данном направлении в итоговый массив
            $result_list[$direction->name] = $tmp_arr;
        }
        return $result_list;
    }*/

    public function getStudentsAndGroups(Collection $groups){
        //Итоговый массив

        $result_list = array();
        $directions = Direction::all();

        //По всем направлениям обучения
        foreach ($directions as $direction){

            $tmp_arr = array();
            //По всем группам по этому направлению формируем список студентов {name: "IVT-260"; students: [..]}
            foreach($groups->where('direction_id', '=', $direction->id) as $group){
                $tmp = StudentList::createStudList($group);
                if($tmp != null ){
                    $tmp_arr[] = $tmp;
                }
            }

            //Добавляем список групп и студентов в данном направлении в итоговый массив
            $result_list[$direction->name] = $tmp_arr;
        }
        return $result_list;
    }

    public function getStudentsAndGroupsNextCourse(Collection $groups){
        //Итоговый массив
        $result_list = array();
        $directions = Direction::all();

        //По всем направлениям обучения
        foreach ($directions as $direction){
            $tmp_arr = array();

            foreach($groups->where('direction_id','=',$direction->id) as $group){

                $tmp_list = StudentList::createStudList($group);
                if($tmp_list == null) continue;
                $pos = strpos($tmp_list->getGroup(), '-');
                $tmp_list->setGroup(substr_replace($tmp_list->getGroup(), strval($group->course + 1),  $pos+1, 1));

                $tmp_arr[] = $tmp_list;
            }
            //Добавляем список групп и студентов в данном направлении в итоговый массив
            $result_list[$direction->name] = $tmp_arr;
        }
        return $result_list;
    }

    public function getGroupByNameYearCourse(string $name, int $year, int $course) : ?Group{
        $year_id = StudyYear::all()->where('start_year', '=', $year)->first->id;
        $groups = Group::all();
        return $groups->first(function ($item) use ($year_id, $course, $name) {
           return $item->name == $name && $item->study_year_id == $year_id && $item->couse == $course;
        });

    }

    public function lastStudentGroup(Student $student) :?StudentGroup{
        $date = StudentGroup::all()->where('student_id', '=', $student->id)
            ->where('status_id', '=', Status::whereName('Enrolled')->first()->id)->max('date');

        return $student->student_group->first(function($item) use ($date) {
            return $item->status_id == Status::whereName('Enrolled')->first()->id && $item->date == $date;
        });
    }

    public function currentYear(){
        return StudyYear::where('start_year', '=', StudyYear::max('start_year'))->first();
    }
}
