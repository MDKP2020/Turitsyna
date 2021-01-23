<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Student;
use App\Models\StudentGroup;
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
        $this->delete('/enrollment-api/delStudFromGroup/4/4', [], []);
        $this->delete('/enrollment-api/delStudFromGroup/8/8', [], []);
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
            "IVT" => [
                [
                    "group" => "IVT-263",
                    "students" => [
                        [
                            "id" => 5,
                            "name" => "Александра",
                            "surname" => "Александрова",
                            "patronomyc" => "Александровна",
                            "created_at" => null,
                            "updated_at" => null
                        ]
                    ]
                ],
                [
                    "group" => "IVT-363",
                    "students" => [
                        [
                            "id" => 6,
                            "name" => "Евгения",
                            "surname" => "Евгеньева",
                            "patronomyc" => "Евгеньевна",
                            "created_at" => null,
                            "updated_at" => null
                        ]
                    ]
                ],
                [
                    "group" => "IVT-463",
                    "students" => [
                        [
                            "id" => 7,
                            "name" => "Марина",
                            "surname" => "Дмитриева",
                            "patronomyc" => "Александровна",
                            "created_at" => null,
                            "updated_at" => null
                        ]
                    ]
                ]
            ],
            "IIT" => [],
            "FIZ" => []
        ]);
    }

    /**
     * Проверяем получение списка групп после перевода при наличии 4-го курса
     *
     * @return void
     */
    public function testTransferListStudentOn4Course()
    {
        $response = $this->get('/transfer-api/createList');

        $response->assertJson(['Cant transfer students']);
        $response->assertStatus(400);

    }

    /**
     * Проверяем получение списка групп после перевода при остуствии групп и студентов
     *
     * @return void
     */
    public function testTransferListEmptyDatabase()
    {
        StudentGroup::truncate();
        Group::truncate();
        Student::truncate();
        $response = $this->get('/transfer-api/createList');

        $response->assertJson(['Not found 1-3 course groups']);
        $response->assertStatus(404);

    }

    /**
     * Проверяем получение списка групп после перевода при остуствии студентов в группах
     *
     * @return void
     */
    public function testTransferListEmptyGroups()
    {
        StudentGroup::truncate();
        Student::truncate();
        $response = $this->get('/transfer-api/createList');

        $response->assertStatus(200);
        $response->assertJson(
            [
                "PRIN" => [
                    [
                        "group" => "PRIN-266",
                        "students" => []
                    ],
                    [
                        "group" => "PRIN-366",
                        "students" => []
                    ],
                    [
                        "group" => "PRIN-466",
                        "students" => []
                    ]
                ],
                "IVT" => [
                    [
                        "group" => "IVT-263",
                        "students" => []
                    ],
                    [
                        "group" => "IVT-363",
                        "students" => []
                    ],
                    [
                        "group" => "IVT-463",
                        "students" => []
                    ]
                ],
                "IIT" => [],
                "FIZ" => []
            ]);
    }

    /**
     * Проверяем получение списка групп при наличии студентов только в некоторых группах
     *
     * @return void
     */
    public function testTransferListSomeGroups()
    {
        $this->delete('/enrollment-api/delStudFromGroup/4/4', [], []);
        $this->delete('/enrollment-api/delStudFromGroup/2/2', [], []);
        $this->delete('/enrollment-api/delStudFromGroup/6/6', [], []);
        $this->delete('/enrollment-api/delStudFromGroup/8/8', [], []);

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
                        "students" => []
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
                "IVT" => [
                    [
                        "group" => "IVT-263",
                        "students" => [
                            [
                                "id" => 5,
                                "name" => "Александра",
                                "surname" => "Александрова",
                                "patronomyc" => "Александровна",
                                "created_at" => null,
                                "updated_at" => null
                            ]
                        ]
                    ],
                    [
                        "group" => "IVT-363",
                        "students" => []
                    ],
                    [
                        "group" => "IVT-463",
                        "students" => [
                            [
                                "id" => 7,
                                "name" => "Марина",
                                "surname" => "Дмитриева",
                                "patronomyc" => "Александровна",
                                "created_at" => null,
                                "updated_at" => null
                            ]
                        ]
                    ]
                ],
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
        $this->delete('/enrollment-api/delStudFromGroup/8/8', [], []);
        $response = $this->post('/transfer-api/transfer');

        $response->assertStatus(201);
        $this->assertDatabaseHas('study_year', ['start_year' => 2021]);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'PRIN-266']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'PRIN-366']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'PRIN-466']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'IVT-263']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'IVT-363']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'IVT-463']);
        $this->assertDatabaseHas('student_group', ['student_id' => 1, 'group_id' => 1,
            'status_id' => 2]);
        $this->assertDatabaseHas('student_group', ['student_id' => 2, 'group_id' => 2,
            'status_id' => 2]);
        $this->assertDatabaseHas('student_group', ['student_id' => 3, 'group_id' => 3,
            'status_id' => 2]);
        $this->assertDatabaseHas('student_group', ['student_id' => 5, 'group_id' => 5,
            'status_id' => 2]);
        $this->assertDatabaseHas('student_group', ['student_id' => 6, 'group_id' => 6,
            'status_id' => 2]);
        $this->assertDatabaseHas('student_group', ['student_id' => 7, 'group_id' => 7,
            'status_id' => 2]);
    }

    /**
     * Проверяем перевод студентов при остуствии групп и студентов
     *
     * @return void
     */
    public function testTransferEmptyDatabase()
    {
        StudentGroup::truncate();
        Group::truncate();
        Student::truncate();
        $response = $this->post('/transfer-api/transfer');

        $response->assertStatus(404);
        $response->assertJson(['Not found 1-3 course groups']);
    }

    /**
     * Проверяем перевод студентов при остуствии студентов в группах
     *
     * @return void
     */
    public function testTransferEmptyGroups()
    {
        StudentGroup::truncate();
        Student::truncate();
        $response = $this->post('/transfer-api/transfer');

        $response->assertStatus(200);
        $response->assertJson(
        [
            "PRIN" => [
                [
                    "group" => "PRIN-266",
                    "students" => []
                ],
                [
                    "group" => "PRIN-366",
                    "students" => []
                ],
                [
                    "group" => "PRIN-466",
                    "students" => []
                ]
            ],
            "IVT" => [
                [
                    "group" => "IVT-263",
                    "students" => []
                ],
                [
                    "group" => "IVT-363",
                    "students" => []
                ],
                [
                    "group" => "IVT-463",
                    "students" => []
                ]
            ],
            "IIT" => [],
            "FIZ" => []
        ]);
    }

    /**
     * Проверяем перевод студентов при наличии студентов только в некоторых группах
     *
     * @return void
     */
    public function testTransferSomeGroups()
    {
        $this->delete('/enrollment-api/delStudFromGroup/4/4', [], []);
        $this->delete('/enrollment-api/delStudFromGroup/2/2', [], []);
        $this->delete('/enrollment-api/delStudFromGroup/6/6', [], []);
        $this->delete('/enrollment-api/delStudFromGroup/8/8', [], []);
        $response = $this->post('/transfer-api/transfer');

        $response->assertStatus(201);
        $this->assertDatabaseHas('study_year', ['start_year' => 2021]);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'PRIN-266']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'PRIN-366']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'PRIN-466']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'IVT-263']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'IVT-363']);
        $this->assertDatabaseHas('group', ['study_year_id' => 5, 'name' => 'IVT-463']);
        $this->assertDatabaseHas('student_group', ['student_id' => 1, 'group_id' => 1,
            'status_id' => 2]);
        $this->assertDatabaseHas('student_group', ['student_id' => 3, 'group_id' => 3,
            'status_id' => 2]);
        $this->assertDatabaseHas('student_group', ['student_id' => 5, 'group_id' => 5,
            'status_id' => 2]);
        $this->assertDatabaseHas('student_group', ['student_id' => 7, 'group_id' => 7,
            'status_id' => 2]);
    }
}
