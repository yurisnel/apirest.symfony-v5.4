<?php

namespace App\Traits;

use App\Entity\EntityBase;
use Doctrine\Common\Collections\Collection;

/**
 * Trait para crear la data da la paginación
 */
trait TransformResourseTrait
{
    public static function create(EntityBase $entity)
    {
        $properties = get_class_vars(self::class);
        $resource = new self();
        foreach (array_keys($properties) as $property) {
            if (property_exists($entity, $property)) {
                $resource->{$property} = $entity->getProperty($property);
            }
        }
        return $resource;
    }

    public static function collection($resource)
    {
        $result = [];
        if ($resource instanceof Collection) {
            foreach ($resource as $item) {
                $result[] = selF::create($item);
            }
        } else {
            foreach ($resource as $item) {
                $result[] = selF::create($item);
            }
        }
        return $result;
    }
}
