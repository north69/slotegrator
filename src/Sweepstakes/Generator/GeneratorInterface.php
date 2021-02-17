<?php

namespace Sweepstakes\Generator;

interface GeneratorInterface
{
    public function isAvailable(): bool;

    public function generate();
}