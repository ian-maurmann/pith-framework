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
 * Pith Registry
 * -------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
 */


declare(strict_types=1);


namespace Pith\Framework;

/**
 * Class PithRegistry
 * @package Pith\Framework
 */
class PithRegistry
{
    public string $access_level_note     = '';
    public string $requested_uri         = '';
    public string $requested_http_method = '';

    private array $runtime_notes;


    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * @return string
     */
    public function getRequestedUri(): string
    {
        return $this->requested_uri;
    }


    /** @noinspection PhpPureAttributeCanBeAddedInspection - Ignore pure for now, add later */
    public function getRuntimeNote(string $note_name): string
    {
        $has_note = $this->hasRuntimeNote($note_name);

        $note = $has_note ? (string) $this->runtime_notes[$note_name] : '';

        return $note;
    }

    public function hasRuntimeNote(string $note_name): bool
    {
        return array_key_exists($note_name, $this->runtime_notes);
    }

    public function setRuntimeNote(string $note_name, string $note_message)
    {
        $this->runtime_notes[$note_name] = $note_message;
    }

    public function setRuntimeNoteOnce(string $note_name, string $note_message)
    {
        $has_note = $this->hasRuntimeNote($note_name);
        
        if(!$has_note){
            $this->setRuntimeNote($note_name, $note_message);
        }
    }

}