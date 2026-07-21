<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\المتابعينController;
use App\Repository\المتابعينRepository;
use App\Entity\المتابعين;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use PHPUnit\Framework\MockObject\MockObject;

class Testالمتابعين extends TestCase
{
    private $controller;
    private $repository;
    private $entityManager;

    public function setUp(): void
    {
        $this->repository = $this->createMock(المتابعينRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->controller = new المتابعينController($this->repository, $this->entityManager);
    }

    public function testGetAll(): void
    {
        $expectedResponse = ['data' => []];
        $this->repository->expects($this->once())
            ->method('findAll')
            ->willReturn($expectedResponse['data']);

        $response = $this->controller->getAll();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getContent(), true));
    }

    public function testGetOne(): void
    {
        $expectedResponse = ['data' => []];
        $this->repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($expectedResponse['data']);

        $response = $this->controller->getOne(1);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getContent(), true));
    }

    public function testGetOneNotFound(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $this->repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $this->controller->getOne(1);
    }

    public function testCreate(): void
    {
        $expectedResponse = ['data' => []];
        $this->repository->expects($this->once())
            ->method('save')
            ->with($this->anything())
            ->willReturn($expectedResponse['data']);

        $request = new Request([], [], ['json' => ['name' => 'Test']]);
        $response = $this->controller->create($request);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getContent(), true));
    }

    public function testUpdate(): void
    {
        $expectedResponse = ['data' => []];
        $this->repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($expectedResponse['data']);

        $this->repository->expects($this->once())
            ->method('save')
            ->with($this->anything())
            ->willReturn($expectedResponse['data']);

        $request = new Request([], [], ['json' => ['name' => 'Test']]);
        $response = $this->controller->update(1, $request);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getContent(), true));
    }

    public function testUpdateNotFound(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $this->repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $request = new Request([], [], ['json' => ['name' => 'Test']]);
        $this->controller->update(1, $request);
    }

    public function testDelete(): void
    {
        $expectedResponse = ['data' => []];
        $this->repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($expectedResponse['data']);

        $this->repository->expects($this->once())
            ->method('remove')
            ->with($this->anything())
            ->willReturn($expectedResponse['data']);

        $response = $this->controller->delete(1);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getContent(), true));
    }

    public function testDeleteNotFound(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $this->repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $this->controller->delete(1);
    }
}