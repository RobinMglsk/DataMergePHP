# DataMergePHP <small> - Personalize your strings</small>

Great for giving you users an easy way to personalize there mails / text messages with tags. More features then ``str_ireplace``.

## Usages

## Tag options
* `{{ tag }}` - default tag
* `{{ ucwords(tag) }}` - Change first character of every word to uppercase
* `{{ ucfirst(tag) }}` - Change first character of string to uppercase
* `{{ strtolower(tag) }}` - Convert string to lowercase
* `{{ strtoupper(tag) }}` - Convert string to uppercase
* `{{ date( tag, format )}}` - Convert timestamp to string, for format you can use http://php.net/manual/en/function.date.php

You can use `||` inside your tag to define a default value. Example: `{{ tag || client }}` If the value of tag is empty client wil be used.

## Examples
Check out our exampels in the example folder.
