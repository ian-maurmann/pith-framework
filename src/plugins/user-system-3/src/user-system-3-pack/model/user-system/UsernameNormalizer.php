<?php
# ===================================================================
# Copyright (c) 2008-2025 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


/**
 * Username Normalizer
 * -------------------
 *
 * @noinspection PhpClassNamingConventionInspection     - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection  - Variable names with underscores are ok.
 * @noinspection PhpMethodNamingConventionInspection    - Long method names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection  - For readability.
 * @noinspection PhpMultipleClassDeclarationsInspection - Normalizer, ignore.
 */


declare(strict_types=1);


namespace Pith\Framework\Plugin\UserSystem3;

use Exception;
use Normalizer;
use Pith\Framework\Internal\PithReservedNameUtility;

/**
 * Class UsernameNormalizer
 * @package Pith\Framework\Plugin\UserSystem3
 */
class UsernameNormalizer
{
    private PithReservedNameUtility $reserved_name_utility;

    public function __construct(PithReservedNameUtility $reserved_name_utility)
    {
        // Set object dependencies
        $this->reserved_name_utility = $reserved_name_utility;
    }


    /**
     * @param string $given_username
     * @return array|bool
     */
    public function getNormalizations(string $given_username):array|bool
    {
        $given_username_lower         = mb_strtolower($given_username);
        $username_utf8_nfc_string     = normalizer_normalize($given_username_lower, Normalizer::NFC);
        $username_utf8_nfc_char_array = mb_str_split($username_utf8_nfc_string);
        $options_array                = [];

        if(is_array($username_utf8_nfc_char_array)){
            foreach ($username_utf8_nfc_char_array as $char){
                $normalized_char_options = $this->getNormalizedCharOptionsForChar($char);
                $options_array[] = $normalized_char_options;
            }
        }

        $normalized_username_array = $this->processUsernameOptionsArray($options_array);

        // Return array, [0] normalized username as string, [1]... other names to check as string
        return $normalized_username_array;
    }


    /**
     * @param $options_array
     * @return array|false
     */
    private function processUsernameOptionsArray($options_array): array|bool
    {
        $normalized_username_array = [''];

        if(is_array($options_array) && count($options_array) > 0){
            foreach ($options_array as $char_options){
                if(is_array($char_options) && count($char_options) > 0){
                    $number_of_char_options = count($char_options);
                    $normalized_username_array_copy = $normalized_username_array;
                    foreach ($normalized_username_array_copy as $name_index => $name){
                        // [0]
                        $name_plus_char = $name . $char_options[0];
                        $normalized_username_array[$name_index] = $name_plus_char;

                        // [1]
                        if($number_of_char_options > 1){
                            $name_plus_char = $name . $char_options[1];
                            $normalized_username_array[] = $name_plus_char;
                        }

                        // [2]
                        if($number_of_char_options > 2){
                            $name_plus_char = $name . $char_options[2];
                            $normalized_username_array[] = $name_plus_char;
                        }
                    }
                }
                else{
                    return false;
                }
            }
        }
        else{
            return false;
        }

        // Return array, [0] normalized username as string, [1]... other names to check as string
        return $normalized_username_array;
    }

