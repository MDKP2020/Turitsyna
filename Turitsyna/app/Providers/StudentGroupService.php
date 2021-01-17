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
    public function getStudentByFIO(string $name, string $surname, string $patronomyc) : Student{
        return Student::all()->where('name', '=', $name )
            ->where('surname', '=', $surname)
            ->where('patronomyc', '=', $patronomyc)
            ->first();
    }

    public function getStudentsAndGroups(Collection $groups){
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

                $pos = strpos($tmp_list->getGroup(), '-');
                $tmp_list->setGroup(substr_replace($tmp_list->getGroup(), strval($group->course + 1),  $pos+1, 1));

                $tmp_arr[] = $tmp_list;
            }
            //Добавляем список групп и студентов в данном направлении в итоговый массив
            $result_list[$direction->name] = $tmp_arr;
        }
        return $result_list;
    }

    public function getGroupByNameYearCourse(string $name, int $year, int $course) : Group{
        return Group::all()->where('name','=', $name)
                        ->where('study_year_id','=', StudyYear::all()->where('start_year', '=', $year)->first()->id)
                        ->where('course','=', $course)
                        ->first();
    }

    public function lastStudentGroup(Student $student) : Group{
        return $student->student_group()
                            ->where('status_id', '=', Status::find('Enrolled')->id)
                            ->where('date', '=', max('date'))->first()->group;
    }

    public function currentYear(){
        return StudyYear::where('start_year', '=', StudyYear::max('start_year'))->first();
    }

    protected function groupNameTemplate(string $direction, int $course) : string{
            //
    }

}
