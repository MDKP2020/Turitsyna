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
                        'group' => '66',
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
                'IVT' => [],
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
        $response = $this->post('/expulsion-api/student/4');

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
    }
}
