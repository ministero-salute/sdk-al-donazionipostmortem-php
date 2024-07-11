<?php
namespace AccessLayerMdS;

use AccessLayerMdS\ResponseFlux;
use AccessLayerMdS\ResponseGetInfo;
use AccessLayerMdS\ResponseSendFile;
use AccessLayerMdS\ResponseSingleRecord;
use AccessLayerMdS\ResponseStateVerify;
use AccessLayerMdS\ObjectName;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use ReflectionObject;

class Base
{
    /**
     * Class casting
     *
     * @param string|object $destination
     * @param object $sourceObject
     * @return object
     */
    function cast($destination, $sourceObject)
    {
        #echo '$destination=' . $destination . '<br />';
        #var_dump($sourceObject);
        if (is_string($destination)) {
            $destination = match($destination) {
                "ResponseFlux" => new ResponseFlux(),
                "ResponseGetInfo" => new ResponseGetInfo(),
                "ResponseSendFile" => new ResponseSendFile(),
                "ResponseSingleRecord" => new ResponseSingleRecord(),
                "ResponseStateVerify" => new ResponseStateVerify(),
            };
        }

        $sourceReflection = new ReflectionObject($sourceObject);
        $destinationReflection = new ReflectionObject($destination);
        $sourceProperties = $sourceReflection->getProperties();
        foreach ($sourceProperties as $sourceProperty) {
            $sourceProperty->setAccessible(true);
            $name = $sourceProperty->getName();
            $value = $sourceProperty->getValue($sourceObject);
            if ($destinationReflection->hasProperty($name)) {
                $propDest = $destinationReflection->getProperty($name);
                $propDest->setAccessible(true);
                if ($value != null) {
                    $propDest->setValue($destination,$value);
                }
            } else {
                $destination->$name = $value;
            }
        }

        #var_dump($destination);
        return $destination;
    }
}
