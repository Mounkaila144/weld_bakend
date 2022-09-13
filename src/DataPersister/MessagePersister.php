<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Message;

final class MessagePersister implements DataPersisterInterface
{
    private $en;

    public function __construct(EntityManagerInterface $en)
    {
        $this->en = $en;
    }


    public function supports($data): bool
    {
        return $data instanceof Message;
    }

    /**
     * @param Message $data
     */
    public function persist($data)
    {
        //dd($data);
        $data->setUpdateAt(new \DateTime());
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
