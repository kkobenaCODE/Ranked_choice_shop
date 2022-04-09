<?php

namespace App\Utils\File;

use App\Utils\Filesystem\FileSystemWorker;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileSaver
{
    /**
     * @var SluggerInterface
     */
    private $slugger;
    /**
     * @var string
     */
    private $uploadsTempDir;
    /**
     * @var FileSystemWorker
     */
    private $fileSystemWorker;

    public function __construct(SluggerInterface $slugger, FileSystemWorker $fileSystemWorker ,string $uploadsTempDir)
    {
        $this->slugger = $slugger;
        $this->uploadsTempDir = $uploadsTempDir;
        $this->fileSystemWorker = $fileSystemWorker;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string|null
     */
    public function saveUploadedFileIntoTemp(UploadedFile $uploadedFile): ?string
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $saveFilename = $this->slugger->slug($originalFilename);

        $filename = sprintf('%s-%s.%s', $saveFilename, uniqid(), $uploadedFile->guessExtension());
        $this->fileSystemWorker->createFolderIfItNotExist($this->uploadsTempDir);

        try {
            $uploadedFile->move($this->uploadsTempDir, $filename);
        } catch (FileException $exception) {
            return null;
        }
        return $filename;
    }


}