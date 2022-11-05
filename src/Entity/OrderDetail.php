<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups ;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ORM\Entity(repositoryClass=OrderDetailRepository::class)
 * @ApiResource(
 *      normalizationContext= {"groups"={"orderdetails:read"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"idOrder.total":"partial","idOrder.id":"partial","idOrder.confirmation":"partial"})
 */
class OrderDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("order:read","orderdetails:read")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups("order:read", "orderdetails:read")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="orderdetails")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("order:read", "orderdetails:read")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderDetails")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("order:read", "orderdetails:read")
     */
    private $idOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getIdOrder(): ?Order
    {
        return $this->idOrder;
    }

    public function setIdOrder(?Order $idOrder): self
    {
        $this->idOrder = $idOrder;

        return $this;
    }
}
