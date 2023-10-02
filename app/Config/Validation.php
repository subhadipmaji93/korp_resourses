<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $AddInwardDataRule = [
        'contractor' => 'required',
        'vehicle' => 'required|alpha_numeric_punct',
        'gross_weight' => 'required|numeric',
        'tare_weight' => 'required|numeric',
        'from' => 'required',
        'to' => 'required'
    ];

    public $AddProductionDataRule = [
        'contractor' => 'required',
        'vehicle' => 'required|alpha_numeric_punct',
        'gross_weight' => 'required|numeric',
        'tare_weight' => 'required|numeric',
        'type' => 'required|in_list[5-18,10-40,fines,ob]',
        'to' => 'required'
    ];

    public $viewInwardDataRule = [
        'date' => 'required'
    ];

    public $viewProductionDataRule = [
        'date' => 'required',
        'type' => 'required|in_list[5-18,10-40,fines,ob]'
    ];
}
