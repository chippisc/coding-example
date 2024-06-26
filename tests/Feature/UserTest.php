<?php

namespace Tests\Feature;

use App\Models\SchulcampusUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_users_returns_ok(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_fetch_users_returns_ok(): void
    {
        $response = $this->get(route('users.query'));

        $response->assertOk();
    }

    public function test_fetch_users_returns_correct_json_without_users(): void
    {
        $response = $this->get(route('users.query'));

        $this->assertEquals([], $response->getData());
    }

    public function test_fetch_users_returns_both_users_with_empty_search(): void
    {
        SchulcampusUser::factory(2)->sequence(fn () => ['given_name' => 'Max', 'family_name' => 'Mustermann'],
            ['given_name' => 'Frank', 'family_name' => 'Schmidt'],
        )->create();
        $response = $this->getJson(route('users.query'));

        $response->assertJsonFragment(['full_name' => 'Frank Schmidt']);
        $response->assertJsonFragment(['full_name' => 'Max Mustermann']);
    }

    public function test_fetch_users_filters_for_search(): void
    {
        SchulcampusUser::factory(2)->sequence(fn () => ['username' => 'max.mustermann', 'given_name' => 'Max', 'family_name' => 'Mustermann'],
            ['username' => 'frank.schmidt', 'given_name' => 'Frank', 'family_name' => 'Schmidt'],
        )->create();
        $response = $this->getJson(route('users.query', ['search' => 'max']), ['search' => 'max']);

        $response->assertJsonMissing(['full_name' => 'Frank Schmidt']);
        $response->assertJsonFragment(['full_name' => 'Max Mustermann']);
    }
}
