<?php

namespace App\Requests;


use Symfony\Component\Validator\Constraints as Assert;

class ProductRequest extends BaseRequest
{

      /**
       * @Assert\NotBlank
       */
      public $name;

      /**
       * @Assert\NotBlank  
       */
      public $price;

       /**
       * @Assert\NotBlank  
       */
      public $categoryName;
}
