<?php
/**
 * Copyright (c) Enalean, 2017. All Rights Reserved.
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
 * along with Tuleap; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

namespace Tuleap\Tracker\Report\Query\Advanced\InvalidFields;

use Tracker_FormElement_Field;
use Tuleap\Tracker\Report\Query\Advanced\Grammar\Comparison;

class IntegerFieldBetweenValueChecker implements InvalidFieldChecker
{
    public function checkFieldIsValidForComparison(Comparison $comparison, Tracker_FormElement_Field $field)
    {
        $min_value = $comparison->getValueWrapper()->getMinValue();
        $max_value = $comparison->getValueWrapper()->getMaxValue();

        $this->checkFieldIsNotFloat($field, $min_value);
        $this->checkFieldIsNotFloat($field, $max_value);

        $this->checkFieldIsNumeric($field, $min_value);
        $this->checkFieldIsNumeric($field, $max_value);
    }

    private function checkFieldIsNotFloat(Tracker_FormElement_Field $field, $value)
    {
        if (is_float($value + 0)) {
            throw new IntegerToFloatComparisonException($field, $value);
        }
    }

    private function checkFieldIsNumeric(Tracker_FormElement_Field $field, $value)
    {
        if (! is_numeric($value)) {
            throw new IntegerToStringComparisonException($field, $value);
        }
    }
}
