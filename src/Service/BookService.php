<?php

namespace App\Service;

use App\DTOs\CreateBookDto;
use App\DTOs\EditBookDto;
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class BookService
{
    private EntityManagerInterface $entityManager;
    private BookRepository $bookRepository;

    public function __construct(EntityManagerInterface $entityManager, BookRepository $bookRepository)
    {
        $this->entityManager = $entityManager;
        $this->bookRepository = $bookRepository;
    }


    public function createBook(CreateBookDto $dto): Book
    {
        $book = new Book(
            $dto->getAuthor(),
            $dto->getTitle(),
            $dto->getUserRating()
        );
        $this->entityManager->persist($book);
        $this->entityManager->flush();
        return $book;
    }

    public function getBooks(): iterable
    {
        return $this->bookRepository->findAll();
    }

    public function getBook(int $id): Book
    {
        return $this->bookRepository->find($id);
    }

    public function editBook(EditBookDto $dto): Book
    {
        $book = $this->bookRepository->find($dto->getId());
        $book->setAuthor($dto->getAuthor());
        $book->setTitle($dto->getTitle());
        $book->setUserRating($dto->getUserRating());

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }

    public function deleteBook(int $id): String
    {
        $book = $this->bookRepository->find($id);
        $this->entityManager->remove($book);
        $this->entityManager->flush();
        return "book with id {$id} was deleted";
    }

}