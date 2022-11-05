<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 * @ApiResource(
 *      normalizationContext= {"groups"={"order:read"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"dateOrder":"partial", "total":"partial", "total":"partial", "user.firstName":"partial", "user.lastName":"partial"})
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("order:read", "user:read")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("order:read")
     */
    private $dateOrder;

    /**
     * @ORM\Column(type="float")
     * @Groups("order:read")
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("order:read")
     */
    private $confirmation;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetail::class, mappedBy="idOrder")
     * @Groups("order:read")
     */
    private $orderDetails;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("order:read")
     */
    private $user;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
        $this->dateOrder = new \DateTime('@' . strtotime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOrder(): ?\DateTimeInterface
    {
        return $this->dateOrder;
    }

    public function setDateOrder(\DateTimeInterface $dateOrder): self
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getConfirmation(): ?string
    {
        return $this->confirmation;
    }

    public function setConfirmation(string $confirmation): self
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * @return Collection<int, OrderDetail>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
            $orderDetail->setIdOrder($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getIdOrder() === $this) {
                $orderDetail->setIdOrder(null);
            }
        }

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
}
