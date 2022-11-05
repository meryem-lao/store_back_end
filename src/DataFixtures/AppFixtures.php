<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        //$manager->persist($product);
        for ($p = 0; $p < 3; $p++) {
            $category = new Category;
            $category->setName($faker->randomElement(['sacs', 'bijoux', 'textile']));

            $manager->persist($category);
            
            
            $order = new Order();
            $order->setDateOrder($faker->dateTime());
            $order->setTotal($faker->randomFloat(50, 300));
            $order->setConfirmation($faker->randomElement(['en cours', 'validée']));
            $order->setUser($this->getReference(UserFixtures::USER_REFERENCE));

            $manager->persist($order);

            for ($c = 0; $c <3; $c++) {
                $product = new Product();
                $product->setName($faker->firstName);
                $product->setPrice($faker->randomNumber(2));
                $product->setQuantityStock($faker->numberBetween(0, 100));
                $product->setColor($faker->colorName);
                $product->setGenre($faker->randomElement(['homme', 'femme']));
                $product->setImage($faker->randomElement(["https://cdn.shopify.com/s/files/1/0712/1227/products/honey-triangle-shoulder-bag-portland-leather-15877672239186_x900.jpg?v=1656442337","https://cdn.shopify.com/s/files/1/0712/1227/products/black-triangle-shoulder-bag-portland-leather-15877124784210_x900.jpg?v=1656442337","https://cdn.shopify.com/s/files/1/0712/1227/products/sunflower-triangle-shoulder-bag-portland-leather-15877123801170_x900.jpg?v=1656442337"]));
                $product->setCategory($category);
                $manager->persist($product);
            }

            for ($o=0; $o < 2 ; $o++) { 
                    $orderDetail = new OrderDetail();
                    $orderDetail->setQuantity($faker->numberBetween(1, 50));
                    $orderDetail->setProduct($product);
                    $orderDetail->setIdOrder($order);

                    $manager->persist($orderDetail);
            }
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}