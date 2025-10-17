<?php

namespace App\Entity;

use App\Repository\LogoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: LogoRepository::class)]
#[Vich\Uploadable]
class Logo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // ✅ Champ virtuel Vich (PAS de colonne Doctrine ici)
    #[Vich\UploadableField(mapping: 'logo_images', fileNameProperty: 'imageName', size: 'imageSize')]
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/png'],
        mimeTypesMessage: 'Veuillez envoyer une image PNG uniquement (max 5 Mo).'
    )]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    // ✅ Propriété liée à "size" dans l’annotation
    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    // ✅ Retourne bien un File
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if ($imageFile !== null) {
            // Nécessaire pour déclencher les listeners Doctrine/Vich
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;
        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
