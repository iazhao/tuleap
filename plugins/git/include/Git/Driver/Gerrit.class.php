<?php

/**
 * Copyright (c) Enalean, 2012. All Rights Reserved.
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

require_once dirname(__FILE__) .'/Gerrit/RemoteSSHCommand.class.php';

class Git_Driver_Gerrit {

    const GERRIT_COMMAND = 'gerrit ';

    /**
     * @var Git_Driver_Gerrit_RemoteSSHCommand
     */
    private $ssh;

    public function __construct(Git_Driver_Gerrit_RemoteSSHCommand $ssh) {
        $this->ssh = $ssh;
    }

    public function createProject(GerritServer $server, GitRepository $repository) {
        $host    = Config::get('sys_default_domain');
        $project = $repository->getProject()->getUnixName();
        $repo    = $repository->getFullName();
        $this->ssh->execute(self::GERRIT_COMMAND ."create-project $host-$project/$repo");
    }
}

class GerritServer {

    function __construct() {
        
    }

}
class GerritServerFactory {

    function __construct() {
        
    }
    
    public function getServer(GitRepository $repository) {
        
    }

}
?>
