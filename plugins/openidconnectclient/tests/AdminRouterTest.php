<?php

/**
 * Copyright (c) Enalean, 2016. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

require_once('bootstrap.php');

use Tuleap\OpenIDConnectClient\AdminRouter;

class AdminRouterTest extends TuleapTestCase {

    private $existing_response;

    public function setUp() {
        parent::setUp();
        $this->existing_response = $GLOBALS['Response'];
        $GLOBALS['Response']     = mock('Layout');
    }

    public function tearDown() {
        $GLOBALS['Response'] = $this->existing_response;
        parent::tearDown();
    }

    public function itIsOnlyAccessibleBySuperUser() {
        $controller = mock('Tuleap\OpenIDConnectClient\Administration\Controller');
        $csrf_token = mock('CSRFSynchronizerToken');
        $user       = mock('PFUser');
        $user->setReturnValue('isSuperUser', false);
        $request    = mock('HTTPRequest');
        $request->setReturnValue('getCurrentUser', $user);

        $GLOBALS['Response']->expectOnce('redirect');

        $router = new AdminRouter($controller, $csrf_token);
        $router->route($request);
    }

}