<?php


namespace App\Transformers;


class BaseTransformer implements Transformer
{
    protected $data = null;
    protected $transformedData = null;
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->transform();
    }

    public function transform()
    {
        $this->transformedData = $this->data;
    }

    public function getData()
    {
        return $this->transformedData;
    }
}