<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use Faker\Factory;
use App\Entity\Products;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;
   


    public function __construct(){
        $this->faker = factory::create(('fr_FR'));
        
    }
    public function load(ObjectManager $manager): void{
    // Product
    $products = [];
    for ($i = 0; $i<=50;$i++)
        {
            $product = new Products();
            $product->setName($this->faker->word());
            $product->setPrice(mt_rand(0,100));
            $product->setDescription('Lorem Ipsum');
            $product->setPicture('Lorem Ipsum');
            $products[] = $product;
            $manager->persist($product);
        }

        // Cart
        for ($j = 0; $j<=20;$j++){
            $cart = new Cart();
        }

        for ($k = 0; $k<= mt_rand(1,10);$k++){
            $cart->addProductadded($products[mt_rand(0, count($products)- 1)]);
            $manager->persist($cart);


        }
        $manager->flush();

        //User
        for ($i = 0; $i<=20;$i++)
        {
            $user = new User();
            $user->setFirstName($this->faker->firstName());
            $user->setLastName($this->faker->name());
            $user->setAdress($this->faker->word());
            $user->setLogin($this->faker->name());
            $user->setEmail($this->faker->email());
            $user->setRoles(['ROLE USER']);
            $user->setPlainPassword('password');


            $user->setAdress($this->faker->address());
            
                $manager->persist($user);
                
        }
        
    }
}