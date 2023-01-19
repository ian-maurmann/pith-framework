<?php

# ===================================================================
# Copyright (c) 2008-2023 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


/**
 * Pith Error Utility
 * ------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Long property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
 * @noinspection PhpPureAttributeCanBeAddedInspection  - Ignore Pure for now, functions are still being modified, and might not stay pure.
 */


declare(strict_types=1);


namespace Pith\Framework\Internal;


/**
 * Class PithErrorUtility
 * @package Pith\Framework\Internal
 */
class PithErrorUtility
{
    private PithRowsetArrayUtility $rowset_array_utility;


    public function __construct(PithRowsetArrayUtility $rowset_array_utility)
    {
        // Objects
        $this->rowset_array_utility = $rowset_array_utility;
    }


    /**
     * @return array[]
     */
    public function getArrayOfPhpErrorTypes(): array
    {
        $php_error_types = [
            ['value' => 1,     'constant' => 'E_ERROR',             'type' => 'Error'               ],
            ['value' => 2,     'constant' => 'E_WARNING',           'type' => 'Warning'             ],
            ['value' => 4,     'constant' => 'E_PARSE',             'type' => 'Parse error'         ],
            ['value' => 8,     'constant' => 'E_NOTICE',            'type' => 'Notice'              ],
            ['value' => 16,    'constant' => 'E_CORE_ERROR',        'type' => 'Core Error'          ],
            ['value' => 32,    'constant' => 'E_CORE_WARNING',      'type' => 'Core Warning'        ],
            ['value' => 64,    'constant' => 'E_COMPILE_ERROR',     'type' => 'Compile Error'       ],
            ['value' => 128,   'constant' => 'E_COMPILE_WARNING',   'type' => 'Compile Warning'     ],
            ['value' => 256,   'constant' => 'E_USER_ERROR',        'type' => 'Triggered Error'     ],
            ['value' => 512,   'constant' => 'E_USER_WARNING',      'type' => 'Triggered Warning'   ],
            ['value' => 1024,  'constant' => 'E_USER_NOTICE',       'type' => 'Triggered Notice'    ],
            ['value' => 2048,  'constant' => 'E_STRICT',            'type' => 'Strict Types'        ],
            ['value' => 4096,  'constant' => 'E_RECOVERABLE_ERROR', 'type' => 'Recoverable Error'   ],
            ['value' => 8192,  'constant' => 'E_DEPRECATED',        'type' => 'Deprecated'          ],
            ['value' => 16384, 'constant' => 'E_USER_DEPRECATED',   'type' => 'Triggered Deprecated'],
            ['value' => 32767, 'constant' => 'E_ALL',               'type' => 'All'                 ],
        ];

        return $php_error_types;
    }


    /**
     * @param $value
     * @return array|null
     */
    public function getErrorTypeByValue($value): ?array
    {
        $error_type       = null;
        $error_info_array = $this->getArrayOfPhpErrorTypes();
        $error            = $this->rowset_array_utility->getRowByFieldValue($error_info_array, 'value', $value);

        if($error){
            $error_type = $error['type'];
        }

        return $error_type;
    }


}