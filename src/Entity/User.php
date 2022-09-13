<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ApiFilter(SearchFilter::class, properties: ['boutique' => 'exact'])]
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
        ],
    ],
    iri: 'https://schema.org/User',
    denormalizationContext: ['groups' => ['user:write']],
    normalizationContext: ['groups' => ['user:read']],
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]

#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is  already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ApiProperty(iri: 'https://schema.org/contentUrl')]
    #[Groups(['user:read'])]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: 'user', fileNameProperty: 'filePath')]
    #[Groups(['user:write'])]
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:read','user:write'])]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @SerializedName("password")
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:write'])]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Groups(['user:read','user:write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Groups(['user:read','user:write'])]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read','user:write'])]
    private ?string $Adresse = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['user:read','user:write'])]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Type::class)]
    #[Groups(['user:read','user:write'])]
    private Collection $type;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Article::class)]
    #[Groups(['user:read','user:write'])]
    private Collection $articles;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Message::class)]
    #[Groups(['user:read','user:write'])]
    private Collection $usermessage;

    #[ORM\OneToMany(mappedBy: 'destinateur', targetEntity: Message::class)]
    #[Groups(['user:read','user:write'])]
    private Collection $destinateurmessage;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read','user:write'])]
    private ?string $boutique = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['user:read','user:write'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read','user:write'])]
    private ?string $telephone = null;


    public function __construct()
    {
        $this->type = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->usermessage = new ArrayCollection();
        $this->destinateurmessage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }


    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Type>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(Type $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
            $type->setUser($this);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->type->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getUser() === $this) {
                $type->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getUsermessage(): Collection
    {
        return $this->usermessage;
    }

    public function addUsermessage(Message $usermessage): self
    {
        if (!$this->usermessage->contains($usermessage)) {
            $this->usermessage[] = $usermessage;
            $usermessage->setUser($this);
        }

        return $this;
    }

    public function removeUsermessage(Message $usermessage): self
    {
        if ($this->usermessage->removeElement($usermessage)) {
            // set the owning side to null (unless already changed)
            if ($usermessage->getUser() === $this) {
                $usermessage->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getDestinateurmessage(): Collection
    {
        return $this->destinateurmessage;
    }

    public function addDestinateurmessage(Message $destinateurmessage): self
    {
        if (!$this->destinateurmessage->contains($destinateurmessage)) {
            $this->destinateurmessage[] = $destinateurmessage;
            $destinateurmessage->setDestinateur($this);
        }

        return $this;
    }

    public function removeDestinateurmessage(Message $destinateurmessage): self
    {
        if ($this->destinateurmessage->removeElement($destinateurmessage)) {
            // set the owning side to null (unless already changed)
            if ($destinateurmessage->getDestinateur() === $this) {
                $destinateurmessage->setDestinateur(null);
            }
        }

        return $this;
    }

    public function getBoutique(): ?string
    {
        return $this->boutique;
    }

    public function setBoutique(string $boutique): self
    {
        $this->boutique = $boutique;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

}
