<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShoppingItemRepository")
 */
class ShoppingItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ShoppingList", inversedBy="shoppingItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shoppingList;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Shop")
     */
    private $shop;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ShoppingCategory")
     */
    private $shoppingCategory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="shoppingItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $picker;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShoppingList(): ?ShoppingList
    {
        return $this->shoppingList;
    }

    public function setShoppingList(?ShoppingList $shoppingList): self
    {
        $this->shoppingList = $shoppingList;

        return $this;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getShoppingCategory(): ?ShoppingCategory
    {
        return $this->shoppingCategory;
    }

    public function setShoppingCategory(?ShoppingCategory $shoppingCategory): self
    {
        $this->shoppingCategory = $shoppingCategory;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getPicker(): ?User
    {
        return $this->picker;
    }

    public function setPicker(?User $picker): self
    {
        $this->picker = $picker;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
