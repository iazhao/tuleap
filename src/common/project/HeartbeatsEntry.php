<?php
/**
 * Copyright (c) Enalean, 2017. All Rights Reserved.
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

namespace Tuleap\Project;

use PFUser;

class HeartbeatsEntry
{
    /**
     * @var int
     */
    private $updated_at;
    /**
     * @var string
     */
    private $xref;
    /**
     * @var string
     */
    private $link;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $color;
    /**
     * @var string
     */
    private $icon;

    public function __construct($updated_at, $xref, $link, $title, $color, $icon)
    {
        $this->updated_at = (int)$updated_at;
        $this->xref       = $xref;
        $this->link       = $link;
        $this->title      = $title;
        $this->color      = $color;
        $this->icon       = $icon;
    }

    /**
     * @return int
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return string
     */
    public function getXref()
    {
        return $this->xref;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }
}
