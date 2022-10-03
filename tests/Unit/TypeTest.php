<?php

namespace App\Tests\Unit;

use App\Entity\Type;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TypeTest extends KernelTestCase
{
    public function testSomething(): void
    {

        self::bootKernel();
        $container=static::getContainer();
        $user=$container->get("doctrine.orm.entity_manager")->find(User::class,5);
        $type=new Type();
        $type->setNom("f")
             ->setUser($user);
        $errors=$container->get("validator")->validate($type);
        $this->assertCount(0,$errors);

    }
}
