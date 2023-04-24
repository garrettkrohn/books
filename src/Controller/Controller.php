<?php


namespace App\Controller;


use App\DTOs\CreateBookDto;
use App\DTOs\EditBookDto;
use App\Exception\InvalidRequestDataException;
use App\Serialization\SerializationService;
use App\Service\BookService;
use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends ApiController
{

    private BookService $bookService;
    private SerializationService $serializationService;

    public function __construct(BookService $bookService, SerializationService $serializationService)
    {
        parent::__construct($serializationService);
        $this->bookService = $bookService;
    }

    #[Route('/')]
    #[Route('/health')]
    public function health(): Response {
        return new Response();
    }

    #[Route('/log/{name}')]
    public function log(string $name, LoggerInterface $logger): Response {
        // See these in /var/log/ of your project root
        $logger->info("Hello, $name");
        return $this->json([
            'success' => true,
            'name' => $name
        ]);
    }

    // create book
    /**
     * @throws JsonException
     * @throws InvalidRequestDataException
     */
    #[Route('api/books', methods: ('POST'))]
    public function createBook(Request $request): Response
    {
        /** @var CreateBookDto $dto */
        $dto = $this->getValidatedDto($request, CreateBookDto::class);
        return $this->json($this->bookService->createBook($dto));
    }

    // read books
    #[Route('api/books', methods: ('GET'))]
    public function getBooks(Request $request): Response
    {
        return $this->json($this->bookService->getBooks());
    }

    // read book
    #[Route('api/books/{id}', methods: ('GET'))]
    public function getBook(int $id): Response
    {
        return $this->json($this->bookService->getBook($id));
    }

    // edit book
    /**
     * @throws JsonException
     * @throws InvalidRequestDataException
     */
    #[Route('api/books', methods: ('PATCH'))]
    public function editBook(Request $request): Response
    {
        /** @var EditBookDto $dto */
        $dto = $this->getValidatedDto($request, EditBookDto::class);
        return $this->json($this->bookService->editBook($dto));
    }

    // delete book
    #[Route('api/books/{id}', methods: ('DELETE'))]
    public function deleteBook(int $id): Response
    {
        return $this->json($this->bookService->deleteBook($id));
    }


}