<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraint as Assert;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer")
     */
    private $vote;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $share_link;


    /**
     * @ORM\Column(type="integer")
     */
    private $dislikes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $shares;

    /**
     * @ORM\Column(type="integer")
     */
    private $replies;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="LikedPosts")
     */
    private $Likers;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="ParentID")
     */
    private $ParentId;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="ParentId")
     */
    private $ParentID;


    /**
     * Post constructor.
     */
    public function __construct()
    {
        // Valeurs par défaut de l'entité Post
        $this->setShareLink('/');
        $this->setDislikes(0);
        $this->setReplies(0);
        $this->setShares(0);
        $this->setVote(0);
        $this->setCategory('Uncategorized');
        $this->setUpdatedAt(new \DateTime());
        $this->setCreatedAt(new \DateTime());
        $this->Likers = new ArrayCollection();
        $this->ParentID = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getVote(): ?int
    {
        return $this->vote;
    }

    public function setVote(int $vote): self
    {
        $this->vote = $vote;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getShareLink(): ?string
    {
        return $this->share_link;
    }

    public function setShareLink(string $share_link): self
    {
        $this->share_link = $share_link;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->getLikers()->count();
    }


    public function getDislikes(): ?int
    {
        return $this->dislikes;
    }

    public function setDislikes(int $dislikes): self
    {
        $this->dislikes = $dislikes;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getShares(): ?int
    {
        return $this->shares;
    }

    public function setShares(int $shares): self
    {
        $this->shares = $shares;

        return $this;
    }

    public function getReplies(): ?int
    {
        return $this->replies;
    }

    public function setReplies(int $replies): self
    {
        $this->replies = $replies;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikers(): Collection
    {
        return $this->Likers;
    }

    public function addLiker(User $liker): self
    {
        if (!$this->Likers->contains($liker)) {
            $this->Likers[] = $liker;
            $liker->likePost($this);
        }

        return $this;
    }

    public function removeLiker(User $liker): self
    {
        if ($this->Likers->contains($liker)) {
            $this->Likers->removeElement($liker);
            $liker->unlikePost($this);
        }

        return $this;
    }

    public function getParentId(): ?self
    {
        return $this->ParentId;
    }

    public function setParentId(?self $ParentId): self
    {
        $this->ParentId = $ParentId;

        return $this;
    }

    public function addParentID(self $parentID): self
    {
        if (!$this->ParentID->contains($parentID)) {
            $this->ParentID[] = $parentID;
            $parentID->setParentId($this);
        }

        return $this;
    }

    public function removeParentID(self $parentID): self
    {
        if ($this->ParentID->contains($parentID)) {
            $this->ParentID->removeElement($parentID);
            // set the owning side to null (unless already changed)
            if ($parentID->getParentId() === $this) {
                $parentID->setParentId(null);
            }
        }

        return $this;
    }
}
