<?php

namespace Market;

use Exception;

/**
 * Represents a single product record stored in DB.
 */
class Product
{
    /*...*/

    /**
     * @var ImageGallery
     */
    private ImageGallery $gallery;
    /**
     * @var string
     */
    private string $imageFileUri;


    /*...*/
    /**
     * Product constructor.
     * @param ImageGallery $storage
     */
    public function __construct(ImageGallery $storage)
    {
        $this->gallery = $storage;
    }

    /**
     * Returns product image URL.
     *
     * @return string|null
     * @throws Exception
     */
    public function getImageUrl(): ?string
    {
        if ($this->gallery->fileExists($this->imageFileUri) !== true) {
            return $this->gallery->getTopFileUri();
        }

        return $this->gallery->getUrl($this->imageFileUri);
    }

    /**
     * Returns whether image was successfully updated or not.
     *
     * @return bool
     */
    public function updateImage(): bool
    {
        /*...*/
        try {
            if ($this->gallery->fileExists($this->imageFileUri) !== true) {
                $this->gallery->deleteFile($this->imageFileUri);
            }

            $save = $this->gallery->saveFile($this->imageFileUri);

            if ($save) {
                $this->imageFileUri = $save;
            }

        } catch (Exception $exception) {
            /*...*/
            return false;
        }

        /*...*/

        return true;
    }

    public function listImages(): array
    {
        return $this->gallery->listImages();
    }
    /*...*/
}
