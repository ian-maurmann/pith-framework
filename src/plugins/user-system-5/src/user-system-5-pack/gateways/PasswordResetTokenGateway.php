<?php
# ===================================================================
# Copyright (c) 2008-2026 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


/**
 * Password Reset Token Gateway
 * ----------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable name are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PSR 4 not 0.
 */


declare(strict_types=1);


namespace Pith\Framework\Plugin\UserSystem5;

use Exception;
use Pith\Framework\PithPostgresWrapper;
use Pith\Framework\PithException;

/**
 * Class PasswordResetTokenGateway
 */
class PasswordResetTokenGateway
{
    private PithPostgresWrapper $database;

    public function __construct(PithPostgresWrapper $database)
    {
        $this->database = $database;
    }


    /**
     * Invalidate unused tokens for a user.
     *
     * @param int $user_id
     * @throws PithException
     */
    public function invalidateUnusedTokensForUser(int $user_id): void
    {
        $sql = '
            UPDATE pith_password_reset_tokens
            SET used_at = CURRENT_TIMESTAMP
            WHERE user_id = ?
              AND used_at IS NULL
            ';

        $this->database->query($sql, $user_id);
    }


    /**
     * @param int $user_id
     * @param string $token_hash
     * @param string $expires_at  ISO / SQL datetime string
     * @return int
     * @throws Exception
     */
    public function createToken(int $user_id, string $token_hash, string $expires_at): int
    {
        $sql = '
            INSERT INTO pith_password_reset_tokens
                (user_id, token_hash, expires_at)
            VALUES
                (:user_id, :token_hash, :expires_at)
            ';

        $statement = $this->database->pdo->prepare($sql);

        $statement->execute(
            [
                ':user_id'    => $user_id,
                ':token_hash' => $token_hash,
                ':expires_at' => $expires_at,
            ]
        );

        $inserted_id = $this->database->pdo->lastInsertId() ?: 0;
        if ($inserted_id === 0) {
            throw new Exception('Failed to insert to the password reset tokens table.');
        }

        return (int) $inserted_id;
    }


    /**
     * Find a valid (unused, non-expired) token row by hash.
     *
     * @param string $token_hash
     * @return array|null
     * @throws PithException
     */
    public function findValidTokenRowByHash(string $token_hash): ?array
    {
        $token_row = null;

        $sql = '
            SELECT
                *
            FROM
                pith_password_reset_tokens
            WHERE
                token_hash = ?
                AND used_at IS NULL
                AND expires_at > CURRENT_TIMESTAMP
            LIMIT 1
            ';

        $results = $this->database->query($sql, $token_hash);

        $has_results = is_array($results) && (count($results) > 0);
        if ($has_results) {
            $token_row = $results[0];
        }

        return $token_row;
    }


    /**
     * Mark a token as used.
     *
     * @param int $token_id
     * @throws PithException
     */
    public function markTokenUsed(int $token_id): void
    {
        $sql = '
            UPDATE pith_password_reset_tokens
            SET used_at = CURRENT_TIMESTAMP
            WHERE token_id = ?
            ';

        $this->database->query($sql, $token_id);
    }
}
