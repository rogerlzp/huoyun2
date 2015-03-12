<?php

namespace Tricks\Services\Forms;

class AttributeForm extends AbstractForm
{
    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = [
        'name'        => 'required',
        'value' => 'required'
    ];
}
