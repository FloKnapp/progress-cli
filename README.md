# progress-cli
A simple progress bar for the php cli

# Install
composer require floknapp/progress-cli

# How to use
```php

$dataset = ['entry1', 'entry2', ...]; // everything that is countable

$progress = new Progress($dataset); // default progress bar width is 40 chars

for ($i=0; $i < count($dataset); $i++) { // yea yea, i know... no count in for parameters
    
    [... do things]
    
    $progress->update($i);
    
}
```
That's it!

# Further configuration

You can set a custom width:
```php
$progress = new Progress($dataset, 80); // set progress bar width to 80 chars
```

You can show a summary behind the progress bar:
```php
$progress = new Progress($dataset, 80, true); // [---------] 100% (250/250)
```

You can set custom start and end surroundings:
```php
$progress = new Progress($dataset);
$progress->setProgressLimiter('(', ')'); // results in (---------) 100%
```

You can set a custom progress char (currently only 1 byte chars, no enhanced utf-8 chars supported):
```php
$progress = new Progress($dataset);
$progress->setProgressChar('|'); // results in [||||||||||||] 100%
```
