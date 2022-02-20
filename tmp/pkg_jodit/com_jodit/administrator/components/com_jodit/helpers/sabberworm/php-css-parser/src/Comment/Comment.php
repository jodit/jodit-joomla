<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */


namespace Sabberworm\CSS\Comment;

use Sabberworm\CSS\OutputFormat;
use Sabberworm\CSS\Renderable;

class Comment implements Renderable
{
    /**
     * @var int
     */
    protected $iLineNo;

    /**
     * @var string
     */
    protected $sComment;

    /**
     * @param string $sComment
     * @param int $iLineNo
     */
    public function __construct($sComment = '', $iLineNo = 0)
    {
        $this->sComment = $sComment;
        $this->iLineNo = $iLineNo;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->sComment;
    }

    /**
     * @return int
     */
    public function getLineNo()
    {
        return $this->iLineNo;
    }

    /**
     * @param string $sComment
     *
     * @return void
     */
    public function setComment($sComment)
    {
        $this->sComment = $sComment;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render(new OutputFormat());
    }

    /**
     * @return string
     */
    public function render(OutputFormat $oOutputFormat)
    {
        return '/*' . $this->sComment . '*/';
    }
}
