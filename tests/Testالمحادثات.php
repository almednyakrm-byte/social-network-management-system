<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\ConversationsController;
use App\Repository\ConversationsRepository;
use App\Entity\Conversation;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class Testالمحادثات extends TestCase
{
    private $controller;
    private $repository;
    private $entityManager;
    private $router;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(ConversationsRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->router = $this->createMock(RouterInterface::class);

        $this->controller = new ConversationsController($this->repository, $this->entityManager, $this->router);
    }

    public function testGetConversations()
    {
        $expectedResponse = ['conversations' => []];
        $this->repository->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $response = $this->controller->getConversations();
        $this->assertEquals($expectedResponse, $response->toArray());
    }

    public function testCreateConversation()
    {
        $conversation = new Conversation();
        $conversation->setTitle('Test Conversation');
        $conversation->setMessage('Test Message');

        $expectedResponse = ['conversation' => $conversation];
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($conversation);
        $this->entityManager->expects($this->once())
            ->method('flush')
            ->willReturn(null);

        $request = new Request();
        $request->request->set('title', 'Test Conversation');
        $request->request->set('message', 'Test Message');

        $response = $this->controller->createConversation($request);
        $this->assertEquals($expectedResponse, $response->toArray());
    }

    public function testUpdateConversation()
    {
        $conversation = new Conversation();
        $conversation->setTitle('Test Conversation');
        $conversation->setMessage('Test Message');

        $expectedResponse = ['conversation' => $conversation];
        $this->entityManager->expects($this->once())
            ->method('find')
            ->with(Conversation::class, 1)
            ->willReturn($conversation);
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($conversation);
        $this->entityManager->expects($this->once())
            ->method('flush')
            ->willReturn(null);

        $request = new Request();
        $request->request->set('title', 'Updated Test Conversation');
        $request->request->set('message', 'Updated Test Message');

        $response = $this->controller->updateConversation(1, $request);
        $this->assertEquals($expectedResponse, $response->toArray());
    }

    public function testDeleteConversation()
    {
        $conversation = new Conversation();
        $conversation->setTitle('Test Conversation');
        $conversation->setMessage('Test Message');

        $this->entityManager->expects($this->once())
            ->method('find')
            ->with(Conversation::class, 1)
            ->willReturn($conversation);
        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with($conversation);
        $this->entityManager->expects($this->once())
            ->method('flush')
            ->willReturn(null);

        $response = $this->controller->deleteConversation(1);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}