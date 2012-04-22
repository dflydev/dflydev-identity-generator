<?php

/*
 * This file is a part of dflydev/identity-generator.
 * 
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\IdentityGenerator;

use Dflydev\IdentityGenerator\DataStore\DataStoreInterface;
use Dflydev\IdentityGenerator\Exception\GenerateException;
use Dflydev\IdentityGenerator\Exception\NonUniqueIdentityException;
use Dflydev\IdentityGenerator\Generator\GeneratorInterface;

class IdentityGenerator
{
    protected $dataStore;
    protected $generator;
    protected $mob;
    protected $maxRetries = 0;

    /**
     * Constructor
     * 
     * @param DataStoreInterface $dataStore
     * @param GeneratorInterface $generator
     */
    public function __construct(DataStoreInterface $dataStore, GeneratorInterface $generator)
    {
        $this->dataStore = $dataStore;
        $this->generator = $generator;
    }

    /**
     * Generate an identity string
     * 
     * @param string|null $suggestion
     * @return string
     */
    public function generate($suggestion = null)
    {
        if (null !== $suggestion) {
            return $this->dataStore->storeIdentity($suggestion, $this->mob);
        }

        $exceptions = array();
        for ($i = 0; $i <= $this->maxRetries; $i++) {
            $generatedIdentity = null;
            try {
                $generatedIdentity = $this->generator->generateIdentity();
                $this->dataStore->storeIdentity($generatedIdentity, $this->mob);

                return $generatedIdentity;
            } catch (NonUniqueIdentityException $e) {
                // We expect non unique identity exceptions so this is fine.
                // Collect them and move on and try again if we still have
                // some tries left.
                $exceptions[] = $e;
            } catch (\Exception $e) {
                // All other exceptions are unexpected.
                throw new GenerateException($generatedIdentity, $this->mob, $exceptions, $e);
            }
        }

        throw new GenerateException(null, $this->mob, $exceptions);
    }

    /**
     * Set mob
     * 
     * @param string|null $mob
     * @return IdentityGenerator
     */
    public function setMob($mob = null)
    {
        $this->mob = $mob;

        return $this;
    }

    /**
     * Set max retries
     * 
     * @param int $maxRetries
     * @return IdentityGenerator
     */
    public function setMaxRetries($maxRetries)
    {
        $this->maxRetries = $maxRetries;

        return $this;
    }
}