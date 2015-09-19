#!/usr/bin/php
<?php
/**
 * Text_Diff example script.
 *
 * Take two files from the command line args and produce a unified
 * diff of them.
 *
 * @package Text_Diff
 */

/** Text_Diff */
if (!class_exists('Text_Diff')) {
    require_once 'Text/Diff.php';
}

/** Text_Diff_Renderer */
if (!class_exists('Text_Diff_Renderer')) {
    require_once 'Text/Diff/Renderer.php';
}

/** Text_Diff_Renderer_unified */
if (!class_exists('Text_Diff_Renderer_unified')) {
    require_once 'Text/Diff/Renderer/unified.php';
}

/* Make sure we have enough arguments. */
if (count($argv) < 3) {
    echo "Usage: diff.php <file1> <file2>\n\n";
    exit;
}

/* Make sure both files exist. */
if (!is_readable($argv[1])) {
    echo "$argv[1] not found or not readable.\n\n";
}
if (!is_readable($argv[2])) {
    echo "$argv[2] not found or not readable.\n\n";
}

/* Load the lines of each file. */
$lines1 = file($argv[1]);
$lines2 = file($argv[2]);

/* Create the Diff object. */
$diff = new Text_Diff('auto', array($lines1, $lines2));

/* Output the diff in unified format. */
$renderer = new Text_Diff_Renderer_unified();
echo $renderer->render($diff);
