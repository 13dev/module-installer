<?php

namespace Dev13\ModuleInstaller\Support;

use Dev13\ModuleInstaller\Exceptions\FileAlreadyExistException;
use Dev13\ModuleInstaller\Generators\FileGenerator;

class GeneratorSupport
{
    /**
     * @var string stub specific path.
     */
    private $destinationFilePath;

    /**
     * @var string store stub contents.
     */
    private $templateContents;

    /**
     * Instance of laravel
     */
    private $laravel;

    /**
     * @var string
     */
    private $message;

    /**
     * GeneratorSupport constructor.
     * @param $laravel
     */
    public function __construct($laravel)
    {
        $this->laravel = $laravel;
        $this->message = '';
    }

    /**
     * Execute the console command.
     */
    public function generate(): bool
    {
        $path = str_replace('\\', '/', $this->getDestinationFilePath());

        if (!$this->laravel['files']->isDirectory($dir = dirname($path))) {
            $this->laravel['files']->makeDirectory($dir, 0777, true);
        }

        $contents = $this->getTemplateContents();

        try {
            with(new FileGenerator($path, $contents))->generate();
            $this->setMessage("Created : {$path}");
            return true;
        } catch (FileAlreadyExistException $e) {
            $this->setMessage("The file {$path} already exists");
            return false;
        }
    }

    /**
     * @return string
     */
    public function getDestinationFilePath()
    {
        return $this->destinationFilePath;
    }

    /**
     * @param string $destinationFilePath
     */
    public function setDestinationFilePath($destinationFilePath)
    {
        $this->destinationFilePath = $destinationFilePath;
    }

    /**
     * @return string
     */
    public function getTemplateContents()
    {
        return $this->templateContents;
    }

    /**
     * @param string $templateContents
     */
    public function setTemplateContents($templateContents)
    {
        $this->templateContents = $templateContents;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

}
