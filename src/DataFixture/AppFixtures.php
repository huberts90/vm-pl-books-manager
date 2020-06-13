<?php

namespace App\DataFixture;

use App\Domain\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $book = new Book();
            $book->setName('book '.$i);
            $book->setCategory("non-fiction");
            $manager->persist($book);
        }

        $manager->flush();
    }
}
