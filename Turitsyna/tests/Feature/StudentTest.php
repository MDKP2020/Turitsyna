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

        $response->assertJson([]);
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
}
