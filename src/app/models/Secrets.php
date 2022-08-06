<?php

use Phalcon\Mvc\Model;

class Secrets extends Model
{
    public $hash;

    public $secretText;

    public $createdAt;

    public $expiresAt;

    public $remainingViews;
}