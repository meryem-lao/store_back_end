<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ApiResource(
 *      normalizationContext= {"groups"={"product:read"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"name":"partial", "price":"partial", "color":"partial", "genre":"exact", "category.name":"exact"})
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("product:read", "category:read", "orderdetails:read","order:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("product:read", "category:read" ,"orderdetails:read","order:read")
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Groups("product:read", "orderdetails:read","order:read")
     * @Assert\Range(
     *      min = 0,
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups("product:read","orderdetails:read","order:read")
     * @Assert\Range(
     *      min = 0,
     * )
     */
    private $quantityStock;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Groups("product:read","orderdetails:read","order:read")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("product:read","orderdetails:read","order:read")
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("product:read","orderdetails:read","order:read")
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("product:read","orderdetails:read","order:read")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetail::class, mappedBy="product", orphanRemoval=true)
     * @Groups("product:read")
     */
    private $orderdetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("product:read","orderdetails:read","order:read")
     */
    private $description;

    public function __construct()
    {
        $this->orderdetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantityStock(): ?int
    {
        return $this->quantityStock;
    }

    public function setQuantityStock(int $quantityStock): self
    {
        $this->quantityStock = $quantityStock;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

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

    /**
     * @return Collection<int, OrderDetail>
     */
    public function getOrderdetails(): Collection
    {
        return $this->orderdetails;
    }

    public function addOrderdetail(OrderDetail $orderdetail): self
    {
        if (!$this->orderdetails->contains($orderdetail)) {
            $this->orderdetails[] = $orderdetail;
            $orderdetail->setProduct($this);
        }

        return $this;
    }

    public function removeOrderdetail(OrderDetail $orderdetail): self
    {
        if ($this->orderdetails->removeElement($orderdetail)) {
            // set the owning side to null (unless already changed)
            if ($orderdetail->getProduct() === $this) {
                $orderdetail->setProduct(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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
}
