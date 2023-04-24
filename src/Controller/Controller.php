<?php


namespace App\Controller;


use App\DTOs\CreateBookDto;
use App\Exception\InvalidRequestDataException;
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

    public function __construct(BookService $bookService)
    {
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
    // read book
    // edit book
    // delete book

}