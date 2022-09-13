<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 * @ORM\Table(name="annonce", indexes={@ORM\Index(columns={"title","content"}, flags={"fulltext"})})
 */
class Annonce
{
    const LABEL_URGENT = "Urgent";
    const LABEL_PROMOTION = "Promotion";
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $is_active = true;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotNull
     */
    private $etat = 'En ligne';

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="annonces")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="annonce",cascade={"persist"})
     * @Assert\NotBlank
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="favoris")
     */
    private $favori;

    /**
     * @ORM\Column(type="integer")
     */
    private $vue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $label;

    const etats=[
        'En attente'=>'En attente',
        'En ligne'=>'En ligne',
        'Hors ligne'=>'Hors ligne',
    ];
    const EN_ATTENTE = "En attente";

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->favori = new ArrayCollection();
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getSlug()
    {
        // return (new Slugify())->slugify($this->title);
        return str_replace(' ','_',$this->title);
    }

    public function setTitle(string $title): self
    {
        $this->title =ucfirst($title);

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content =ucfirst($content);

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat =ucfirst($etat);

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAnnonce($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnnonce() === $this) {
                $image->setAnnonce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFavori(): Collection
    {
        return $this->favori;
    }

    public function addFavori(User $favori): self
    {
        if (!$this->favori->contains($favori)) {
            $this->favori[] = $favori;
        }

        return $this;
    }

    public function removeFavori(User $favori): self
    {
        $this->favori->removeElement($favori);

        return $this;
    }

    public function getVue(): ?int
    {
        return $this->vue;
    }

    public function setVue(int $vue): self
    {
        $this->vue = $vue;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
