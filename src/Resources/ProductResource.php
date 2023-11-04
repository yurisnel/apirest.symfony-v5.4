<?php

namespace App\Resources;

use App\Entity\EntityBase;
use App\Entity\Product;
use App\Traits\TransformResourseTrait;

class ProductResource
{
    use TransformResourseTrait {
        create as traitCreate;
    }

    public $name;

    public $price;

    public $categoryName;

    public static function create(Product $entity)
    {
        $resource = self::traitCreate($entity);
        $resource->categoryName = $entity->getCategory()->getName();
        return $resource;
    }
}