    private function getNormalizedCharOptionsForChar(string $given_char):array
    {
        // Roman letters
        if     ( $given_char === 'a'){ return ['a'];}
        elseif ( $given_char === 'b'){ return ['b'];}
        elseif ( $given_char === 'c'){ return ['c'];}
        elseif ( $given_char === 'd'){ return ['d'];}
        elseif ( $given_char === 'e'){ return ['e'];}
        elseif ( $given_char === 'f'){ return ['f'];}
        elseif ( $given_char === 'g'){ return ['g'];}
        elseif ( $given_char === 'h'){ return ['h'];}
        elseif ( $given_char === 'i'){ return ['i'];}
        elseif ( $given_char === 'j'){ return ['j'];}
        elseif ( $given_char === 'k'){ return ['k'];}
        elseif ( $given_char === 'l'){ return ['l'];}
        elseif ( $given_char === 'm'){ return ['m'];}
        elseif ( $given_char === 'n'){ return ['n'];}
        elseif ( $given_char === 'o'){ return ['o'];}
        elseif ( $given_char === 'p'){ return ['p'];}
        elseif ( $given_char === 'q'){ return ['q'];}
        elseif ( $given_char === 'r'){ return ['r'];}
        elseif ( $given_char === 's'){ return ['s'];}
        elseif ( $given_char === 't'){ return ['t'];}
        elseif ( $given_char === 'u'){ return ['u'];}
        elseif ( $given_char === 'v'){ return ['v'];}
        elseif ( $given_char === 'w'){ return ['w'];}
        elseif ( $given_char === 'x'){ return ['x'];}
        elseif ( $given_char === 'y'){ return ['y'];}
        elseif ( $given_char === 'z'){ return ['z'];}

        // Underscore
        elseif ( $given_char === '_'){ return ['_'];}

        // Dash
        elseif ( $given_char === '-'){ return ['-'];}

        // Hindu Numbers
        elseif ( $given_char === '0'){ return ['0'];}
        elseif ( $given_char === '1'){ return ['1'];}
        elseif ( $given_char === '2'){ return ['2'];}
        elseif ( $given_char === '3'){ return ['3'];}
        elseif ( $given_char === '4'){ return ['4'];}
        elseif ( $given_char === '5'){ return ['5'];}
        elseif ( $given_char === '6'){ return ['6'];}
        elseif ( $given_char === '7'){ return ['7'];}
        elseif ( $given_char === '8'){ return ['8'];}
        elseif ( $given_char === '9'){ return ['9'];}

        // Roman Ext letters

        // AA
        elseif ( $given_char === 'å'){ return ['å', 'aa', 'a'];} // Norse

        // AE
        elseif ( $given_char === 'æ'){ return ['æ', 'ae', 'ä'];} // Norse
        elseif ( $given_char === 'ä'){ return ['ä', 'ae', 'a', 'æ'];} // German

        // NN
        elseif ( $given_char === 'ñ'){ return ['ñ'];} // Spanish

        // OE
        elseif ( $given_char === 'ö'){ return ['ö', 'oe', 'ø'];} // German
        elseif ( $given_char === 'ø'){ return ['ø', 'oe', 'ö'];} // Norse

        // SS
        elseif ( $given_char === 'ß'){ return ['ß', 'ss'];} // German

        // UE
        elseif ( $given_char === 'ü'){ return ['ü', 'ue', 'u'];} // Spanish, French, German, Hungarian

        // Diacritical letters
        elseif ( $given_char === 'ā'){ return ['a'];} // Spanish
        elseif ( $given_char === 'á'){ return ['a'];} // Spanish
        elseif ( $given_char === 'à'){ return ['a'];} // French
        elseif ( $given_char === 'â'){ return ['a'];} // French
        elseif ( $given_char === 'ç'){ return ['c'];} // French
        elseif ( $given_char === 'é'){ return ['e'];} // English, Spanish, French
        elseif ( $given_char === 'è'){ return ['e'];} // French
        elseif ( $given_char === 'ë'){ return ['e'];}
        elseif ( $given_char === 'ê'){ return ['e'];} // French
        elseif ( $given_char === 'í'){ return ['i'];} // Spanish
        elseif ( $given_char === 'ì'){ return ['i'];} // French
        elseif ( $given_char === 'ï'){ return ['i'];} // French
        elseif ( $given_char === 'î'){ return ['i'];} // French
        elseif ( $given_char === 'ó'){ return ['o'];} // Spanish
        elseif ( $given_char === 'ò'){ return ['o'];} // French
        elseif ( $given_char === 'ô'){ return ['o'];} // French
        elseif ( $given_char === 'ú'){ return ['u'];} // Spanish
        elseif ( $given_char === 'ù'){ return ['u'];} // French
        elseif ( $given_char === 'ű'){ return ['u'];} // Hungarian
        elseif ( $given_char === 'û'){ return ['u'];} // French

        return [];
    }

