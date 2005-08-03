--TEST--
Text_Diff: PEAR Bug #4982 (wrong line breaks with inline renderer)
--FILE--
<?php
include_once 'Text/Diff.php';
include_once 'Text/Diff/Renderer.php';
include_once 'Text/Diff/Renderer/inline.php';

$oldtext = <<<EOT
This line is the same.
This line is different in 1.txt
This line is the same.
This is gone away !!
EOT;

$newtext = <<< EOT
This line is the same.
This is new !!
This line is different in 2.txt
This line is the same.
EOT;

$oldpieces = explode ("\n", $oldtext);
$newpieces = explode ("\n", $newtext);
$diff = &new Text_Diff ($oldpieces, $newpieces);

$renderer = &new Text_Diff_Renderer_inline();
echo $renderer->render($diff);
?>
--EXPECT--
This line is the same.
<ins>This is new !!</ins>
This line is different in <del>1.txt</del><ins>2.txt</ins>
This line is the same.
<del>This is gone away !!</del>
