<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */


namespace Sabberworm\CSS\Value;

class RuleValueList extends ValueList
{
    /**
     * @param string $sSeparator
     * @param int $iLineNo
     */
    public function __construct($sSeparator = ',', $iLineNo = 0)
    {
        parent::__construct([], $sSeparator, $iLineNo);
    }
}
