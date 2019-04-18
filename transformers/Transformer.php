<?php


namespace App\Transformers;


interface Transformer
{
    public function __construct(array $data);
    public function transform();
}