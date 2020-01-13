<?php

declare(strict_types=1);

namespace Infrastructure\Translation;

use Infrastructure\Data\Cookie;

class Translate
{
    private const DEFAULT_LANGUAGE  = 'pt-br';

    public static function getInstance() : self
    {
        return new self();
    }

    public function translate(string $key, array $params = []) : ?string
    {
        $language = Cookie::cookie()->get('language');

        $translate = (new self())->create($language);

        if (!isset($translate[$key])) {
            return null;
        }

        if (count($params) > 0) {
            return str_replace(array_keys($params), $params, $translate[$key]);
        }

        return $translate[$key];
    }

    public function getTranslateAll() : array
    {
        $language = Cookie::cookie()->get('language');
        return (new self())->create($language);
    }

    private function create(?string $keyLanguage = self::DEFAULT_LANGUAGE) : array
    {
        $keyLanguage = $keyLanguage === null ? self::DEFAULT_LANGUAGE : $keyLanguage;

        foreach ($this->getLanguages() as $language) {
            if ($keyLanguage !== $language->getKey()) {
                continue;
            }

            return $language->translations();
        }

        return [];
    }

    /**
     * @return Translation[]
     */
    private function getLanguages() : array
    {
        $languages = [];

        foreach (new \DirectoryIterator($this->getPathTranslate()) as $current) {
            if ($current->isDot() || $current->isDir() || $current->getExtension() !== 'php') {
                continue;
            }

            $languages[] = $this->getLanguage($current->getFilename());
        }

        $languages = array_filter($languages, function ($language) {
            return $language !== null;
        });

        return $languages;
    }

    private function getLanguage(string $className) : ?Translation
    {
        $class = "\\Config\\Translation\\". str_replace(['.php'], [''], $className);

        $reflector = new \ReflectionClass($class);

        if ($reflector->isInterface() || $reflector->isAbstract()) {
            return null;
        }

        $object = new $class;

        if (!$object instanceof Translation) {
            return null;
        }

        return $object;
    }

    private function getPathTranslate() : string
    {
        return str_replace(['/web', '\web'], ['', ''], getcwd() . '/Config/Translation');
    }
}
