<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class DataPersister implements DataPersisterInterface
{
    private $en;

    public function __construct(EntityManagerInterface $en,UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->en = $en;
        $this->userPasswordHasher = $userPasswordHasher;
    }


    public function supports($data): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data)
    {
        //dd($data);
        if ($data->getPassword()){
            $data->setPassword(
                $this->userPasswordHasher->hashPassword($data,$data->getPassword())
            );
            $data->eraseCredentials();
        }
        $this->en->persist($data);
        $this->en->flush();
    }

    public function remove($data)
    {
        $this->en->remove($data);
        $this->en->flush();
    }

    // Once called this data persister will resume to the next one
    public function resumable(array $context = []): bool
    {
        return true;
    }
}
