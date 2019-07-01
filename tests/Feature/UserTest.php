<?php

namespace Tests;
use App\User;
use App\Team;
use App\UserTeam;

class UserTest extends TestCase
{

    public function testUserCreate()
    {
        $payload = [
            'name' => 'John',
            'email' => 'doe@mail.com',
            'password' => 'password'
        ];

        $this->json('POST', '/api/users', $payload)
            ->assertStatus(201)
            ->assertJson(['id' => 1, 'name' => 'John', 'email' => 'doe@mail.com']);

        $payload = ['email' => 'incorrectmail.com'];

        $this->json('POST', '/api/users', $payload)
            ->assertStatus(422);
    }

    public function testUserShow()
    {
        $teamOne = factory(Team::class)->create([
            'title' => 'JohnTeam',
        ]);

        $teamTwo = factory(Team::class)->create([
            'title' => 'SuperTeam',
        ]);

        $user = factory(User::class)->create([
            'name' => 'John',
            'email' => 'doe@mail.com',
            'password' => 'password'
        ]);

        factory(UserTeam::class)->create([
            'user_id' => $user->id,
            'team_id' => $teamOne->id
        ]);

        factory(UserTeam::class)->create([
            'user_id' => $user->id,
            'team_id' => $teamTwo->id
        ]);

        $this->json('GET', '/api/users/'. $user->id, [])
            ->assertStatus(200)
            ->assertJson([['id' => 1, 'name' => 'John', 'email' => 'doe@mail.com', 'teams' => [['title' => 'JohnTeam'], ['title' => 'SuperTeam']]]])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at', 'teams']
            ]);;

        $payload = ['email' => 'incorrectmail.com'];

        $this->json('POST', '/api/users', $payload)
            ->assertStatus(422);
    }

    public function testUserUpdate()
    {
        $user = factory(User::class)->create([
            'name' => 'John',
            'email' => 'doe@mail.com',
            'password' => 'password'
        ]);

        $payload = [
            'name' => 'New Name',
            'email' => 'newmail@mail.com',
        ];

       $this->json('PUT', '/api/users/' . $user->id, $payload)
            ->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'name' => 'New Name',
                'email' => 'newmail@mail.com'
            ]);
    }

    public function testUserIndex()
    {
        factory(User::class)->create([
            'name' => 'John',
            'email' => 'doe@mail.com',
            'password' => 'password'
        ]);

        factory(User::class)->create([
            'name' => 'Alex',
            'email' => 'at@mail.com',
            'password' => 'password1'
        ]);


        $this->json('GET', '/api/users/', [])
            ->assertStatus(200)
            ->assertJson([
                [ 'name' => 'John', 'email' => 'doe@mail.com' ],
                [ 'name' => 'Alex', 'email' => 'at@mail.com' ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at',]
            ]);
    }

    public function testUserDelete()
    {
        $user = factory(User::class)->create([
            'name' => 'John',
            'email' => 'doe@mail.com',
            'password' => 'password'
        ]);


        $this->json('DELETE', '/api/users/delete/' . $user->id, [])
            ->assertStatus(200);

        $this->json('GET', '/api/users/', [])
            ->assertStatus(200)
            ->assertJson([]);
    }
}