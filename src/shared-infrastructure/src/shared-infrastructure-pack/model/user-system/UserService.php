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
 * @noinspection PhpPropertyNamingConventionInspection - Long property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
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
        // Object Dependencies
        $this->reserved_name_utility = $reserved_name_utility;
        $this->username_normalizer   = $username_normalizer;
        $this->username_gateway      = $username_gateway;
    }


    /**
     * @param $given_username
     * @return array
     */
    public function getUsernameNormalizationMatches($given_username): array
    {
        $matches = [];

        try {
            $normalizations = $this->username_normalizer->getNormalizations($given_username);

            if(is_array($normalizations)){
                foreach($normalizations as $normalization){
                    $match = [];
                    $row   = $this->username_gateway->getUsernameRowByNormalizedUsername($normalization);

                    $match['name']      = $normalization;
                    $match['found_row'] = $row;

                    // Add match to matches
                    $matches[] = $match;
                }
            }
        } catch (PithException $e) {
            // TODO - Log exception
        }

        return $matches;
    }

    /**
     * @param $given_username
     * @return array
     *
     * @noinspection PhpUndefinedVariableInspection - Ignore, the logic is fine here.
     */
    public function getUsernameAvailability($given_username): array
    {
        try {
            // Default to false
            $is_available = false;
            $has_matches  = false;
            $reason       = '';

            // Check if name is number
            $is_numeric = is_numeric($given_username);

            // Check how the name starts and ends
            $starts_with_underscore = str_starts_with($given_username, '_');
            $starts_with_dash       = str_starts_with($given_username, '-');
            $ends_with_underscore   = str_ends_with($given_username, '_');
            $ends_with_dash         = str_ends_with($given_username, '-');
            $has_double_underscore  = str_contains($given_username, '__');

            $has_format = !$is_numeric && !$starts_with_underscore && !$starts_with_dash && !$ends_with_underscore && !$ends_with_dash && !$has_double_underscore;

            if($has_format){
                $matches     = $this->getUsernameNormalizationMatches($given_username);
                $has_matches = is_array($matches) && count($matches) > 0;
            }
            else{
                $reason = 'incorrect-format';
            }

            // Check if name is free
            if($has_matches){
                $is_available = true;
                foreach ($matches as $match){
                    $row      = $match['found_row'];
                    $is_empty = empty($row);

                    if(!$is_empty){
                        $is_available = false;
                        $reason = 'name-unavailable';
                        break;
                    }
                }
            }

            // Check if name is reserved
            if($is_available){
                $is_raw_name_reserved = $this->reserved_name_utility->isReserved($given_username);
                $normalized_name = $matches[0]['name'];
                $is_normalized_name_reserved = $this->reserved_name_utility->isReserved($normalized_name);
                $is_reserved = $is_raw_name_reserved || $is_normalized_name_reserved;
                if($is_reserved){
                    $is_available = false;
                    $reason = 'name-reserved';
                }
            }
        } catch (PithException $e) {
            $is_available = false;
        }

        $r = [
            'is_available' => $is_available,
            'reason'       => $reason,
        ];

        return $r;
    }
}