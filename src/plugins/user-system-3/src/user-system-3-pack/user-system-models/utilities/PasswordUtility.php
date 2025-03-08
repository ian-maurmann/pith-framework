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
 * Password Utility
 * ----------------
 *
 * @noinspection PhpClassNamingConventionInspection     - Long class name is ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection  - Ignore for readability.
 * @noinspection PhpVariableNamingConventionInspection  - Long variable names are ok.
 * @noinspection PhpMultipleClassDeclarationsInspection - Normalizer, ignore.
 */


declare(strict_types=1);


namespace Pith\Framework\Plugin\UserSystem3;

use Normalizer;

/**
 * Class PasswordUtility
 */
class PasswordUtility
{

    /**
     * @param string $raw_password
     * @return string
     */
    public function getPasswordHash(string $raw_password): string
    {
        $password_utf8_nfc = normalizer_normalize($raw_password, Normalizer::NFC);
        $password_hash     = password_hash($password_utf8_nfc, PASSWORD_DEFAULT);

        return $password_hash;
    }
}