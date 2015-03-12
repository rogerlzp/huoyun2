<?php

namespace Tricks\Services\Forms;

class ImageTagForm extends AbstractForm
{
    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = [
        'x1'         => 'required',
        'y1'   => 'required',
        'w'          => 'required',
        'h'    => 'required',
        'image_id'          => 'required',
        'product_id'          => 'required',
    ];

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'x1', 'y1', 'w', 'h', 'image_id', 'product_id'
        ]);
    }
}
