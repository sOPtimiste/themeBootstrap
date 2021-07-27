<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use App\Repository\ImageRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @Vich\Uploadable
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageUrl;


     /**
     * Undocumented variable
     *@Vich\UploadableField(mapping="image_url", fileNameProperty="imageUrl")
     * @var File
     */
    private $imageFile;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Announce::class, inversedBy="images")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $announce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Undocumented function
     *
     * @param File $imageFile
     * @return void
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if(null !== $imageFile){
            $this->updated = new DateTime();
        }

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

    public function getAnnounce(): ?Announce
    {
        return $this->announce;
    }

    public function setAnnounce(?Announce $announce): self
    {
        $this->announce = $announce;

        return $this;
    }
}
