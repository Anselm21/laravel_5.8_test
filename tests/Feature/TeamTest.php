<?php

namespace Tests;
use App\User;
use App\Team;
use App\UserTeam;

class TeamTest extends TestCase
{

    public function testTeamCreate()
    {
        $user = factory(User::class)->create([
            'name' => 'John',
            'email' => 'doe@mail.com',
            'password' => 'password'
        ]);

        $invalidOwnerId = 5;

        $payload = [
            'title' => 'Super Team',
            'owner_id' => $user->id
        ];

        $this->json('POST', '/api/teams', $payload)
            ->assertStatus(201)
            ->assertJson(['id' => 1, 'title' => 'Super Team', 'owner_id' => $user->id]);

        $payload['owner_id'] = $invalidOwnerId;

        $this->json('POST', '/api/teams', $payload)
            ->assertStatus(422);
    }

    public function testTeamShow()
    {
        $team = factory(Team::class)->create([
            'title' => 'JohnTeam',
        ]);

        $user = factory(User::class)->create([
            'name' => 'John',
            'email' => 'doe@mail.com',
            'password' => 'password'
        ]);

        factory(UserTeam::class)->create([
            'user_id' => $user->id,
            'team_id' => $team->id
        ]);

        $this->json('GET', '/api/teams/' . $team->id, [])
            ->assertStatus(200)
            ->assertJson([['id' => 1, 'title' => 'JohnTeam', 'owner_id' => null, 'users'=>[['id' => 1, 'name' => 'John', 'email' => 'doe@mail.com']]]]);
    }

    public function testTeamUpdate()
    {
        $team = factory(Team::class)->create([
            'title' => 'JohnTeam',
        ]);


        $payload = [
            'title' => 'Super Team',
        ];

        $this->json('PUT', '/api/teams/'. $team->id, $payload)
            ->assertStatus(200)
            ->assertJson(['id' => 1, 'title' => 'Super Team', 'owner_id' => null]);

    }

    public function testTeamIndex()
    {
        $user = factory(User::class)->create([
            'name' => 'John',
            'email' => 'doe@mail.com',
            'password' => 'password'
        ]);

        factory(Team::class)->create([
            'title' => 'JohnTeam',
            'owner_id' => $user->id
        ]);

        factory(Team::class)->create([
            'title' => 'No one\'s Team',
        ]);


        $this->json('GET', '/api/teams/', [])
            ->assertStatus(200)
            ->assertJson([
                [ 'title' => 'JohnTeam', 'owner_id' => $user->id ],
                [ 'title' => 'No one\'s Team', 'owner_id' => null ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'title', 'owner_id', 'created_at', 'updated_at']
            ]);
    }

    public function testTeamDelete()
    {
        $team = factory(Team::class)->create([
            'title' => 'JohnTeam',
        ]);


        $this->json('DELETE', '/api/teams/' . $team->id, [])
            ->assertStatus(200);

        $this->json('GET', '/api/teams/', [])
            ->assertStatus(200)
            ->assertJson([]);
    }
}