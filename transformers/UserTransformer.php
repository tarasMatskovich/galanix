<?php

namespace App\Transformers;


class UserTransformer extends BaseTransformer
{
    public function transform()
    {
        $data = [];
        $fields = [];
        foreach ($this->data as $i => $line) {
            if ($i === 0) {
                $fields = $line;
                continue;
            }
            $tmpArray = [];
            foreach ($line as $key => $value) {
                $tmpArray[$fields[$key]] = $value;
            }
            $data[] = $tmpArray;
        }
        $this->transformedData = $data;
    }
}