    /**
     * @param $given_name
     * @return string
     */
    public function normalizeToNfc($given_name):string
    {
        $utf8_nfc_string = normalizer_normalize($given_name, Normalizer::NFC);

        return $utf8_nfc_string;
    }

    /**
     * @param $given_name
     * @return string
     */
    public function getLowerCase($given_name):string
    {
        $lower_case = mb_strtolower($given_name);

        return $lower_case;
    }

    /**
     * @param $given_name
     * @return array
     */
    public function doesNameFollowRules($given_name):array
    {
        $follows_rules = true;
        $error_message = '';

        // Check if name is too long
        $is_too_long = $this->isTooLong($given_name);
        if($is_too_long){
            $follows_rules = false;
            $error_message = 'Name is too long.';
        }

        // Check if chars are allowed
        $chars_allowed_array = $this->areCharsAllowed($given_name);
        $chars_are_allowed = $chars_allowed_array['chars_are_allowed'];
        if(!$chars_are_allowed){
            $follows_rules = false;
            $error_message = 'Name contains invalid characters.';
        }

        // Check if name is reserved
        $name_is_reserved = $this->reserved_name_utility->isNameReserved($given_name);
        if($name_is_reserved){
            $follows_rules = false;
            $error_message = 'Name is reserved.';
        }

        return [
            'follows_rules'  => $follows_rules,
            'error_message' => $error_message,
        ];
    }

    /**
     * @param $given_name
     * @return array
     */
    public function areCharsAllowed($given_name):array
    {
        $chars_are_allowed = true;
        $error_message = '';

        // Get chars
        $chars = mb_str_split($given_name);

        // Check each char
        if(is_array($chars)){
            foreach ($chars as $char){
                $char_is_allowed = $this->isCharAllowed($char);
                if(!$char_is_allowed){
                    $chars_are_allowed = false;
                    $error_message = 'Invalid character: ' . $char;
                }
            }
        }

        return [
            'chars_are_allowed' => $chars_are_allowed,
            'error_message'     => $error_message,
        ];
    }

    /**
     * @param string $given_char
     * @return bool
     */
    public function isCharAllowed(string $given_char): bool
    {
        $normalized_char_options = $this->getNormalizedCharOptionsForChar($given_char);
        $char_is_allowed = is_array($normalized_char_options) && count($normalized_char_options) > 0;

        return $char_is_allowed;
    }

    /**
     * @param $given_name
     * @return bool
     */
    public function isTooLong($given_name): bool
    {
        $max_length = 32;
        $length = mb_strlen($given_name);
        $is_too_long = $length > $max_length;

        return $is_too_long;
    }

    /**
     * @param $given_name
     * @return array
     */
    public function getNameInfo($given_name): array
    {
        // Default to empty
        $name_info = [
            'name_is_valid'   => false,
            'error_message'   => '',
            'normalized_name' => '',
            'name_lower'      => '',
        ];

        // Check if name follows rules
        $name_follows_rules_array = $this->doesNameFollowRules($given_name);
        $name_follows_rules = $name_follows_rules_array['follows_rules'];
        $error_message = $name_follows_rules_array['error_message'];

        // If name follows rules
        if($name_follows_rules){
            // Get normalized name
            $normalized_name = $this->normalizeToNfc($given_name);

            // Get name lower
            $name_lower = $this->getLowerCase($normalized_name);

            // Set name info
            $name_info = [
                'name_is_valid'   => true,
                'error_message'   => '',
                'normalized_name' => $normalized_name,
                'name_lower'      => $name_lower,
            ];
        }
        // If name does not follow rules
        else{
            // Set name info
            $name_info = [
                'name_is_valid'   => false,
                'error_message'   => $error_message,
                'normalized_name' => '',
                'name_lower'      => '',
            ];
        }

        return $name_info;
    }

    /**
     * @param $given_username
     * @return string
     */
    public function getUsernameLower($given_username)
    {
        $username_lower = mb_strtolower($given_username);

        return $username_lower;
    }
} 