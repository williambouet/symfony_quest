<?php

namespace App\Entity;

use DateTime;
use App\Entity\Program;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ActorRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ActorRepository::class)]
#[Vich\Uploadable] 
class Actor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Program::class, inversedBy: 'actors')]
    private ?Collection $programs;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $actor = null;

    #[Vich\UploadableField(mapping: 'poster_file', fileNameProperty: 'actor')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le poster saisi est trop long, il ne devrait pas dépasser {{ limit }} caractères',
    )]
    #[Assert\File(
        maxSize: '1M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
     private ?File $actorFile = null;

     #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
     private ?DateTime $updatedAt = null;
     
    public function __construct()
    {
        $this->programs = new ArrayCollection();
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

    /**
     * @return Collection<int, Program>
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs->add($program);
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        $this->programs->removeElement($program);

        return $this;
    }

     /**
      * Get the value of actorFile
      */ 
     public function getActorFile(): ?File
     {
          return $this->actorFile;
     }

     /**
      * Set the value of actorFile
      *
      * @return  self
      */ 
     public function setActorFile(File $actorFile = null): Actor
     {
          $this->actorFile = $actorFile;
        if ($actorFile)
            $this->updatedAt = new DateTime('now');
            
        return $this;
     }

     /**
      * Get the value of updatedAt
      */ 
      public function getUpdatedAt():DateTime
      {
          return $this->updatedAt;
      }
  
      /**
       * Set the value of updatedAt
       *
       * @return  self
       */ 
      public function setUpdatedAt(DateTime $updatedAt): Actor
      {
          $this->updatedAt = $updatedAt;
  
          return $this;
      }

    /**
     * Get the value of actor
     */ 
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * Set the value of actor
     *
     * @return  self
     */ 
    public function setActor($actor)
    {
        $this->actor = $actor;

        return $this;
    }
}
