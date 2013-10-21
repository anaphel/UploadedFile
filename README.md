UploadedFile
=============

This class is meant to be used with files from $_FILES.

How to use it
-------------------------

Let's see an example :

```php
$file = UploadedFile($name, $type, $tmp_name, $error, $size);
echo $file->getSize(UploadedFile::SIZE_KO) . '<br>';
if ($file->hasError()) {
    echo $file->getErrorMessage() . '<br>';
}
echo $file->getExtension() . '<br>';
echo $file->getType() . '<br>';
$file->move('/var/www/myapp/media/');
```
