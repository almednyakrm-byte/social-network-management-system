<?php

namespace App\Tests\Unit\Auth;

use App\Auth\AuthService;
use App\Auth\AuthRepository;
use App\Auth\User;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\MockBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\UnitOfWork;

class TestAuth extends TestCase
{
    private $authService;
    private $authRepository;
    private $entityManager;
    private $unitOfWork;

    protected function setUp(): void
    {
        $this->authRepository = $this->createMock(AuthRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->unitOfWork = $this->createMock(UnitOfWork::class);
        $this->authService = new AuthService($this->authRepository, $this->entityManager);
    }

    public function testLoginSuccess()
    {
        $username = 'testUser';
        $password = 'testPassword';

        $this->authRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->willReturn(new User($username, $password));

        $this->authService->login($username, $password);

        $this->assertTrue($this->authService->isLoggedIn());
    }

    public function testLoginFailure()
    {
        $username = 'testUser';
        $password = 'testPassword';

        $this->authRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->willReturn(null);

        $this->authService->login($username, $password);

        $this->assertFalse($this->authService->isLoggedIn());
    }

    public function testRegisterSuccess()
    {
        $username = 'testUser';
        $password = 'testPassword';

        $this->authRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->willReturn(null);

        $this->authRepository->expects($this->once())
            ->method('saveUser')
            ->with(new User($username, $password));

        $this->authService->register($username, $password);

        $this->assertTrue($this->authService->isLoggedIn());
    }

    public function testRegisterFailure()
    {
        $username = 'testUser';
        $password = 'testPassword';

        $this->authRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->willReturn(new User($username, $password));

        $this->authService->register($username, $password);

        $this->assertFalse($this->authService->isLoggedIn());
    }
}


Note: This is a basic example and does not cover all edge cases. You may need to adjust it according to your specific requirements.