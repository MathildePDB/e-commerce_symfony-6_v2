<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Entity\Products;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrdersDetailsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new Users();
        $user->setEmail('user@email.com');
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword('azerty');
        $user->setLastname('lastname');
        $user->setFirstname('firstname');
        $user->setAddress('address');
        $user->setZipcode('12345');
        $user->setCity('city');
        $user->setResetToken('reset');
        $manager->persist($user);
        
        $order = new Orders();
        $order->setUsers($user);
        $order->setReference('REF-CMD-005');
        $manager->persist($order);

        $categorie = new Categories();
        $categorie->setParent(NULL);
        $categorie->setName('Categorie');
        $categorie->setCategoryOrder(1);
        $categorie->setSlug('categorie');
        $manager->persist($categorie);

        $product = new Products();
        $product->setCategories($categorie);
        $product->setName('Product');
        $product->setDescription('description');
        $product->setPrice('3.50');
        $product->setStock('20');
        $product->setSlug('product');
        $manager->persist($product);
        
        $orderDetail1 = new OrdersDetails();
        $orderDetail1->setOrders($order);
        $orderDetail1->setProducts($product);
        $orderDetail1->setQuantity(2);
        $orderDetail1->setPrice($product->getPrice() * $orderDetail1->getQuantity());
        $manager->persist($orderDetail1);

        $orderDetail2 = new OrdersDetails();
        $orderDetail2->setOrders($order);
        $orderDetail2->setProducts($product);
        $orderDetail2->setQuantity(3);
        $orderDetail2->setPrice($product->getPrice() * $orderDetail1->getQuantity());
        $manager->persist($orderDetail2);

        $orderDetail3 = new OrdersDetails();
        $orderDetail3->setOrders($order);
        $orderDetail3->setProducts($product);
        $orderDetail3->setQuantity(1);
        $orderDetail3->setPrice($product->getPrice() * $orderDetail1->getQuantity());
        $manager->persist($orderDetail3);

        $manager->flush();
    }
}
