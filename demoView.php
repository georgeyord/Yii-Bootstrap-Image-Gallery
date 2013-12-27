<?php

// Initialize BlueimpGallery
$bsGallery = $this->createWidget('BlueimpGallery');

// Create many and different items
$items = array();

// IMAGES
//
// The simpler type of item is a url of an image
$items[] = 'http://farm6.static.flickr.com/5517/11544027365_0d0490a5a0_b.jpg';
// You get the same result if you call the following
$items[] = BlueimpGallery::image('http://farm8.static.flickr.com/7409/11547742763_3fa0e10176_b.jpg');
// And the same result if you call the following
$items[] = BlueimpGallery::image(array(
            'href' => 'http://farm6.static.flickr.com/5520/11548707806_3f26f8b155_b.jpg',
        ));
// Lets add a title
$items[] = BlueimpGallery::image(array(
            'title' => 'Temple',
            'href' => 'http://farm6.static.flickr.com/5520/11548707806_3f26f8b155_b.jpg',
        ));
// Lets add a title and a thumbnail
$items[] = BlueimpGallery::image(array(
            'title' => 'See waves',
            'href' => 'http://farm3.static.flickr.com/2886/11563671616_a3a37f9776_b.jpg',
            'thumb' => 'http://farm3.static.flickr.com/2886/11563671616_a3a37f9776_s.jpg',
        ));

// HTML5 VIDEOS
//
// The simple call for a HTML5 video
$items[] = BlueimpGallery::video('http://vjs.zencdn.net/v/oceans.mp4');
// Lets add a title and a poster image
$items[] = BlueimpGallery::video(array(
            'title' => 'Oceans',
            'href' => 'http://vjs.zencdn.net/v/oceans.mp4',
            'poster' => 'http://www.videojs.com/img/poster.jpg'
        ));
// A full example for an HTML5 ogg video
$items[] = BlueimpGallery::video(array(
            'title' => 'Big Buck Bunny',
            'href' => 'http://upload.wikimedia.org/wikipedia/commons/7/75/' .
            'Big_Buck_Bunny_Trailer_400p.ogg',
            'type' => 'video/ogg',
            'poster' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/7/70/' .
            'Big.Buck.Bunny.-.Opening.Screen.png/' .
            '800px-Big.Buck.Bunny.-.Opening.Screen.png'
        ));
// A full example for an HTML5 webm video
$items[] = BlueimpGallery::video(array(
            'title' => 'Elephants Dream',
            'href' => 'http://upload.wikimedia.org/wikipedia/commons/transcoded/8/83/' .
            'Elephants_Dream_%28high_quality%29.ogv/' .
            'Elephants_Dream_%28high_quality%29.ogv.360p.webm',
            'type' => 'video/webm',
            'poster' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/9/90/' .
            'Elephants_Dream_s1_proog.jpg/800px-Elephants_Dream_s1_proog.jpg'
        ));

// YOUTUBE VIDEOS
//
// The simple call for a YouTube video
$items[] = BlueimpGallery::youtube('vmOArLdg9d4');
$items[] = BlueimpGallery::youtube('zi4CIXpx7Bg');
// Lets add a title
$items[] = BlueimpGallery::youtube(array(
            'title' => 'The Best Of Electro Swing!',
            'youtube' => 'pQDR83AN75U',
        ));
// Lets add a title and change the poster image
$items[] = BlueimpGallery::youtube(array(
            'title' => 'The Best Of Electro Swing!',
            'youtube' => 'pQDR83AN75U',
            'poster' => 'https://lh5.googleusercontent.com/-ywAHmjL0ClY/AAAAAAAAAAI/AAAAAAAAAAA/yj8QtmQixp4/s48-c-k-no/photo.jpg',
        ));

// VIMEO VIDEOS
//
// The simple call for a Vimeo video
$items[] = BlueimpGallery::vimeo('81902814');
// Lets change a title
$items[] = BlueimpGallery::vimeo(array(
            'title' => 'Last Moon',
            'vimeo' => '73686146',
        ));

// CREATE INLINE
// Create a Gallery
$bsGallery->run($items, array('type' => BlueimpGallery::TYPE_INLINE));

// CREATE LIGHTBOX
// Get the trigger event to create Gallery
$script = $bsGallery->getTrigger($items, array(
    'slideshow' => true,'type' => BlueimpGallery::TYPE_LIGHTBOX));

// Bind the trigger to a simple button
echo CHtml::htmlButton('Open fullscreen lightbox', array('onclick' => $script));

// CREATE BS MODAL
// Get the trigger event to create Gallery
$script = $bsGallery->getTrigger($items, array(
    'slideshow' => true,
    'type' => BlueimpGallery::TYPE_BS_LIGHTBOX));

// Bind the trigger to a simple button
echo CHtml::htmlButton('Open fullscreen bs modal', array('onclick' => $script));
?>
