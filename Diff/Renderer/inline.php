<?php
/**
 * "Inline" diff renderer.
 *
 * This class renders diffs in the Wiki-style "inline" format.
 *
 * $Horde: framework/Text_Diff/Diff/Renderer/inline.php,v 1.5 2005/03/07 14:58:30 jan Exp $
 *
 * @author  Ciprian Popovici
 * @package Text_Diff
 */
class Text_Diff_Renderer_inline extends Text_Diff_Renderer {

    /**
     * Number of leading context "lines" to preserve.
     */
    var $_leading_context_lines = 10000;

    /**
     * Number of trailing context "lines" to preserve.
     */
    var $_trailing_context_lines = 10000;

    /**
     * Prefix for inserted text.
     */
    var $_ins_prefix = '<ins>';

    /**
     * Suffix for inserted text.
     */
    var $_ins_suffix = '</ins>';

    /**
     * Prefix for deleted text.
     */
    var $_del_prefix = '<del>';

    /**
     * Suffix for deleted text.
     */
    var $_del_suffix = '</del>';

    /**
     * Header for each change block.
     */
    var $_block_header = '';

    /**
     * What are we currently splitting on? Used to recurse to show word-level
     * changes.
     */
    var $_split_level = 'lines';

    function _lines($lines, $prefix = ' ')
    {
        if ($this->_split_level == 'words') {
            return implode($lines, ' ');
        } else {
            return implode($lines, "\n") . "\n";
        }
    }

    function _blockHeader($xbeg, $xlen, $ybeg, $ylen)
    {
        return $this->_block_header;
    }

    function _startBlock($header)
    {
        return $header;
    }

    function _added($lines)
    {
        array_unshift($lines, $this->_ins_prefix);
        array_push($lines, $this->_ins_suffix);
        return $this->_lines($lines);
    }

    function _deleted($lines)
    {
        array_unshift($lines, $this->_del_prefix);
        array_push($lines, $this->_del_suffix);
        return $this->_lines($lines);
    }

    function _changed($orig, $final)
    {
        /* If we've already split on words, don't try to do so again - just
         * display. */
        if ($this->_split_level == 'words') {
            return $this->_deleted($orig) . $this->_added($final) . "\n";
        }

        $text1 = implode("\n", $orig);
        $text2 = implode("\n", $final);

        /* Pad to make sure we can split on word boundaries. */
        $text1 = str_replace("\n", " \n", $text1);
        $text2 = str_replace("\n", " \n", $text2);

        /* Non-printing newline marker. */
        $nl = "\0";

        /* Save newlines. */
        $text1 = str_replace("\n", $nl, $text1);
        $text2 = str_replace("\n", $nl, $text2);

        /* Create the diff, splitting on word boundaries (loosely defined as
         * spaces). */
        $diff = &new Text_Diff(explode(' ', $text1),
                               explode(' ', $text2));

        /* Get the diff in inline format.
         * FIXME: should propogate other parameters here too. */
        $renderer = &new Text_Diff_Renderer_inline(array('split_level' => 'words'));

        /* Run the diff and get the output. */
        return str_replace($nl, "\n", $renderer->render($diff));
    }

}
