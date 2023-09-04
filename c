git commit -m 'Fix Deprecated: Creation of dynamic property + loops for $matches

Fixes (PHP7.4.X): Deprecated: Creation of dynamic property Text_Diff_Engine_native::$xchanged is deprecated .../yii\framework\gii\components\Pear\Text\Diff\Engine\native.php on line 41

Copied from https://github.com/WordPress/WordPress/blob/master/wp-includes/Text/Diff/Engine/native.php.
Similar fix as https://github.com/mdeweerd/yii/blob/mdw/framework/gii/components/Pear/Text/Diff/Engine/native.php#L32-L40 .

Also copied extra fix replacing loop over list().

Applied `phpcbf --standard=PEAR native.php` resulting in some code formatting changes.
'
