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

MultiUpload
-------------------------

Let's see how to use it with array_column :

```html
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="documents[]" multiple>
    <input type="submit" value="Envoyer">
</form>
```

```php
$i = 0;
$documents = array();
while (!empty(array_column($_FILES['documents'], $i))) {
    list($name, $type, $tmp_name, $error, $size) = array_column($_FILES['documents'], $i);
    $documents[] = new UploadedFile($name, $type, $tmp_name, $error, $size);
    $i++;
}
```