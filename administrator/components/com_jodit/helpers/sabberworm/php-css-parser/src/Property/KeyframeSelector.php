<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */


namespace Sabberworm\CSS\Property;

class KeyframeSelector extends Selector
{
    /**
     * regexp for specificity calculations
     *
     * @var string
     */
    const SELECTOR_VALIDATION_RX = '/
    ^(
        (?:
            [a-zA-Z0-9\x{00A0}-\x{FFFF}_^$|*="\'~\[\]()\-\s\.:#+>]* # any sequence of valid unescaped characters
            (?:\\\\.)?                                              # a single escaped character
            (?:([\'"]).*?(?<!\\\\)\2)?                              # a quoted text like [id="example"]
        )*
    )|
    (\d+%)                                                          # keyframe animation progress percentage (e.g. 50%)
    $
    /ux';
}
