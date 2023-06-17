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

use Exception;
use Pith\Framework\PithException;

/**
 * Class UserService
 * @package Pith\Framework\SharedInfrastructure\Model\UserSystem
 */
class UserService
{
    private UsernameNormalizer      $username_normalizer;
    private UsernameGateway         $username_gateway;

    public function __construct(UsernameGateway $username_gateway, UsernameNormalizer $username_normalizer)
    {
        // Set object dependencies
        $this->username_normalizer = $username_normalizer;
        $this->username_gateway    = $username_gateway;
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

    /**
     * @param $given_email_address
     * @return array
     */
    public function spotcheckNewUserEmailAddress($given_email_address): array
    {
        $is_ok       = true;
        $fail_reason = '';

        // Continue on success, Stop on failure
        try{
            if(empty($given_email_address)){
                throw new Exception('email-address-is-empty');
            }

            $email_address_char_length = mb_strlen($given_email_address);
            $at_sign_position          = mb_strpos($given_email_address, '@');

            $has_at_sign = $at_sign_position !== false;
            if(!$has_at_sign){
                throw new Exception('email-address-does-not-have-at-sign');
            }

            $is_at_sign_at_start = $at_sign_position === 0;
            if($is_at_sign_at_start){
                throw new Exception('email-address-does-not-have-name');
            }

            $is_at_sign_too_late = !(($email_address_char_length - 3) > $at_sign_position);
            if($is_at_sign_too_late){
                throw new Exception('email-address-does-not-have-domain');
            }

            $domain             = mb_substr($given_email_address,$at_sign_position + 1);
            $domain_char_length = mb_strlen($domain);
            $dot_position       = mb_strpos($domain, '.');

            $has_dot = $dot_position !== false;
            if(!$has_dot){
                throw new Exception('email-address-domain-does-not-have-dot');
            }

            $is_dot_at_start = $dot_position === 0;
            if($is_dot_at_start){
                throw new Exception('email-address-dot-is-at-start-of-domain');
            }

            $is_at_first_dot_at_end = !(($domain_char_length - 1) > $dot_position);
            if($is_at_first_dot_at_end){
                throw new Exception('email-address-first-dot-in-domain-is-at-the-end');
            }
        }catch (Exception $e) {
            $is_ok       = false;
            $fail_reason = $e->getMessage();
        }

        // Build the response
        $response = [
            'email_address' => $given_email_address,
            'is_allowed'    => $is_ok ? 'yes' : 'no',
            'fail_reason'   => $fail_reason,
        ];

        return $response;
    }


}