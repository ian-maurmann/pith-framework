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
 * User Service
 * ------------
 *
 * @noinspection PhpPropertyNamingConventionInspection      - Long property names are ok.
 * @noinspection PhpMethodNamingConventionInspection        - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection      - Short variable names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection      - Ignore for readability.
 * @noinspection PhpArrayShapeAttributeCanBeAddedInspection - Ignore shape for now, add later.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\UserSystem;

use Pith\Framework\Internal\PithReservedNameUtility;
use Pith\Framework\PithException;

/**
 * Class UserService
 * @package Pith\Framework\SharedInfrastructure\Model\UserSystem
 */
class UserService
{
    private PithReservedNameUtility $reserved_name_utility;
    private UsernameNormalizer      $username_normalizer;
    private UsernameGateway         $username_gateway;

    public function __construct(PithReservedNameUtility $reserved_name_utility, UsernameGateway $username_gateway, UsernameNormalizer $username_normalizer)
    {
        // Set object dependencies
        $this->reserved_name_utility = $reserved_name_utility;
        $this->username_normalizer   = $username_normalizer;
        $this->username_gateway      = $username_gateway;
    }

    /**
     * @param $given_name
     * @return array
     */
    public function getUsernameAvailability($given_name): array
    {
        $is_available = false;
        $name_info    = $this->username_normalizer->getNameInfo($given_name);
        $is_allowed   = $name_info['is_allowed'] === 'yes';
        $fail_reason  = $name_info['fail_reason'];

        if($is_allowed){
            $name             = $name_info['name_normalized'];
            $name_lower       = $name_info['name_normalized_lower'];
            try{
                $name_results     = $this->username_gateway->findUsernameResults($name, $name_lower);
                $has_name_results = count($name_results) > 0;
                $fail_reason      = $has_name_results ? 'username-unavailable' : $fail_reason;
                $is_available     = !$has_name_results;
            } catch (PithException $pith_exception){
                $is_available = false;
                $fail_reason  = 'database-query-exception';
            }

        }

        // Build return
        $r = [
            'is_too_long'           => $name_info['is_too_long'],
            'name_normalized'       => $name_info['name_normalized'],
            'name_normalized_lower' => $name_info['name_normalized_lower'],
            'is_reserved'           => $name_info['is_reserved'],
            'problem_char_index'    => $name_info['problem_char_index'],
            'is_allowed'            => $name_info['is_allowed'],
            'is_available'          => $is_available ? 'yes' : 'no',
            'fail_reason'           => $fail_reason,
        ];

        return $r;
    }


}