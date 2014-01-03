<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Loader;

/**
 * Base class for file loaders.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
abstract class AbstractFileLoader implements LoaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function load($path)
    {
        if (!is_file($path)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The path %s is not a file',
                    $path
                )
            );
        }

        $content = @file_get_contents($path);

        if (!is_string($content)) {
            throw new \RuntimeException(
                sprintf(
                    'Failed to read the file %s',
                    $path
                )
            );
        }

        return $this->doLoad($content);
    }

    /**
     * Performs the loading of the Petrinet.
     *
     * @param string $content The file content
     *
     * @return \Petrinet\PetrinetInterface The Petrinet
     */
    abstract protected function doLoad($content);
}
