<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Создаем обычную группу
     *
     * @return void
     */
    public function testCreateGroup()
    {
        $response = $this->post('/group-api/create', [
            'name' => 'FIZ-169',
            'lvl_education_id' => 1,
            'study_year_id' => 4,
            'course' => 1,
            'direction_id' => 4
        ], []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('group', [
            'name' => 'FIZ-169',
            'lvl_education_id' => 1,
            'study_year_id' => 4,
            'course' => 1,
            'direction_id' => 4
        ]);
    }

    /**
     * Создаем группу с именем, как у уже созданной
     *
     * @return void
     */
    public function testCreateGroupLikeOtherGroup()
    {
        $response = $this->post('/student-api/getGroupStudentsList', [
            'name' => 'PRIN-166',
            'lvl_education_id' => 1,
            'study_year_id' => 4,
            'course' => 1,
            'direction_id' => 1
        ], []);

        $response->assertStatus(400);
        $response->assertJson(['Group already exists']);
    }

    /**
     * Создаем группу по неполным данным
     *
     * @return void
     */
    public function testCreateGroupPartialData()
    {
        $response = $this->post('/student-api/getGroupStudentsList', [
            'name' => 'PRIN-166',
            'lvl_education_id' => 1,
            'direction_id' => 1
        ], []);

        $response->assertStatus(400);
        $response->assertJson(['Not enough information']);
    }

    /**
     * Создаем группу по некорректным данным данным
     *
     * @return void
     */
    public function testCreateGroupInvalidData()
    {
        $response = $this->post('/student-api/getGroupStudentsList', [
            'name' => 166,
            'lvl_education_id' => 'first',
            'study_year_id' => 'fourth',
            'course' => 'one',
            'direction_id' => 1
        ], []);

        $response->assertStatus(400);
        $response->assertJson(['Invalid request params']);
    }

    /**
     * Получаем группу со студентами
     *
     * @return void
     */
    public function testGetGroup()
    {
        $response = $this->get('/group-api/getGroup/PRIN-166/4');

        $response->assertStatus(200);
        $response->assertJson([
            'id' => 1,
            'name' => 'PRIN-166',
            'lvl_education_id' => 1,
            'study_year_id' => 4,
            'course' => 1,
            'direction_id' => 1
        ]);
    }

    /**
     * Получаем несуществующую группу
     *
     * @return void
     */
    public function testGetUnknownGroup()
    {
        $response = $this->get('/group-api/getGroup/PRIN-169/4');

        $response->assertStatus(404);
        $response->assertJson(['Group Not Found']);
    }

    /**
     * Получаем группу по некорректному id
     *
     * @return void
     */
    public function testGetGroupUnknownStudyYear()
    {
        $response = $this->get('/group-api/getGroup/PRIN-166/52');

        $response->assertStatus(404);
        $response->assertJson(['Group Not Found']);
    }

    /**
     * Получаем группу по некорректному id
     *
     * @return void
     */
    public function testGetGroupInvalidYearId()
    {
        $response = $this->get('/group-api/getGroup/PRIN-166/first');

        $response->assertStatus(404);
        $response->assertJson(['Invalid study year id']);
    }

    /**
     * Получаем направление
     *
     * @return void
     */
    public function testGetDirection()
    {
        $response = $this->get('/group-api/getDirection/PRIN');

        $response->assertStatus(200);
        $response->assertJson([
            'id' => 1,
            'name' => 'PRIN'
        ]);
    }

    /**
     * Получаем несуществующее направление
     *
     * @return void
     */
    public function testGetUnknownDirection()
    {
        $response = $this->get('/group-api/getDirection/PRINT');

        $response->assertJson(['Direction not found']);
        $response->assertStatus(404);
    }

    /**
     * Получаем учебный год
     *
     * @return void
     */
    public function testGetStudyYear()
    {
        $response = $this->get('/group-api/getStudyYear/2017');

        $response->assertStatus(200);
        $response->assertJson([
            'id' => 1,
            'start_year' => 2017
        ]);
    }

    /**
     * Получаем несуществующий учебный год
     *
     * @return void
     */
    public function testGetUnknownStudyYear()
    {
        $response = $this->get('/group-api/getStudyYear/2');

        $response->assertStatus(404);
        $response->assertJson(['Study year not found']);
    }

    /**
     * Получаем учебный год по некорректному ID
     *
     * @return void
     */
    public function testGetStudyYearInvalidId()
    {
        $response = $this->get('/group-api/getStudyYear/first');

        $response->assertStatus(404);
        $response->assertJson(['Invalid study year']);
    }

    /**
     * Получаем уровень обучения
     *
     * @return void
     */
    public function testGetLevelEducation()
    {
        $response = $this->get('/group-api/getLeveEduc/Бакалавриат');

        $response->assertStatus(200);
        $response->assertJson([
            'id' => 1,
            'name' => 'Бакалавриат',
            'period_of_study' => 4
        ]);
    }

    /**
     * Получаем несуществующий уровень обучения
     *
     * @return void
     */
    public function testGetUnknownLevelEducation()
    {
        $response = $this->get('/group-api/getDirection/Бакалавр');

        $response->assertJson(['Education level not found']);
        $response->assertStatus(404);
    }


    /**
     * Меняем название группы
     *
     * @return void
     */
    public function testChangeGroupName()
    {
        $response = $this->post('/group-api/changeGroupName/1/PrIn-166');

        $response->assertStatus(200);
        $this->assertDatabaseHas('group', [
            'id' => 1,
            'name' => 'PrIn-166'
        ]);
    }

    /**
     * Меняем название несуществующей группы
     *
     * @return void
     */
    public function testChangeUnknownGroupName()
    {
        $response = $this->post('/group-api/changeGroupName/52/PrIn-166');

        $response->assertStatus(404);
        $response->assertJson(["Group not found"]);
    }

    /**
     * Меняем название группы на такое же
     *
     * @return void
     */
    public function testChangeGroupNameEqualCurrentGroupName()
    {
        $response = $this->post('/group-api/changeGroupName/1/PRIN-166');

        $response->assertStatus(400);
        $response->assertJson(["Group with this name is already exists"]);
    }

    /**
     * Меняем название группы на такое же как у другой группы
     *
     * @return void
     */
    public function testChangeGroupNameEqualOtherGroupName()
    {
        $response = $this->post('/group-api/changeGroupName/1/PRIN-266');

        $response->assertStatus(400);
        $response->assertJson(["Group with this name is already exists"]);
    }

    /**
     * Меняем название группы на такое же как у другой группы
     *
     * @return void
     */
    public function testChangeGroupNameInvalidGroupId()
    {
        $response = $this->post('/group-api/changeGroupName/first/PRIN-266');

        $response->assertStatus(404);
        $response->assertJson(["InvalidGroupId"]);
    }
}
