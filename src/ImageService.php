<?php
declare(strict_types=1);

namespace App;

use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\UploadedFileFactory;
use Psr\Http\Message\UploadedFileInterface;
use Cake\Validation\Validation;

class ImageService implements ImageServiceInterface
{
    protected static $imageService;

    public function getDirectoryAbsPath()
    {
        return WWW_ROOT. 'img/';
    }

    public function validateMimeType(string $filename)
    {
        $filePath = $this->getDirectoryAbsPath().$filename;
        $stream = (new StreamFactory())->createStreamFromFile($filePath);
        $file = (new UploadedFileFactory)->createUploadedFile($stream);
        if (!Validation::mimeType($file, ['image/jpeg', 'image/png'])) {
            return 'JPEG か PNG 形式のファイルを選択してください';
        }
        return true;
    }

    public function validateEmptyFile(string $filename)
    {
        if (empty($value)) {
            return '必須項目';
        }
        return true;
    }
    
    public function moveFile(UploadedFileInterface $file)
    {
        $filename = $this->generateFilename($file);
        $destination = $this->getDirectoryAbsPath() . $filename;
        $file->moveTo($destination);
        return $filename;
    }

    protected function generateFilename(UploadedFileInterface $file)
    {
        return date("YmdHis").$file->getClientFilename();
    }
    
    public function deleteFile(string $filename)
    {
        unlink($this->getDirectoryAbsPath() . $filename);
    }

    public static function getInstance()
    {
        if (empty(self::$imageService)) {
            self::$imageService = new self;
        }
        return self::$imageService;
    }
}
