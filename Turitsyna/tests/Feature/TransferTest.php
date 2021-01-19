<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Проверяем получение списка групп после перевода
     *
     * @return void
     */
    public function testTransferList()
    {
        $response = $this->get('/transfer-api/createList');

        $response->assertStatus(200);
        $response->assertJson(
        [
            "PRIN" => [
                [
                    "group" => "PRIN-266",
                    "students" => [
                        [
                            "id" => 1,
                            "name" => "Иван",
                            "surname" => "Иванов",
                            "patronomyc" => "Иванович",
                            "created_at" => null,
                            "updated_at" => null
                        ]
                    ]
                ],
                [
                    "group" => "PRIN-366",
                    "students" => [
                        [
                            "id" => 2,
                            "name" => "Петр",
                            "surname" => "Петров",
                            "patronomyc" => "Петрович",
                            "created_at" => null,
                            "updated_at" => null
                        ]
                    ]
                ],
                [
                    "group" => "PRIN-466",
                    "students" => [
                        [
                            "id" => 3,
                            "name" => "Дмитрий",
                            "surname" => "Дмитриев",
                            "patronomyc" => "Дмитриевич",
                            "created_at" => null,
                            "updated_at" => null
                        ]
                    ]
                ]
            ],
            "IVT" => [],
            "IIT" => [],
            "FIZ" => []
        ]);
    }

    /**
     * Проверяем перевод студентов
     *
     * @return void
     */
    public function testTransfer()
    {
        $this->delete('/enrollment-api/delStudFromGroup/4/4', [], []);
        $response = $this->post('/transfer-api/transfer');

        $response->assertStatus(201);
        $this->assertDatabaseHas('study_year', ['start_year' => 2021]);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'PRIN-266']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'PRIN-366']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'PRIN-466']);
        $this->assertDatabaseHas('student_group', ['student_id' => 1, 'group_id' => 1,
            'status_id' => 2]);
        $this->assertDatabaseHas('student_group', ['student_id' => 2, 'group_id' => 2,
            'status_id' => 2]);
        $this->assertDatabaseHas('student_group', ['student_id' => 3, 'group_id' => 3,
            'status_id' => 2]);
    }

}
