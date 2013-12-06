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

use Petrinet\Transition\Transition;
use Petrinet\Place\Place;
use Petrinet\Token\Token;
use Petrinet\Petrinet;
use Petrinet\Arc\Arc;

/**
 * Loads a Petrinet from a xml file.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class XmlFileLoader implements LoaderInterface
{
    /**
     * Full path to the xml file.
     *
     * @var string
     */
    protected $path;

    /**
     * Creates a new xml loader.
     *
     * @param string $path Full or relative path to the xml file
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($path)
    {
        if (!is_file($path)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The path %s is not a file',
                    $path
                )
            );
        }

        $this->path = $path;
    }

    /**
     * Gets the full path to the xml file.
     *
     * @return string The full path to the xml file.
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        $content = @file_get_contents($this->path);

        if (!is_string($content)) {
            throw new \RuntimeException(
                sprintf(
                    'Failed to read the file %s',
                    $this->path
                )
            );
        }

        $document = new \DOMDocument();
        $document->loadXML($content);
        $this->validateSchema($document);

        return $this->doLoad(new \SimpleXMLElement($content));
    }

    /**
     * Performs the loading of the Petrinet.
     *
     * @param \SimpleXMLElement $element The xml element
     *
     * @return \Petrinet\PetrinetInterface
     *
     * @throws \RuntimeException
     */
    private function doLoad(\SimpleXMLElement $element)
    {
        $petrinetAttributes = $element->attributes();
        $petrinet = new Petrinet((string) $petrinetAttributes['id']);

        // Process places
        $this->doLoadPlaces($petrinet, $element);

        // Process transitions
        $this->doLoadTransitions($petrinet, $element);

        // Process arcs
        $this->doLoadArcs($petrinet, $element);

        return $petrinet;
    }

    /**
     * Loads the places from the xml element.
     *
     * @param Petrinet          $petrinet The Petrinet
     * @param \SimpleXMLElement $element  The xml element
     *
     * @throws \RuntimeException
     */
    private function doLoadPlaces(Petrinet $petrinet, \SimpleXMLElement $element)
    {
        // Process places
        $placeElements = $element->xpath('//petrinet/place');
        $places = array();

        foreach ($placeElements as $placeElement) {
            $placeAttributes = $placeElement->attributes();
            $placeId = (string) $placeAttributes['id'];
            $place = new Place($placeId);

            if (isset($placeAttributes['tokens'])) {
                $tokens = (string) $placeAttributes['tokens'];

                if (!is_numeric($tokens)) {
                    throw new \RuntimeException(
                        sprintf(
                            'The tokens number in place %s must be numeric',
                            $placeId
                        )
                    );
                }

                for ($i = 0; $i < (int) $tokens; $i++) {
                    $place->addToken(new Token());
                }
            }

            $places[$place->getId()] = $place;
            $petrinet->addPlace($place);
        }
    }

    /**
     * Loads the transitions from the xml element.
     *
     * @param Petrinet          $petrinet The Petrinet
     * @param \SimpleXMLElement $element  The xml element
     */
    private function doLoadTransitions(Petrinet $petrinet, \SimpleXMLElement $element)
    {
        $transitionElements = $element->xpath('//petrinet/transition');
        $transitions = array();

        foreach ($transitionElements as $transitionElement) {
            $transitionAttributes = $transitionElement->attributes();
            $transitionId = (string) $transitionAttributes['id'];
            $transition = new Transition($transitionId);

            $transitions[$transition->getId()] = $transition;
            $petrinet->addTransition($transition);
        }
    }

    /**
     * Loads the arcs from the xml element.
     *
     * @param Petrinet          $petrinet The Petrinet
     * @param \SimpleXMLElement $element  The xml element
     *
     * @throws \RuntimeException
     */
    private function doLoadArcs(Petrinet $petrinet, \SimpleXMLElement $element)
    {
        $arcElements = $element->xpath('//petrinet/arc');
        $arcs = array();

        foreach ($arcElements as $arcElement) {
            $arcAttributes = $arcElement->attributes();
            $from = (string) $arcAttributes['from'];
            $to = (string) $arcAttributes['to'];

            // Find and validate the extremities
            if (null !== $petrinet->getPlace($from)) {
                if (null === $petrinet->getTransition($to)) {
                    throw new \RuntimeException(
                        sprintf(
                            'Cannot find the transition %s (extremity of the arc going from %s)',
                            $to,
                            $from
                        )
                    );
                }

                $place = $petrinet->getPlace($from);
                $transition = $petrinet->getTransition($to);
                $direction = Arc::PLACE_TO_TRANSITION;

            } elseif (null !== $petrinet->getTransition($from)) {
                if (null === $petrinet->getPlace($to)) {
                    throw new \RuntimeException(
                        sprintf(
                            'Cannot find the place %s (extremity of the arc going from %s)',
                            $to,
                            $from
                        )
                    );
                }

                /** @var Place $place */
                $place = $petrinet->getPlace($to);
                /** @var Transition $transition */
                $transition = $petrinet->getTransition($from);
                $direction = Arc::TRANSITION_TO_PLACE;

            } else {
                throw new \RuntimeException(
                    sprintf(
                        'Cannot fine the place / transition %s (extremity of the arc going to %s)',
                        $from,
                        $to
                    )
                );
            }

            // Generate arc id
            if (isset($arcAttributes['id'])) {
                $arcId = (string) $arcAttributes['id'];
            } elseif (Arc::TRANSITION_TO_PLACE === $direction) {
                $arcId = '__arc__' . $transition->getId() . '__t__p__' . $place->getId();
            } else {
                $arcId = '__arc__' . $place->getId() . '__p__t__' . $transition->getId();
            }

            if (isset($arcs[$arcId])) {
                throw new \RuntimeException(
                    sprintf(
                        'An arc with id %s is already existing',
                        $arcId
                    )
                );
            }

            $arc = new Arc($arcId, $direction, $place, $transition);

            // Link everything
            if (Arc::TRANSITION_TO_PLACE === $direction) {
                $transition->addOutputArc($arc);
                $place->addInputArc($arc);
            } else {
                $place->addOutputArc($arc);
                $transition->addInputArc($arc);
            }

            $arcs[$arc->getId()] = $arc;
            $petrinet->addArc($arc);
        }
    }

    /**
     * Vaidates the xml file against the petrinet schema.
     *
     * @throws \RuntimeException
     */
    private function validateSchema(\DOMDocument $document)
    {
        if (!@$document->schemaValidate(__DIR__ . '/meta/schema.xsd')) {
            throw new \RuntimeException(
                sprintf(
                    'Invalid xml schema in document %s',
                    $this->path
                )
            );
        }
    }
}
