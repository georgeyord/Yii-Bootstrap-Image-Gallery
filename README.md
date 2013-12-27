Yii-Bootstrap-Image-Gallery
===========================

## Description
Yii widget implementation of Blueimp Bootstrap Image Gallery

## Setup

Autoload component:
```php
    // autoloading model and component classes
    'import' => array(
        'application.lib.Yii-Bootstrap-Image-Gallery.BlueimpGallery',
    ),
```

## Usage
Use it as follows:
```php
// Initialize BlueimpGallery
$bsGallery = $this->createWidget('BlueimpGallery');

// Create items
$items = array(
    'http://farm6.static.flickr.com/5517/11544027365_0d0490a5a0_b.jpg',
    'http://farm6.static.flickr.com/5520/11548707806_3f26f8b155_b.jpg'
);

// Create a Gallery
$bsGallery->run($items, array('type' => BlueimpGallery::TYPE_INLINE));
```

Check [demoView.php](demoView.php) to check full features. To create a working example

## References and many thanks to
[blueimp Gallery Demo](http://blueimp.github.io/Gallery/)
[Bootstrap Image Gallery Demo](http://blueimp.github.io/Bootstrap-Image-Gallery/)
