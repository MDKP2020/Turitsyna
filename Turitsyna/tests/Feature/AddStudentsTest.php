<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddStudentsTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Тест на добавление студента без данных о студенте
     *
     * @return void
     */
    public function testEmptyRequest()
    {
        $response = $this->post('/enrollment-api/addStudent', [], []);

        $response->assertStatus(400);
        $response->assertJson(['Not enough information']);
    }

    /**
     * Тест на добавление студента
     *
     * @return void
     */
    public function testCorrectStudent()
    {
        $response = $this->post('/enrollment-api/addStudent', [
            'name' => 'Виталий',
            'surname' => 'Витальев',
            'patronomyc' => 'Витальевич',
            'group_id' => 1
        ], []);

        $response->assertStatus(201);
        $this->assertDatabaseHas('student', ['name' => 'Виталий',
            'surname' => 'Витальев',
            'patronomyc' => 'Витальевич']);

    }

    /**
     * Тест на добавление студента повторно
     *
     * @return void
     */
    public function testAddingToIdenticalStudents()
    {
        $response = $this->post('/enrollment-api/addStudent', [
            'name' => 'Иван',
            'surname' => 'Иванов',
            'patronomyc' => 'Иванович',
            'group_id' => 1
        ], []);
        $response->assertStatus(400);
        $response->assertJson(['Student is studying']);
    }

    /**
     * Тест на удаление студента
     *
     * @return void
     */
    public function testDeleteStudent()
    {

        $response = $this->delete('/enrollment-api/delStudFromGroup/14/1', [], []);

        $this->assertDatabaseMissing('student_group', [
            "student_id" => 14,
            'group_id' => 1
        ],
        );
        /*$response->assertStatus(400);
        $response->assertJson(['Student is studying']);*/
    }

    /**
     * Тест на удаление несуществующего студента
     *
     * @return void
     */
    public function testDeleteUnknownStudent()
    {

        $response = $this->delete('/enrollment-api/delStudFromGroup/15/1', [], []);

        $response->assertStatus(500);
    }

    /**
     * Тест на удаление студента по нулевым данным
     *
     * @return void
     */
    public function testDeleteStudentWithoutData()
    {
        $response = $this->delete('/enrollment-api/delStudFromGroup/null/null', [], []);

        $response->assertStatus(500);
    }

    /**
     * Тест на изменение группы студента
     *
     * @return void
     */
    public function testChangeStudentGroup()
    {
        $response = $this->post('/enrollment-api/changeStudGroup/14/1/2',
            [], []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('student_group', [
            "student_id" => 14,
            'group_id' => 2
        ]);
    }

    /**
     * Тест на изменение группы несуществующего студента
     *
     * @return void
     */
    public function testChangeUnknownStudentGroup()
    {
        $response = $this->post('/enrollment-api/changeStudGroup/15/1/2',
            [], []);

        $response->assertStatus(500);
    }

    /**
     * Тест на изменение группы студента на несуществующую
     *
     * @return void
     */
    public function testChangeStudentGroupToUnknownGroup()
    {
        $response = $this->post('/enrollment-api/changeStudGroup/14/1/10',
            [], []);

        $response->assertStatus(500);
    }
}
