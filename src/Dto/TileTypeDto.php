<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class TileTypeDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Name is required.')]
        public string $name,

        public string $category,

        public string $country,

        public string $description
    )
    {
    }
}
