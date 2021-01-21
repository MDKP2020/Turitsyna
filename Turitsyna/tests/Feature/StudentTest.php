<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Получить полную информацию о студенте
     *
     * @return void
     */
    public function testGetStudentInfo()
    {
        $response = $this->post('/student-api/getStudent/', [
            'name' => 'Иван',
            'surname' => 'Иванов',
            'patronomyc' => 'Иванович',
        ], []);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => 1,
            'name' => 'Иван',
            'surname' => 'Иванов',
            'patronomyc' => 'Иванович']);
    }

    /**
     * Получить полную информацию о несуществующем студенте
     *
     * @return void
     */
    public function testGetUnknownStudentInfo()
    {
        $response = $this->post('/student-api/getStudent/', [
            'name' => 'Иван1',
            'surname' => 'Иванов1',
            'patronomyc' => 'Иванович1',
        ]);

        $response->assertStatus(200);
        $response->assertJson([]);
    }

    /**
     * Получить полную информацию о студенте по параметрам с некорректными типами
     *
     * @return void
     */
    public function testGetStudentInfoInvalidRequestParams()
    {
        $response = $this->post('/student-api/getStudent/', [
            'name' => 1,
            'surname' => true,
            'patronomyc' => 2.0,
        ]);

        $response->assertStatus(400);
        $response->assertJson(['Invalid parameters type']);
    }

    /**
     * Получить полную информацию о студенте по неполным данным
     *
     * @return void
     */
    public function testGetStudentInfoPartialRequestParams()
    {
        $response = $this->post('/student-api/getStudent/', [
            'name' => 'Иван',
            'surname' => 'Иванов',
        ]);

        $response->assertStatus(400);
        $response->assertJson(['Not enough information']);
    }

    /**
     * Получить студентов из группы
     *
     * @return void
     */
    public function testGetStudentsFromGroup()
    {
        $response = $this->get('/student-api/getStudentsFromGroup/1',[]);

        $response->assertStatus(200);
        $response->assertJson([
            'name' => 'PRIN-166',
            'students' => [
                [
                    'id' => 1,
                    'name' => 'Иван',
                    'surname' => 'Иванов',
                    'patronomyc' => 'Иванович',
                    "created_at" => null,
                    "updated_at" => null
                ]
            ]
        ]);
    }

    /**
     * Получить студентов из пустой группы
     *
     * @return void
     */
    public function testGetStudentsFromEmptyGroup()
    {
        $this->delete('/enrollment-api/delStudFromGroup/1/1', [], []);
        $response = $this->get('/student-api/getStudentsFromGroup/1',[]);

        $response->assertStatus(200);
        $response->assertJson(['name' => 'PRIN-166', 'students' => []]);
    }

    /**
     * Получить студентов из несуществующей группы
     *
     * @return void
     */
    public function testGetStudentsFromUnknownGroup()
    {
        $response = $this->get('/student-api/getStudentsFromGroup/6',[]);

        $response->assertStatus(400);
        $response->assertJson(['There is no group with such id']);
    }

    /**
     * Получить студентов из группы, ID которой задан строкой
     *
     * @return void
     */
    public function testGetStudentsFromGroupInvalidRequestParam()
    {
        $response = $this->get('/student-api/getStudentsFromGroup/null',[]);

        $response->assertStatus(404);
        $response->assertJson(['Invalid group id']);
    }

    /**
     * Получить группы со студентами с заданными фильтрами на существующие группы и существующий год
     *
     * @return void
     */
    public function testGetStudentsAndGroupsAllPrinGroups()
    {
        $response = $this->post('/student-api/getGroupStudentsList',[
            'direction_id' => [1],
            'study_year_id' => 4,
        ], []);

        $response->assertStatus(200);
        $response->assertJson([
            "PRIN" =>
            [
                [
                    'group' => 'PRIN-166',
                    "students" =>
                        [
                            [
                                "id" => 1,
                                "name" => "Иван",
                                "surname" => "Иванов",
                                "patronomyc" =>"Иванович",
                                "created_at" => null,
                                "updated_at" => null
                            ]
                        ]
                ],
                [
                    'group' => 'PRIN-266',
                    "students" =>
                        [
                            [
                                "id" => 2,
                                "name" => "Петр",
                                "surname" => "Петров",
                                "patronomyc" =>"Петрович",
                                "created_at" => null,
                                "updated_at" => null
                            ]
                        ]
                ],
                [
                    'group' => 'PRIN-366',
                    "students" =>
                    [
                        [
                            "id" => 3,
                            "name" => "Дмитрий",
                            "surname" => "Дмитриев",
                            "patronomyc" =>"Дмитриевич",
                            "created_at" => null,
                            "updated_at" => null
                        ]
                    ]
                ],
                [
                    'group' => 'PRIN-466',
                    "students" =>
                    [
                        [
                            "id" => 4,
                            "name" => "Артем",
                            "surname" => "Артемов",
                            "patronomyc" =>"Артемович",
                            "created_at" => null,
                            "updated_at" => null
                        ]
                    ]
                ]
            ],
            'IVT' => [],
            'IIT' => [],
            'FIZ' => []
        ]);
    }

    /**
     * Получить группы принов 2-го курса текущего года
     *
     * @return void
     */
    public function testGetStudentsAndGroupsOneGroup()
    {
        $response = $this->post('/student-api/getGroupStudentsList',[
            'direction_id' => [1],
            'study_year_id' => 4,
            'course' => [2]
        ], []);

        $response->assertStatus(200);
        $response->assertJson([
            "PRIN" =>
                [
                    [
                        'group' => 'PRIN-266',
                        "students" =>
                            [
                                [
                                    "id" => 2,
                                    "name" => "Петр",
                                    "surname" => "Петров",
                                    "patronomyc" =>"Петрович",
                                    "created_at" => null,
                                    "updated_at" => null
                                ]
                            ]
                    ]
                ],
            'IVT' => [],
            'IIT' => [],
            'FIZ' => []
        ]);
    }

    /**
     * Получить группы принов 2-го курса текущего года (без явного указания на текущий год)
     *
     * @return void
     */
    public function testGetStudentsAndGroupsOneGroupDefaultYear()
    {
        $response = $this->post('/student-api/getGroupStudentsList',[
            'direction_id' => [1],
            'course' => [2]
        ], []);

        $response->assertStatus(200);
        $response->assertJson([
            "PRIN" =>
                [
                    [
                        'group' => 'PRIN-266',
                        "students" =>
                            [
                                [
                                    "id" => 2,
                                    "name" => "Петр",
                                    "surname" => "Петров",
                                    "patronomyc" =>"Петрович",
                                    "created_at" => null,
                                    "updated_at" => null
                                ]
                            ]
                    ]
                ],
            'IVT' => [],
            'IIT' => [],
            'FIZ' => []
        ]);
    }

    /**
     * Получить группы принов 2-го курса прошлого года
     *
     * @return void
     */
    public function testGetStudentsAndGroupsOneGroupPreviousYear()
    {
        $response = $this->post('/student-api/getGroupStudentsList',[
            'direction_id' => [1],
            'study_year_id' => 1,
            'course' => [2]
        ], []);

        $response->assertStatus(200);
        $response->assertJson([
            "PRIN" => [],
            'IVT' => [],
            'IIT' => [],
            'FIZ' => []
        ]);
    }

    /**
     * Получить все группы 2-го курса прошлого года
     *
     * @return void
     */
    public function testGetStudentsAndGroupsAllGroupsPreviousYear()
    {
        $response = $this->post('/student-api/getGroupStudentsList',[
            'direction_id' => [1, 2, 3, 4],
            'study_year_id' => 1,
            'course' => [2]
        ], []);

        $response->assertStatus(200);
        $response->assertJson([
            "PRIN" => [],
            'IVT' => [],
            'IIT' => [],
            'FIZ' => []
        ]);
    }

    /**
     * Получить группы ИВТ и ИИТ текущего года
     *
     * @return void
     */
    public function testGetStudentsAndGroupsSomeGroups()
    {
        $response = $this->post('/student-api/getGroupStudentsList',[
            'direction_id' => [2, 3],
            'study_year_id' => 4,
            'course' => [2]
        ], []);

        $response->assertStatus(200);
        $response->assertJson([
            "PRIN" => [],
            'IVT' => [],
            'IIT' => [],
            'FIZ' => []
        ]);
    }

    /**
     * Получить группы с фильтрами по умолчанию
     *
     * @return void
     */
    public function testGetStudentsAndGroupsAllDefaultParams()
    {
        $response = $this->post('/student-api/getGroupStudentsList',[], []);

        $response->assertStatus(200);
        $response->assertJson([
            "PRIN" =>
                [
                    [
                        'group' => 'PRIN-166',
                        "students" =>
                            [
                                [
                                    "id" => 1,
                                    "name" => "Иван",
                                    "surname" => "Иванов",
                                    "patronomyc" =>"Иванович",
                                    "created_at" => null,
                                    "updated_at" => null
                                ]
                            ]
                    ],
                    [
                        'group' => 'PRIN-266',
                        "students" =>
                            [
                                [
                                    "id" => 2,
                                    "name" => "Петр",
                                    "surname" => "Петров",
                                    "patronomyc" =>"Петрович",
                                    "created_at" => null,
                                    "updated_at" => null
                                ]
                            ]
                    ],
                    [
                        'group' => 'PRIN-366',
                        "students" =>
                            [
                                [
                                    "id" => 3,
                                    "name" => "Дмитрий",
                                    "surname" => "Дмитриев",
                                    "patronomyc" =>"Дмитриевич",
                                    "created_at" => null,
                                    "updated_at" => null
                                ]
                            ]
                    ],
                    [
                        'group' => 'PRIN-466',
                        "students" =>
                            [
                                [
                                    "id" => 4,
                                    "name" => "Артем",
                                    "surname" => "Артемов",
                                    "patronomyc" =>"Артемович",
                                    "created_at" => null,
                                    "updated_at" => null
                                ]
                            ]
                    ]
                ],
            'IVT' => [],
            'IIT' => [],
            'FIZ' => []
        ]);
    }

    /**
     * Получить группы по некорректным параметрам
     *
     * @return void
     */
    public function testGetStudentsAndGroupsInvalidParamsTypes()
    {
        $response = $this->post('/student-api/getGroupStudentsList',[
            'direction_id' => '2, 3',
            'study_year_id' => 'four',
            'course' => 'second'
        ], []);

        $response->assertStatus(400);
        $response->assertJson(['Invalid request body parameters']);
    }

    /**
     * Получить группы ИВТ и ИИТ текущего года
     *
     * @return void
     */
    public function testGetStudentsAndGroupsExtraParams()
    {
        $response = $this->post('/student-api/getGroupStudentsList',[
            'direction_id' => [1, 2, 3],
            'study_year_id' => 4,
            'course' => [2],
            'param1' => 'Unknown'
        ], []);

        $response->assertStatus(200);
        $response->assertJson([
            "PRIN" =>
                [
                    [
                        'group' => 'PRIN-266',
                        "students" =>
                            [
                                [
                                    "id" => 2,
                                    "name" => "Петр",
                                    "surname" => "Петров",
                                    "patronomyc" =>"Петрович",
                                    "created_at" => null,
                                    "updated_at" => null
                                ]
                            ]
                    ]
                ],
            'IVT' => [],
            'IIT' => [],
            'FIZ' => []
        ]);
    }

}
