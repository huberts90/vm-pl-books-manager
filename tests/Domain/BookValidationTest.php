<?php

namespace Tests\Domain;

use App\Domain\Book;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class BookValidationTest extends TestCase
{

    public function testValidationOfName()
    {
        $book = new Book();
        $book->setName("a");
        $book->setCategory("non-fiction");

        // assert that your calculator added the numbers correctly!
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $errors = $validator->validate($book);

        $this->assertCount(1, $errors);
        $this->assertRegExp("/name/", (string)$errors);
    }

    public function testValidationOfCategory()
    {
        $book = new Book();
        $book->setName("lorem");
        $book->setCategory("ipsum");

        // assert that your calculator added the numbers correctly!
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $errors = $validator->validate($book);

        $this->assertCount(1, $errors);
        $this->assertRegExp("/category/", (string)$errors);
    }
}
