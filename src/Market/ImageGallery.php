<?php


namespace Market;


use Exception;
use Services\Storage\FileStorageInterface;
use Services\Storage\ImageObjectFactory;

class ImageGallery
{
    private ImageObjectFactory $factory;
    private string $topFileUri;

    /**
     * ImageGallery constructor.
     * @param ImageObjectFactory $factory
     */
    public function __construct(ImageObjectFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string $imageFileUri
     * @return bool|null
     * @throws Exception
     */
    public function fileExists(string $imageFileUri): ?bool
    {
        return $this->match($imageFileUri)->fileExists($imageFileUri) ?? false;
    }

    /**
     * @param string $imageFileUri
     * @return string|null
     * @throws Exception
     */
    public function getUrl(string $imageFileUri): ?string
    {
        return $this->match($imageFileUri)->getUrl($imageFileUri);
    }

    /**
     * @param string $imageFileUri
     * @throws Exception
     */
    public function deleteFile(string $imageFileUri): void
    {
        $this->match($imageFileUri)->deleteFile($imageFileUri);
    }

    /**
     * @param string $imageFileUri
     * @return string|null
     * @throws Exception
     */
    public function saveFile(string $imageFileUri): ?string
    {
        $this->match($imageFileUri)->saveFile($imageFileUri);
        throw new Exception();
    }

    /**
     * @param string $imageFileUri
     * @return FileStorageInterface
     * @throws Exception
     */
    private function match(string $imageFileUri): FileStorageInterface
    {
        $imageObject = $this->factory->match($imageFileUri);
        if ($imageObject !== null) {
            return $imageObject;
        }

        throw new Exception('no math for imageFileUri ' . $imageFileUri);
    }

    /*...*/
    /**
     * @return string
     */
    public function getTopFileUri(): string
    {
        return $this->topFileUri ?: current($this->listImages());
    }

    /**
     * @param string $topFileUri
     */
    public function setTopFileUri(string $topFileUri): void
    {
        $this->topFileUri = $topFileUri;
    }

    /**
     * Возвращает список uri картинок в галерее
     * @return string[]
     */
    public function listImages(): array
    {
        /** returns list of image uri in gallery */
    }

}