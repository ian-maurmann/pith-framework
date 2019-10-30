<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith Adapter for .phtml views
// -----------------------------

namespace Pith\Framework\Adapter\Phtml;


class PithAdapterForPhtml
{
    protected $full_path_to_phtml_view;
    protected $object_with_variables_for_phtml_view;

    function __construct()
    {
        // Do nothing
    }

    public function setFilePath($full_path_to_phtml_view)
    {
        $this->full_path_to_phtml_view = $full_path_to_phtml_view;
    }


    public function setVars($view_variables)
    {
        $this->object_with_variables_for_phtml_view = $view_variables;
    }

    public function run()
    {
        // Set vars:
        extract( (array) $this->object_with_variables_for_phtml_view );

        // Include the view:
        require $this->full_path_to_phtml_view;
    }
}