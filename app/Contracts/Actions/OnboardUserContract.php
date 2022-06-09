<?php

namespace App\Contracts\Actions;

interface OnboardUserContract
{
    public function __invoke($data);
}
