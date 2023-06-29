<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class ProductType extends Enum
{
    const Elite = '1';
    const Premium = '2';
    const Classic = '3';
    const Regular = '4';
}
