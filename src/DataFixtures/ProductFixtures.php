<?php

namespace App\DataFixtures;

use App\DataFixtures\CategoryFixtures;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $category1 = $this->getReference('category_1', Category::class);
        $category2 = $this->getReference('category_2', Category::class);

        $product1 = new Product;

        $product1->setName("Product One");
        $product1->setDescription("This is the first product");
        $product1->setSize(100);
        $product1->addCategory($category1)
                 ->addCategory($category2);

        $manager->persist($product1);

        $product2 = new Product;

        $product2->setName("Product Two");
        $product2->setDescription("This is the second product");
        $product2->setSize(200);
        $product2->setIsAvailable(false);
        $product2->addCategory($category1);

        $manager->persist($product2);

        $product3 = new Product;

        $product3->setName("Product Three");
        $product3->setDescription("This is the third product");
        $product3->setSize(300);

        $manager->persist($product3);

        $manager->flush();
    }
}
