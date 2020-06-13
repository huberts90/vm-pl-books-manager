<?php

namespace App\Infrastructure\Api\Controller;

use App\Domain\Book;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/books", name="book_")
 */
class BookController extends AbstractController
{
    private $serializer;
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $this->validator = $validator;
    }

    /**
     * @Route("/", name="add_book", methods={"POST"})
     *
     * @param Request $request
     * @param BookRepository $bookRepository
     * @return Response
     */
    public function addBook(Request $request, BookRepository $bookRepository)
    {
        $data = json_decode($request->getContent(), true);

        $book = new Book();
        $book->setName($data['name'] ?? '');
        $book->setCategory($data['category'] ?? '');

        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            $errorsString = (string)$errors;

            return new Response($errorsString, Response::HTTP_BAD_REQUEST);
        }

        $book = $bookRepository->create($book);

        return new Response($this->serializer->serialize($book, 'json'), Response::HTTP_CREATED);
    }

    /**
     * @Route("/", name="get_books", methods={"GET","HEAD"})
     *
     * @param BookRepository $bookRepository
     * @return Response
     */
    public function getBooks(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();

        return new Response($this->serializer->serialize($books, 'json'), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}/", name="update_book", methods={"PUT"})
     *
     * @param int $id
     * @param Request $request
     * @param BookRepository $bookRepository
     * @return JsonResponse | Response
     */
    public function updateBook(int $id, Request $request, BookRepository $bookRepository)
    {
        $book = $bookRepository->findOneById($id);
        if (!$book) {
            return $this->createNotFoundResponse($id);
        }

        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $book->setName($data['name']);
        empty($data['category']) ? true : $book->setCategory($data['category']);
        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            $errorsString = (string)$errors;

            return new Response($errorsString, Response::HTTP_BAD_REQUEST);
        }

        $book = $bookRepository->update($book);

        return new Response($this->serializer->serialize($book, 'json'), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}/", name="get_book", methods={"GET"})
     *
     * @param int $id
     * @param BookRepository $bookRepository
     * @return Response
     */
    public function getBook(int $id, BookRepository $bookRepository)
    {
        $book = $bookRepository->findOneById($id);
        if (!$book) {
            return $this->createNotFoundResponse($id);
        }

        return new Response($this->serializer->serialize($book, 'json'), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}/", name="delete_book", methods={"DELETE"})
     *
     * @param string $id
     * @param BookRepository $bookRepository
     * @return Response
     */
    public function deleteBook(string $id, BookRepository $bookRepository)
    {
        $book = $bookRepository->findOneById($id);
        if (!$book) {
            return $this->createNotFoundResponse($id);
        }

        $bookRepository->delete($book);

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    private function createNotFoundResponse(int $id)
    {
        return new Response('Book ' . $id . ' not found', Response::HTTP_NOT_FOUND);
    }
}
