<?php
declare(strict_types=1);

namespace App;

use Psr\Http\Message\UploadedFileInterface;

interface ImageServiceInterface
{
    public function getDirectoryAbsPath();

    public function validateMimeType(string $filename);
    
    public function validateEmptyFile(string $filename);
    
    public function moveFile(UploadedFileInterface $file);
    
    public function deleteFile(string $filename);
}
