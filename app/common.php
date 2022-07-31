<?php

use JetBrains\PhpStorm\ArrayShape;

#[ArrayShape(["first_name" => "string", "last_name" => "string"])] function _auth(): array
{
    return [
        "first_name" =>"Pape Sammba",
        "last_name" =>"NDOUR",
    ];
}

function title(string $title): string
{
    return "INTECH API " . $title;
}
