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



use Normalizer;

/**
 * Class UsernameNormalizer
 * @package Pith\Framework\SharedInfrastructure\Model\UserSystem
 */
class UsernameNormalizer
{
    public function __construct()
    {
        // Do nothing for now.
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

        // Diacritical letters
        elseif ( $given_char === 'ā'){ return ['a'];} // Spanish
        elseif ( $given_char === 'á'){ return ['a'];} // Spanish
        elseif ( $given_char === 'à'){ return ['a'];} // French
     // elseif ( $given_char === 'ä'){ return ['ae'];} // German
        elseif ( $given_char === 'ä'){ return ['ae', 'a'];} // German
        elseif ( $given_char === 'â'){ return ['a'];} // French
        elseif ( $given_char === 'å'){ return ['aa', 'a'];}
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
        elseif ( $given_char === 'ñ'){ return ['n', 'ny'];} // Spanish
     // elseif ( $given_char === 'ñ'){ return ['n'];} // Spanish
        elseif ( $given_char === 'ó'){ return ['o'];} // Spanish
        elseif ( $given_char === 'ò'){ return ['o'];} // French
     // elseif ( $given_char === 'ö'){ return ['o'];} // German
        elseif ( $given_char === 'ö'){ return ['oe', 'o'];} // German
        elseif ( $given_char === 'ø'){ return ['oe', 'o'];}
        elseif ( $given_char === 'ǿ'){ return ['oe', 'o'];}
        elseif ( $given_char === 'ô'){ return ['o'];} // French
     // elseif ( $given_char === 'ß'){ return ['ss', 's', 'b'];} // German
     // elseif ( $given_char === 'ß'){ return ['ss'];} // German
        elseif ( $given_char === 'ß'){ return ['ss', 'b'];} // German
        elseif ( $given_char === 'ú'){ return ['u'];} // Spanish
        elseif ( $given_char === 'ù'){ return ['u'];} // French
     // elseif ( $given_char === 'ü'){ return ['u'];} // Spanish, French, German
        elseif ( $given_char === 'ü'){ return ['ue', 'u'];} // Spanish, French, German, Hungarian
        elseif ( $given_char === 'ű'){ return ['u'];} // Hungarian
        elseif ( $given_char === 'û'){ return ['u'];} // French

        return [];
    }
}