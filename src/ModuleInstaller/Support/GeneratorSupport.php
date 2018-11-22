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
     * GeneratorSupport constructor.
     * @param $destinationFilePath
     * @param $templateContents
     */
    public function __construct($destinationFilePath, $templateContents)
    {
        $this->templateContents = $templateContents;
        $this->destinationFilePath = $destinationFilePath;
    }

    /**
     * Execute the console command.
     */
    public function generate()
    {
        $path = str_replace('\\', '/', $this->getDestinationFilePath());

        if (!$this->laravel['files']->isDirectory($dir = dirname($path))) {
            $this->laravel['files']->makeDirectory($dir, 0777, true);
        }

        $contents = $this->getTemplateContents();

        try {
            with(new FileGenerator($path, $contents))->generate();
            return "Created : {$path}";
        } catch (FileAlreadyExistException $e) {
            return "File : {$path} already exists.";
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



}
