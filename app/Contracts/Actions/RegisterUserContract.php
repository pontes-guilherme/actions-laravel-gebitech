<?php

namespace App\Contracts\Actions;

interface RegisterUserContract
{
    public function __invoke(array $data);
}
