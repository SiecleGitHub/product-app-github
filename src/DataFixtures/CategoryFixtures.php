<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category1 = new Category;
        $category1->setName('Cat One');

        $category2 = new Category;
        $category2->setName('Cat Two');

        $category3 = new Category;
        $category3->setName('Cat Three');

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);

        $this->addReference('category_1', $category1);
        $this->addReference('category_2', $category2);
        $this->addReference('category_3', $category3);

        $manager->flush();
    }
}
