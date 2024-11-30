<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class TileTypeDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Name is required.')]
        public string $name,

        #[Assert\Choice(choices: ['Audi', 'BMW', 'Porsche'], message: 'Invalid category.')]
        public string $category,

        #[Assert\Choice(choices: ['Germany', 'China', 'Russia'], message: 'Invalid country.')]
        public string $country,

        #[Assert\Length(max: 255, maxMessage: 'Description cannot be longer than 255 characters.')]
        public string $description,

        #[Assert\NotBlank(message: 'Image path is required.')]
        public string $imagePath
    )
    {
    }
}
