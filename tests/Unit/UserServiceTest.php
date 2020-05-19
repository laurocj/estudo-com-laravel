<?php

namespace Tests\Unit;

use App\Repository\UserRepository;
use App\Services\UserService;
use Illuminate\Support\Facades\App;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    protected $userMock;

    protected function setUp() : void
    {
        parent::setUp();

        $this->mock = Mockery::mock(UserRepository::class);
    }

    /** @test */
    public function it_fetch_an_user()
    {
        $this->mock->shouldReceive('find')->with(1)->andReturn('foo');

        $service = new UserService($this->mock);

        $this->assertEquals('foo', $service->find(1));
    }

    protected function tearDown() : void
    {
        Mockery::close();
    }
}
