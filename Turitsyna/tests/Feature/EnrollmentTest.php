<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnrollmentTest extends TestCase
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
     * Тест на добавление студента с частичными данными о студенте
     *
     * @return void
     */
    public function testPartialStudentData()
    {
        $response = $this->post('/enrollment-api/addStudent',
            ['name' => 'Ivan',
            'surname' => 'Ivanov'],
            []);

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
            'name' => 'Ivan',
            'surname' => 'Ivanov',
            'patronomyc' => 'Ivanovich',
            'group_id' => 2
        ], []);

        $response->assertStatus(201);
        $this->assertDatabaseHas('student', ['name' => 'Ivan',
            'surname' => 'Ivanov',
            'patronomyc' => 'Ivanovich']);

    }

    /**
     * Тест на добавление студента с данными json в неподходящем формате
     *
     * @return void
     */
    public function testAddStudentWithInvalidData()
    {
        $response = $this->post('/enrollment-api/addStudent', [
            'name' => 54,
            'surname' => 29,
            'patronomyc' => 89,
            'group_id' => "first"
        ], []);

        $response->assertStatus(400);
        $response->assertJson(['Invalid request params type']);
    }

    /**
     * Тест на добавление студента в несуществующую группу
     *
     * @return void
     */
    public function testCorrectStudentIntoUnknownGroup()
    {
        $response = $this->post('/enrollment-api/addStudent', [
            'name' => 'Ivan',
            'surname' => 'Ivanov',
            'patronomyc' => 'Ivanovich',
            'group_id' => 10
        ], []);

        $response->assertStatus(404);
        $response->assertJson(['Not Found Group']);

    }

    /**
     * Тест на добавление уже существующего студента несуществующую группу
     *
     * @return void
     */
    public function testAddingOfExistingStudentToUnknownGroup()
    {
        $response = $this->post('/enrollment-api/addStudent', [
            'name' => 'Иван',
            'surname' => 'Иванов',
            'patronomyc' => 'Иванович',
            'group_id' => 10
        ], []);
        $response->assertStatus(400);
        $response->assertJson(['Student is studying']);
    }

    /**
     * Тест на добавление студента повторно в ту же группу
     *
     * @return void
     */
    public function testAddingOfIdenticalStudent()
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
     * Тест на добавление студента повторно в другую группу
     *
     * @return void
     */
    public function testAddingOfIdenticalStudentToAnotherGroup()
    {
        $response = $this->post('/enrollment-api/addStudent', [
            'name' => 'Иван',
            'surname' => 'Иванов',
            'patronomyc' => 'Иванович',
            'group_id' => 2
        ], []);
        $response->assertStatus(400);
        $response->assertJson(['Student is studying']);
    }

    /**
     * Тест на удаление студента из существующей группы
     *
     * @return void
     */
    public function testDeleteStudent()
    {

        $response = $this->delete('/enrollment-api/delStudFromGroup/1/1', [], []);

        $this->assertDatabaseMissing('student_group', [
            "student_id" => 1,
            'group_id' => 1
        ],
        );
    }

    /**
     * Тест на удаление студента из несуществующей группы
     *
     * @return void
     */
    public function testDeleteStudentFromUnknownGroup()
    {

        $response = $this->delete('/enrollment-api/delStudFromGroup/1/10', [], []);

        $response->assertStatus(400);
        $response->assertJson(['There is no group with such id']);
    }

    /**
     * Тест на удаление несуществующего студента из существующей группы
     *
     * @return void
     */
    public function testDeleteUnknownStudent()
    {

        $response = $this->delete('/enrollment-api/delStudFromGroup/33/1', [], []);

        $response->assertStatus(400);
        $response->assertJson(['There is no student with such id']);
    }

    /**
     * Тест на удаление несуществующего студента из несуществующей группы
     *
     * @return void
     */
    public function testDeleteUnknownStudentFromUnknownGroup()
    {

        $response = $this->delete('/enrollment-api/delStudFromGroup/33/32', [], []);

        $response->assertStatus(400);
        $response->assertJson(['There is no student with such id']);
    }

    /**
     * Тест на удаление студента по некорректным данным
     *
     * @return void
     */
    public function testDeleteStudentWithoutData()
    {
        $response = $this->delete('/enrollment-api/delStudFromGroup/null/null', [], []);

        $response->assertStatus(404);
        $response->assertJson(['Invalid student id']);
    }

    /**
     * Тест на изменение группы студента
     *
     * @return void
     */
    public function testChangeStudentGroup()
    {
        $response = $this->post('/enrollment-api/changeStudGroup/1/1/2',
            [], []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('student_group', [
            "student_id" => 1,
            'group_id' => 2
        ]);
    }

    /**
     * Тест на изменение группы студента по некорректным параметрам
     *
     * @return void
     */
    public function testChangeStudentGroupInvalidRequestData()
    {
        $response = $this->post('/enrollment-api/changeStudGroup/null/null/null',
            [], []);

        $response->assertStatus(404);
        $response->assertJson(['Invalid request parameters']);
    }

    /**
     * Тест на изменение группы несуществующего студента
     *
     * @return void
     */
    public function testChangeGroupOfUnknownStudent()
    {
        $response = $this->post('/enrollment-api/changeStudGroup/15/1/2',
            [], []);

        $response->assertStatus(400);
        $response->assertJson(['There is no student with such id']);
    }

    /**
     * Изменить несуществующую группу у студента на существующую
     *
     * @return void
     */
    public function testChangeUnknownStudentGroupToExistingGroup()
    {
        $response = $this->post('/enrollment-api/changeStudGroup/1/10/1',
            [], []);

        $response->assertStatus(400);
        $response->assertJson(['There is no previous group with such id']);
    }

    /**
     * Изменить группу у студента на точно такую же
     *
     * @return void
     */
    public function testChangeToTheSameGroup()
    {
        $response = $this->post('/enrollment-api/changeStudGroup/1/1/1',
            [], []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('student_group',
            ['id' => 1, 'student_id' => 1, 'group_id' => 1]);
        $this->assertDatabaseMissing('student_group',
            ['id' => 2, 'student_id' => 1, 'group_id' => 1]);
        $this->assertDatabaseMissing('student_group',
            ['id' => 3, 'student_id' => 1, 'group_id' => 1]);
        $this->assertDatabaseMissing('student_group',
            ['id' => 4, 'student_id' => 1, 'group_id' => 1]);
        $this->assertDatabaseMissing('student_group',
            ['id' => 5, 'student_id' => 1, 'group_id' => 1]);
    }

    /**
     * Тест на изменение группы студента на несуществующую
     *
     * @return void
     */
    public function testChangeStudentGroupToUnknownGroup()
    {
        $response = $this->post('/enrollment-api/changeStudGroup/1/1/10',
            [], []);

        $response->assertStatus(400);
        $response->assertJson(['There is no new group with such id']);
    }

    /**
     * Изменить несуществующую группу у несуществующего студента на другую несуществующую группу
     *
     * @return void
     */
    public function testChangeUnknownGroupOfUnknownStudentToUnknownGroup()
    {
        $response = $this->post('/enrollment-api/changeStudGroup/12/21/9',
            [], []);

        $response->assertStatus(400);
        $response->assertJson(['There is no student with such id']);
    }
}
