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


namespace Pith\Framework\SharedInfrastructure\Model\UserSystem;



use Exception;
use Normalizer;
use Pith\Framework\Internal\PithReservedNameUtility;

/**
 * Class UsernameNormalizer
 * @package Pith\Framework\SharedInfrastructure\Model\UserSystem
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
     // elseif ( $given_char === 'ä'){ return ['ae'];} // German
     // elseif ( $given_char === 'ä'){ return ['ae', 'a'];} // German
        elseif ( $given_char === 'â'){ return ['a'];} // French
     // elseif ( $given_char === 'å'){ return ['aa', 'a'];}
     // elseif ( $given_char === 'å'){ return ['a'];}
        elseif ( $given_char === 'ç'){ return ['c'];} // French
        elseif ( $given_char === 'é'){ return ['e'];} // English, Spanish, French
        elseif ( $given_char === 'è'){ return ['e'];} // French
        elseif ( $given_char === 'ë'){ return ['e'];}
        elseif ( $given_char === 'ê'){ return ['e'];} // French
        elseif ( $given_char === 'í'){ return ['i'];} // Spanish
        elseif ( $given_char === 'ì'){ return ['i'];} // French
        elseif ( $given_char === 'ï'){ return ['i'];} // French
        elseif ( $given_char === 'î'){ return ['i'];} // French
     // elseif ( $given_char === 'ñ'){ return ['n', 'ny', 'nn'];} // Spanish
     // elseif ( $given_char === 'ñ'){ return ['n'];} // Spanish
        elseif ( $given_char === 'ó'){ return ['o'];} // Spanish
        elseif ( $given_char === 'ò'){ return ['o'];} // French
     // elseif ( $given_char === 'ö'){ return ['o'];} // German
     // elseif ( $given_char === 'ö'){ return ['oe', 'o'];} // German
     // elseif ( $given_char === 'ø'){ return ['oe', 'o'];}
     // elseif ( $given_char === 'ǿ'){ return ['oe', 'o'];}
        elseif ( $given_char === 'ô'){ return ['o'];} // French
     // elseif ( $given_char === 'ß'){ return ['ss', 's', 'b'];} // German
     // elseif ( $given_char === 'ß'){ return ['ss'];} // German
     // elseif ( $given_char === 'ß'){ return ['ss', 'b'];} // German
     // elseif ( $given_char === 'ß'){ return ['ss'];} // German
        elseif ( $given_char === 'ú'){ return ['u'];} // Spanish
        elseif ( $given_char === 'ù'){ return ['u'];} // French
     // elseif ( $given_char === 'ü'){ return ['u'];} // Spanish, French, German
     // elseif ( $given_char === 'ü'){ return ['ue', 'u'];} // Spanish, French, German, Hungarian
        elseif ( $given_char === 'ű'){ return ['u'];} // Hungarian
        elseif ( $given_char === 'û'){ return ['u'];} // French



        return [];
    }


    // ==============================================



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
        $name_lower = mb_strtolower($given_name);

        return $name_lower;
    }



    /**
     * @param $given_name
     * @return array
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection - Ignore shape for now.
     */
    public function doesNameFollowRules($given_name):array
    {
        // Check how the name starts and ends
        $does_follow_rules      = false;
        $reason                 = '';
        $starts_with_underscore = str_starts_with($given_name, '_');
        $starts_with_dash       = str_starts_with($given_name, '-');
        $ends_with_underscore   = str_ends_with($given_name, '_');
        $ends_with_dash         = str_ends_with($given_name, '-');
        $has_double_underscore  = str_contains($given_name, '__');
        $has_double_dash        = str_contains($given_name, '--');

        if($starts_with_underscore){
            $reason = 'starts-with-underscore';
        }
        elseif($starts_with_dash){
            $reason = 'starts-with-dash';
        }
        elseif($ends_with_underscore){
            $reason = 'ends-with-underscore';
        }
        elseif($ends_with_dash){
            $reason = 'ends-with-dash';
        }
        elseif($has_double_underscore){
            $reason = 'has-double-underscore';
        }
        elseif($has_double_dash){
            $reason = 'has-double-dash';
        }
        else{
            $does_follow_rules = true;
        }

        // Build the return
        $r = [
            'does_follow_rules' => $does_follow_rules ? 'yes' : 'no',
            'fail_reason'       => $reason,
        ];

        return $r;
    }


    /**
     * @param $given_name
     * @return array
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection - Ignore shape for now.
     */
    public function areCharsAllowed($given_name):array
    {
        // Default to false
        $are_chars_allowed = false;
        $reason            = '';

        // Split
        $chars = mb_str_split($given_name);

        $problem_char_index = -1;
        if(is_array($chars) && count($chars) > 0){
            foreach ($chars as $char_index => $char){
                $is_char_allowed = $this->isCharAllowed($char);

                if(!$is_char_allowed){
                    $problem_char_index = $char_index;
                    $reason = 'disallowed-char';
                    break;
                }
            }
            $are_chars_allowed = $problem_char_index === -1;
        }
        else{
            // empty string
            $reason = 'empty-name';
        }

        // Build the return
        $r = [
            'are_chars_allowed'  => $are_chars_allowed ? 'yes' : 'no',
            'fail_reason'        => $reason,
            'problem_char_index' => $problem_char_index,
        ];

        return $r;
    }

    /**
     * @param $given_char
     * @return bool
     */
    public function isCharAllowed($given_char): bool
    {
        $special_chars = '_';
        $is_special_char = str_contains($special_chars, $given_char);
        if($is_special_char){
            return true;
        }

        $match_01f = preg_match('/\p{Lu}|\p{Ll}|\p{Lt}|\p{Lm}|\p{Lo}|\p{Nd}|\p{Nl}/u', $given_char);
        $is_char_allowed = $match_01f === 1;
        return $is_char_allowed;
    }

    /**
     * @param $given_name
     * @return bool
     */
    public function isTooLong($given_name): bool
    {
        return strlen($given_name) > 100; // Max for DB row is 191
    }


    /**
     * @param $given_name
     * @return array
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection - Ignore shape for now
     */
    public function getNameInfo($given_name): array
    {
        // Set defaults
        $is_allowed            = false;
        $fail_reason           = '';
        $problem_char_index    = -1;
        $is_too_long           = false;
        $name_normalized       = '';
        $name_normalized_lower = '';
        $is_reserved           = false;


        // Continue on success, Stop on failure
        try{
            // Check if too long when raw
            $is_too_long = $this->isTooLong($given_name);
            if($is_too_long){
                throw new Exception('is-too-long');
            }

            // Normalize
            $name_normalized       = $this->normalizeToNfc($given_name);
            $name_normalized_lower = $this->normalizeToNfc( $this->getLowerCase($name_normalized) );

            // Check if too long when normalized
            $is_too_long = $this->isTooLong($name_normalized_lower);
            if($is_too_long){
                throw new Exception('is-too-long');
            }

            // Check rules for underscores and dashes
            $name_rule_info    = $this->doesNameFollowRules($name_normalized_lower);
            $does_follow_rules = $name_rule_info['does_follow_rules'] === 'yes';
            if(!$does_follow_rules){
                $fail_reason = $name_rule_info['fail_reason'];
                throw new Exception($fail_reason);
            }

            // Check chars
            $name_char_info    = $this->areCharsAllowed($name_normalized);
            $are_chars_allowed = $name_char_info['are_chars_allowed'] === 'yes';
            if(!$are_chars_allowed){
                $fail_reason        = $name_char_info['fail_reason'];
                $problem_char_index = $name_char_info['problem_char_index'];
                throw new Exception($fail_reason);
            }

            // Check chars (lower)
            $name_char_info    = $this->areCharsAllowed($name_normalized_lower);
            $are_chars_allowed = $name_char_info['are_chars_allowed'] === 'yes';
            if(!$are_chars_allowed){
                $fail_reason        = $name_char_info['fail_reason'];
                $problem_char_index = $name_char_info['problem_char_index'];
                throw new Exception($fail_reason);
            }

            // Check if name is reserved
            $is_inside_reserved_name_list = $this->reserved_name_utility->isInsideReservedNameList($name_normalized_lower);
            if($is_inside_reserved_name_list){
                $is_reserved = true;
                $fail_reason = 'reserved-name';
                throw new Exception($fail_reason);
            }

            // Check if name is reserved when followed by a number
            $is_reserved_with_number = $this->reserved_name_utility->isReservedWhenFollowedByNumber($name_normalized_lower);
            if($is_reserved_with_number){
                $is_reserved = true;
                $fail_reason = 'reserved-name-with-number';
                throw new Exception($fail_reason);
            }

            // Allow
            $is_allowed = true;

        }catch (Exception $e) {
            $fail_reason = $e->getMessage();
        }

        // Build return
        $r = [
            'is_too_long'           => $is_too_long ? 'yes' : 'no',
            'name_normalized'       => $name_normalized,
            'name_normalized_lower' => $name_normalized_lower,
            'is_reserved'           => $is_reserved ? 'yes' : 'no',
            'is_allowed'            => $is_allowed ? 'yes' : 'no',
            'fail_reason'           => $fail_reason,
            'problem_char_index'    => $problem_char_index,
        ];

        return $r;
    }
}