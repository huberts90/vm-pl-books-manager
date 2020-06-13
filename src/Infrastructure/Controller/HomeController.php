<?php

namespace App\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class BookController
 *
 * @package App\Infrastructure\Controller
 */
class HomeController extends AbstractController
{
    private $serializer;
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $this->validator = $validator;
    }

    /**
     * @Route("/", name="get_books", methods={"GET"})
     *
     * @param BookRepository $bookRepository
     * @return Response
     */
    public function getBooks(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();

        return $this->render('home/index.html.twig', [
            'books' => $books,
        ]);
    }
}
