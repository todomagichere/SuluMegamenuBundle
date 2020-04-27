<?php

declare(strict_types=1);

namespace TheCocktail\Bundle\MegaMenuBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="TheCocktail\Bundle\MegaMenuBundle\Repository\MenuItemRepository")
 * @ORM\Table(name="mm_menuitem")
 */
class MenuItem
{
    const RESOURCE_KEY = 'megamenu';

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected string $resourceKey;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected string $webspace;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected string $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected string $locale;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $uuid = null;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $link = null;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected int $position = 0;

    /**
     * @var MenuItem
     *
     * Many Categories have One Category.
     * @ORM\ManyToOne(targetEntity="MenuItem", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected ?MenuItem $parent = null;

    /**
     * @var Collection|MenuItem[]
     *
     * One MenuItem has Many MenuItem.
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="parent")
     */
    protected $children;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("id")
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): MenuItem
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("context")
     */
    public function getResourceKey(): string
    {
        return $this->resourceKey;
    }

    public function setResourceKey(string $resourceKey): MenuItem
    {
        $this->resourceKey = $resourceKey;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("webspace")
     */
    public function getWebspace(): string
    {
        return $this->webspace;
    }

    public function setWebspace(string $webspace): MenuItem
    {
        $this->webspace = $webspace;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("title")
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): MenuItem
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("locale")
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): MenuItem
    {
        $this->locale = $locale;

        return $this;
    }
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("uuid")
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): MenuItem
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("link")
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): MenuItem
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("position")
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): MenuItem
    {
        $this->position = $position;

        return $this;
    }


    public function setParent(MenuItem $parent = null): MenuItem
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("parent")
     */
    public function getParent(): ?MenuItem
    {
        return $this->parent;
    }

    public function hasParent(): bool
    {
        return isset($this->parent);
    }

    public function addChild(MenuItem $child): MenuItem
    {
        $this->children[] = $child;

        return $this;
    }

    public function removeChild(MenuItem $child): void
    {
        $this->children->removeElement($child);
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("children")
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function hasChildren(): bool
    {
        return $this->children->count() ? true: false;
    }
}
