<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName('Suco');
        $product->setDescription('Um Pequeno Suco de Laranja');
        $product->setSize(200);
        
        $manager->persist($product);

        $product = new Product();
        $product->setName('Moto Honda CG160');
        $product->setDescription('');
        $product->setSize(250);

        $manager->persist($product);

        $product = new Product();
        $product->setName('Moto Honda 500F');
        $product->setDescription('Moto honda 2024, 471 cc');
        $product->setSize(450);

        $manager->persist($product);

        $manager->flush();
    }
}
