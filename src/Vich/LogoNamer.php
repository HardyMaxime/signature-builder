<?php

namespace App\Vich;

use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;

final class LogoNamer implements NamerInterface
{
    public function name($object, PropertyMapping $mapping): string
    {
        $file = $mapping->getFile($object);
        $ext  = $file->guessExtension() ?: $file->getClientOriginalExtension();
        return sprintf('%s.%s', 'logo-efra', $ext);
    }
}
