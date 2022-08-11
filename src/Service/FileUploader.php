<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    /**
     * FileUploader constructor.
     * @param string $uploadsDir => voir config/services.yaml
     */
    public function __construct(
        private string $uploadsDir
    ) { }

    public function uploadFile(UploadedFile $uploadedFile, string $namespace = ''): string
    {
        $destination = $this->uploadsDir.$namespace;
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
        $uploadedFile->move($destination, $newFilename);
        return '/uploads'.$namespace.'/'.$newFilename;
    }

}