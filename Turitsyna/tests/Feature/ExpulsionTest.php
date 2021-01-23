<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpulsionTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Проверяем список студентов на отчисление
     *
     * @return void
     */
    public function testGetGraduatesList()
    {
        $response = $this->get('/expulsion-api/createList');

        $response->assertStatus(200);
        $response->assertJson(
            [
                "PRIN" => [
                    [
                        'group' => 'PRIN-466',
                        "students" => [
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
                'IVT' => [
                    [
                        'group' => 'IVT-463',
                        "students" => [
                            [
                                "id" => 8,
                                "name" => "Мария",
                                "surname" => "Артемова",
                                "patronomyc" =>"Артемовна",
                                "created_at" => null,
                                "updated_at" => null
                            ]

                        ]
                    ]
                ],
                'IIT' => [],
                'FIZ' => []
            ]);
    }

    /**
     * Проверяем список студентов на отчисление при отсутствии студентов на 4-м курсе
     *
     * @return void
     */
    public function testGetGraduatesListNoStudentsOn4Course()
    {
        $this->delete('/enrollment-api/delStudFromGroup/4/4', [], []);
        $this->delete('/enrollment-api/delStudFromGroup/8/8', [], []);
        $response = $this->get('/expulsion-api/createList');

        $response->assertStatus(200);
        $response->assertJson(
            [
                "PRIN" => [
                    [
                        'group' => 'PRIN-466',
                        "students" => []
                    ]
                ],
                'IVT' => [
                    [
                        'group' => 'IVT-463',
                        "students" => []
                    ]
                ],
                'IIT' => [],
                'FIZ' => []
            ]);
    }

    /**
     * Отчисляем студента
     *
     * @return void
     */
    public function testStudentExpulsion()
    {
        $response = $this->post('/expulsion-api/student/4', [], []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('student_group', [
            'student_id' => 4,
            'group_id' => 4,
            'status_id' => 2
        ]);
    }

    /**
     * Отчисляем несуществующего студента
     *
     * @return void
     */
    public function testUnknownStudentExpulsion()
    {
        $response = $this->post('/expulsion-api/student/50');

        $response->assertStatus(404);
        $response->assertJson(['Student not found']);
    }

    /**
     * Отчисляем несуществующего студента
     *
     * @return void
     */
    public function testStudentExpulsionInvalidId()
    {
        $response = $this->post('/expulsion-api/student/null');

        $response->assertStatus(404);
        $response->assertJson(['Invalid student id']);
    }

    /**
     * Отчисляем группу из 1 студента
     *
     * @return void
     */
    public function testGroupSmallExpulsion()
    {
        $response = $this->post('/expulsion-api/group/4');

        $response->assertStatus(200);
        $this->assertDatabaseHas('student_group', [
            'student_id' => 4,
            'group_id' => 4,
            'status_id' => 2
        ]);
    }

    /**
     * Отчисляем несуществующую группу
     *
     * @return void
     */
    public function testUnknownGroupExpulsion()
    {
        $response = $this->post('/expulsion-api/group/50');

        $response->assertStatus(404);
        $response->assertJson(['Group not found']);
    }

    /**
     * Отчисляем группу с id в виде строки
     *
     * @return void
     */
    public function testGroupExpulsionInvalidId()
    {
        $response = $this->post('/expulsion-api/group/first');

        $response->assertStatus(400);
        $response->assertJson(['Invalid group id']);
    }

    /**
     * Отчисляем студентов 4-го курса
     *
     * @return void
     */
    public function testGraduatesExpulsion()
    {
        $response = $this->post('/expulsion-api/graduates');

        $response->assertStatus(200);
        $this->assertDatabaseHas('student_group', [
            'student_id' => 4,
            'group_id' => 4,
            'status_id' => 2
        ]);
        $this->assertDatabaseHas('student_group', [
            'student_id' => 8,
            'group_id' => 8,
            'status_id' => 2
        ]);
    }

    /**
     * Отчисляем студентов 4-го курса при остутствии студентов на 4-м курсе
     *
     * @return void
     */
    public function testGraduatesExpulsionWithoutStudentsOn4Course()
    {
        $this->delete('/enrollment-api/delStudFromGroup/4/4', [], []);
        $this->delete('/enrollment-api/delStudFromGroup/8/8', [], []);
        $response = $this->post('/expulsion-api/graduates');

        $response->assertStatus(200);
        $this->assertDatabaseMissing('student_group', [
            'group_id' => 4,
            'status_id' => 2
        ]);
        $this->assertDatabaseMissing('student_group', [
            'group_id' => 8,
            'status_id' => 2
        ]);
    }
}
