<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */


namespace Sabberworm\CSS;

interface Renderable
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function render(OutputFormat $oOutputFormat);

    /**
     * @return int
     */
    public function getLineNo();
}
