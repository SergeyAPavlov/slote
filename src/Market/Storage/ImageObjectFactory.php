<?php


namespace Services\Storage;


use Market\FileStorageRepository;

class ImageObjectFactory
{
    private array $matches;
    private array $repos;

    /**
     * ImageObjectFactory constructor.
     * @param string[] $matches
     * @param FileStorageRepository $fileStorageRepository
     * @param AwsStorageRepository $awsStorageRepository
     */
    public function __construct(array $matches, FileStorageRepository $fileStorageRepository,AwsStorageRepository $awsStorageRepository)
    {
        $this->matches = $matches;
        $this->repos = ['file' => $fileStorageRepository, 'aws' => $awsStorageRepository];
    }

    public function match(string $uri): ?FileStorageInterface
    {
        foreach ($this->matches as $repoName => $match) {
            if (str_starts_with($uri, $match)) {
                return $this->repos[$repoName] ?? null;
            }
        }

        return null;
    }

}