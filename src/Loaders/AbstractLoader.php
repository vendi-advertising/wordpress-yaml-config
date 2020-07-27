<?php

namespace Vendi\WordPressYaml\Loaders;

use Psr\Log\LoggerInterface;
use Vendi\WordPressYaml\Exceptions\InvalidLoaderDataException;

abstract class AbstractLoader implements LoaderInterface
{
    private string $sectionName;

    private LoggerInterface $logger;

    public function __construct(string $sectionName, LoggerInterface $logger)
    {
        $this->sectionName = $sectionName;
        $this->logger = $logger;
    }

    final public function getSectionName(): string
    {
        return $this->sectionName;
    }

    /**
     * @param $data
     *
     * @throws InvalidLoaderDataException
     */
    final public function requireDataValuesToBeStrings($data): void
    {
        $this->requireDataValuesToBeSomething($data, 'array', 'is_string');
    }

    /**
     * @param $data
     *
     * @throws InvalidLoaderDataException
     */
    final public function requireDataValuesToBeArray($data): void
    {
        $this->requireDataValuesToBeSomething($data, 'array', 'is_array');
    }

    /**
     * @param          $data
     * @param string   $friendlyTypeName
     * @param callable $tester
     *
     * @throws InvalidLoaderDataException
     */
    private function requireDataValuesToBeSomething($data, string $friendlyTypeName, callable $tester): void
    {
        if (!is_array($data)) {
            return;
        }

        foreach ($data as $key => $value) {
            if (!is_string($key)) {
                throw new InvalidLoaderDataException(sprintf('The %1$s loader requires that keys are of type strings', $this->getSectionName()));
            }
            if (!$tester($value)) {
                throw new InvalidLoaderDataException(sprintf('The %1$s loader requires that values are of type %2$s', $this->getSectionName(), $friendlyTypeName));
            }
        }
    }

    protected function logThatHookWasCalled(string $hook): void
    {
        $this->getLogger()->debug('Hook invoked', ['hook' => $hook, 'section' => $this->getSectionName()]);
    }

    protected function assertGlobalFunctionExists(string $functionName): void
    {
        $this->getLogger()->debug('Making sure global function exists', ['function' => $functionName, 'section' => $this->getSectionName()]);
        assert(function_exists($functionName));
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}
