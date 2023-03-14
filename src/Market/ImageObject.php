<?php


namespace Market;


use Services\Storage\FileStorageInterface;

class ImageObject
{
    private FileStorageInterface $storage;

    /**
     * ImageObject constructor.

     * @param FileStorageInterface $storage
     */
    public function __construct(FileStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param string $uri
     * @return string
     */
    public function getFileUrl($uri): string
    {
        return $this->storage->getUrl($uri);
    }

}