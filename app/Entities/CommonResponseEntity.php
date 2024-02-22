<?php

namespace App\Entities;

class CommonResponseEntity
{
    public int $status = 200;
    public string $errorMessage;
    public string $message;
    public mixed $data;
}
