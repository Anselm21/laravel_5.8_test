<?php

namespace Tests;
use App\User;
use App\Team;
use App\UserTeam;

class UserTeamTest extends TestCase
{

    public function testAddUserToTeam()
    {
        $user = factory(User::class)->create([
            'name' => 'John',
            'email' => 'doe@mail.com',
            'password' => 'password'
        ]);

        $team = factory(Team::class)->create([
            'title' => 'JohnTeam',
        ]);

        $payload = [
            'user_id' => $user->id,
            'team_id' => $team->id
        ];

        $this->json('POST', '/api/users/add_to_team', $payload)
            ->assertStatus(201)
            ->assertJson(['user_id' => $user->id, 'team_id' => $team->id]);
    }

    public function testRemoveFromTeam()
    {
        $user = factory(User::class)->create([
            'name' => 'John',
            'email' => 'doe@mail.com',
            'password' => 'password'
        ]);

        $team = factory(Team::class)->create([
            'title' => 'JohnTeam',
        ]);

        $payload = [
            'user_id' => $user->id,
            'team_id' => $team->id
        ];

       factory(UserTeam::class)->create($payload);

        $this->json('DELETE', '/api/users/remove_from_team', $payload)
            ->assertStatus(200);
    }
}