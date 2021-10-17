<?php

use App\Models\Task;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TodoTest extends \PHPUnit\Framework\TestCase
{
    protected $container;
    protected $http;
    protected $user;

    protected function setUp():void
    {
        $this->container = require __DIR__.'/../bootstrap/app.php';
        $hash = $this->container->make('hash');
        $this->http = $this->container->make('http');
        $this->http->withHeaders([
            'Accept' => 'application/json'
        ]);
        Task::truncate();
        User::truncate();

        $this->user = User::create([
            'email' => 'twocngdagz@gmail.com',
            'name' => 'Mederic Roy Beldia',
            'password' => $hash->make('password')
        ]);
    }

    protected function login()
    {
        return $this->http->post('http://todo.test/api/login', [
            'email' => $this->user->email,
            'password' => 'password'
        ]);
    }

    /** @test */
    public function it_should_see_unauthorized_when_user_is_not_logged_in()
    {
        $response = $this->http->get('http://todo.test/api/todos');
        $this->assertStringContainsString('Unauthorized', $response->getBody()->getContents());
    }

    /** @test */
    public function it_should_see_email_of_authenticated_user()
    {
        $response = $this->login();
        $this->assertStringContainsString($this->user->email, (string) $response->getBody());
    }


    public function it_should_list_all_todos_of_user()
    {
        $response = $this->login();
        Task::create([
            'description' => 'Do groceries',
            'is_done' => 0,
            'user_id' => $this->user->id
        ]);
        $response = $this->http->get('http://todo.test/api/todos');
        dd((string) $response->getBody());
        $todos = json_decode($response->getBody()->getContents());
        dd($todos);
    }
}
