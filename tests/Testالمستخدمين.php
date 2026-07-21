<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\UsersController;
use App\Repository\UsersRepository;
use App\Service\UsersService;
use PHPUnit\Framework\MockObject\MockObject;
use PDO;

class Testالمستخدمين extends TestCase
{
    private $usersController;
    private $usersRepository;
    private $usersService;
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->usersRepository = $this->createMock(UsersRepository::class);
        $this->usersService = $this->createMock(UsersService::class);
        $this->usersController = new UsersController($this->usersRepository, $this->usersService);
    }

    public function testGetUsers()
    {
        $this->usersRepository->expects($this->once())
            ->method('getAllUsers')
            ->willReturn([
                ['id' => 1, 'name' => 'User 1'],
                ['id' => 2, 'name' => 'User 2'],
            ]);

        $response = $this->usersController->getUsers();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([
            ['id' => 1, 'name' => 'User 1'],
            ['id' => 2, 'name' => 'User 2'],
        ], json_decode($response->getBody()->getContents(), true));
    }

    public function testCreateUser()
    {
        $this->usersService->expects($this->once())
            ->method('createUser')
            ->with(['name' => 'User 1'])
            ->willReturn(['id' => 1, 'name' => 'User 1']);

        $response = $this->usersController->createUser(['name' => 'User 1']);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals(['id' => 1, 'name' => 'User 1'], json_decode($response->getBody()->getContents(), true));
    }

    public function testUpdateUser()
    {
        $this->usersService->expects($this->once())
            ->method('updateUser')
            ->with(1, ['name' => 'User 1 Updated'])
            ->willReturn(['id' => 1, 'name' => 'User 1 Updated']);

        $response = $this->usersController->updateUser(1, ['name' => 'User 1 Updated']);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['id' => 1, 'name' => 'User 1 Updated'], json_decode($response->getBody()->getContents(), true));
    }

    public function testDeleteUser()
    {
        $this->usersService->expects($this->once())
            ->method('deleteUser')
            ->with(1);

        $response = $this->usersController->deleteUser(1);
        $this->assertEquals(204, $response->getStatusCode());
    }
}



// App\Controller\UsersController.php

namespace App\Controller;

use App\Repository\UsersRepository;
use App\Service\UsersService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController
{
    private $usersRepository;
    private $usersService;

    public function __construct(UsersRepository $usersRepository, UsersService $usersService)
    {
        $this->usersRepository = $usersRepository;
        $this->usersService = $usersService;
    }

    public function getUsers(): Response
    {
        $users = $this->usersRepository->getAllUsers();
        return new JsonResponse($users);
    }

    public function createUser(Request $request): Response
    {
        $user = $this->usersService->createUser($request->request->all());
        return new JsonResponse($user, 201);
    }

    public function updateUser(int $id, Request $request): Response
    {
        $user = $this->usersService->updateUser($id, $request->request->all());
        return new JsonResponse($user);
    }

    public function deleteUser(int $id): Response
    {
        $this->usersService->deleteUser($id);
        return new JsonResponse(null, 204);
    }
}