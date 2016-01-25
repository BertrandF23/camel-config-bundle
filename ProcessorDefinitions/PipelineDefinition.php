<?php

namespace Smartbox\Integration\CamelConfigBundle\ProcessorDefinitions;

use Symfony\Component\DependencyInjection\Reference;
use JMS\Serializer\Annotation as JMS;

/**
 * Class PipelineDefinition
 * @package Smartbox\Integration\CamelConfigBundle\ProcessorDefinitions
 */
class PipelineDefinition extends ProcessorDefinition
{
    const PIPELINE = 'pipeline';

    /**
     * {@inheritdoc}
     */
    public function buildProcessor($configNode, $id)
    {
        $def = parent::buildProcessor($configNode, $id);

        $itineraryName = $this->getBuilder()->generateNextUniqueReproducibleIdForContext($id);
        $itinerary = $this->builder->buildItinerary($itineraryName);
        foreach ($configNode as $nodeName => $nodeValue) {
            switch ($nodeName) {
                case self::DESCRIPTION:
                    $def->addMethodCall('setDescription', [(string)$nodeValue]);
                    break;
                default:
                    $this->builder->addNodeToItinerary($itinerary,$nodeName,$nodeValue);
                    break;
            }
        }
        $def->addMethodCall('setItinerary', [$itinerary]);

        return $def;
    }
}
