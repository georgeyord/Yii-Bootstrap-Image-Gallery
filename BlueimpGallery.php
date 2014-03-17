<?php

/**
 * BlueimpGallery
 *
 */
class BlueimpGallery extends CWidget {

    CONST TYPE_BS_LIGHTBOX = 'bs-lightbox';
    CONST TYPE_LIGHTBOX = 'lightbox';
    CONST TYPE_INLINE = 'inline';

    /**
     * Set to the number of seconds needed to cache each request, false to deactivate it
     * @var mixed $cacheDuration Integer means seconds, false to deactivate cache
     */
    public $cacheDuration = 7200;

    /**
     * Register script files
     */
    public function init() {
        $this->registerFiles();
        parent::init();
    }

    /**
     * Initialize a widget instance
     *
     * @param array $items to add to gallery
     * @param array $options plugin options.
     * The following special options are recognized:
     * <ul>
     * <li>type: Define the type of the plugin, example "inline"</li>
     * <li>controls: boolean value to toggle controls visibility</li>
     * <li>slideshow: boolean value to toggle play-pause visibility</li>
     * <li>indicator: boolean value to toggle indicator visibility</li>
     * <li>cover: boolean value to set stretchImages to 'cover'</li>
     * </ul>
     * @param string $id
     * @param bool $return
     * @return bool|string|void
     */
    public function run($items, $options = array(), $id = null, $return = false) {
        $return = $this->preparePlugin($items, $options, $id, $return);

        $script = new CJavaScriptExpression(sprintf('var %s = blueimp.Gallery(%s,%s);', $id, json_encode($items), json_encode($options)), CJavaScript::encode($options));
        Yii::app()->clientScript->registerScript($id, $script, CClientScript::POS_END);

        return $return;
    }

    /**
     *
     * Initialize a widget instance and render an Element
     *
     * @param array $items to add to gallery
     * @param array $options plugin options.
     * The following special options are recognized:
     * <ul>
     * <li>type: Define the type of the plugin, example "inline"</li>
     * <li>controls: boolean value to toggle controls visibility</li>
     * <li>slideshow: boolean value to toggle play-pause visibility</li>
     * <li>indicator: boolean value to toggle indicator visibility</li>
     * <li>cover: boolean value to set stretchImages to 'cover'</li>
     * </ul>
     * @param string $id
     * @param string $tag
     * @param array $tagOptions
     * @param array|bool $tagContent
     * @return string
     */
    public function renderElement($items, $options = array(), $id = null, $tag = 'a', $tagOptions = array(), $tagContent = false) {
        $return = $this->preparePlugin($items, $options, $id, true);

        $script = new CJavaScriptExpression(sprintf('blueimp.Gallery(%s,%s);', json_encode($items), json_encode($options)), CJavaScript::encode($options));
        $tagOptions['onclick'] = $script;

        if ($tag == 'htmlButton') {
            $tag = $tagOptions['type'] = 'button';
        }
        if (!$tagContent)
            $tagContent = BGArray::popValue('label', $tagOptions, 'Show gallery');

        return $return. CHtml::tag($tag, $tagOptions, $tagContent);
    }

    /**
     * Prepare plugin options
     *
     * @param array $items
     * @param array $options
     * @param string $id
     * @param bool $return
     * @return string HTML
     */
    private function preparePlugin(&$items, &$options, &$id, $return = false) {
        if ($id === null)
            $id = uniqid(__CLASS__);

        $type = BGArray::popValue('type', $options, self::TYPE_LIGHTBOX);
        $controls = BGArray::popValue('controls', $options, true);
        $slideshow = BGArray::popValue('slideshow', $options, false);
        $indicator = BGArray::popValue('indicator', $options, false);

        foreach ($items as $key => $item) {
            if (!is_array($item))
                $items[$key] = self::image($item);
        }

        $options = self::defaultOptions($id, $type, $options);
        return $this->renderSnippet($id, $type, $controls, $slideshow, $indicator, $return);
    }

    /**
     * Registers and publish assets needed
     */
    private function registerFiles() {
        // Bootstrap-Image-Gallery
        // Publish the assets needed and return the url to the published folder
        $blueimpPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Blueimp-Gallery';
        $blueimpUrl = Yii::app()->getAssetManager()->publish($blueimpPath);
        if ($blueimpUrl) {
            Yii::app()->clientScript->registerCSSFile($blueimpUrl . '/css/blueimp-gallery.min.css');
            Yii::app()->clientScript->registerScriptFile($blueimpUrl . '/js/jquery.blueimp-gallery.min.js', CClientScript::POS_END);
        } else
            throw new Exception('Path "' . $blueimpPath . '" is not valid');

        // Bootstrap-Image-Gallery
        // Publish the assets needed and return the url to the published folder
        $bsPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Bootstrap-Image-Gallery';
        $bsUrl = Yii::app()->getAssetManager()->publish($bsPath);
        if ($bsUrl) {
            Yii::app()->clientScript->registerCSSFile($bsUrl . '/css/bootstrap-image-gallery.css');
            Yii::app()->clientScript->registerScriptFile($bsUrl . '/js/bootstrap-image-gallery.js', CClientScript::POS_END);
        } else
            throw new Exception('Path "' . $bsUrl . '" is not valid');
    }

    /**
     * Render a hidden html snippet needed from the plugin
     *
     * @param string $id
     * @param string $type
     * @param bool $controls
     * @param bool $slideshow
     * @param bool $indicator
     * @param bool $return
     * @return string
     */
    public function renderSnippet($id, $type, $controls, $slideshow, $indicator, $return = false) {
        return $this->render($type, array(
                    'id' => $id,
                    'controls' => $controls,
                    'slideshow' => $slideshow,
                    'indicator' => $indicator,
                        ), $return);
    }

    /**
     * Returns the default plugin options to use them in the initialization of the plugin
     *
     * @param string $id
     * @param string $type
     * @param array $options
     * @return array
     */
    private static function defaultOptions($id, $type, $options = array()) {
        $defaultOptions = array(
            // The Id, element or querySelector of the gallery widget:
            'container' => '#' . $id,
            // The list object property (or data attribute) with the object URL:
            'urlProperty' => 'href',
            // Defines if images should be stretched to fill the available space,
            // while maintaining their aspect ratio
            // Set to "cover", to make images cover all available space
            'stretchImages' => true,
            'useBootstrapModal' => false,
        );
        if (BGArray::popValue('cover', $options, false))
            $options['stretchImages'] = 'cover';

        // HTML5 Video options
        $defaultOptions = array_merge(array(
            // The class for video content elements:
            'videoContentClass' => 'video-content',
            // The class for video when it is loading:
            'videoLoadingClass' => 'video-loading',
            // The class for video when it is playing:
            'videoPlayingClass' => 'video-playing',
            // The list object property (or data attribute) for the video poster URL:
            'videoPosterProperty' => 'poster',
            // The list object property (or data attribute) for the video sources array:
            'videoSourcesProperty' => 'sources'
                ), $defaultOptions);

        // Youtube options
        $defaultOptions = array_merge(array(
            // The list object property (or data attribute) with the YouTube video id:
            'youTubeVideoIdProperty' => 'youtube',
            // Optional object with parameters passed to the YouTube video player:
            // https://developers.google.com/youtube/player_parameters
            'youTubePlayerVars' => null,
            // Require a click on the native YouTube player for the initial playback:
            'youTubeClickToPlay' => true
                ), $defaultOptions);

        // Vimeo options
        $defaultOptions = array_merge(array(
            // The list object property (or data attribute) with the Vimeo video id:
            'vimeoVideoIdProperty' => 'vimeo',
            // The URL for the Vimeo video player, can be extended with custom parameters:
            // https://developer.vimeo.com/player/embedding
            'vimeoPlayerUrl' => '//player.vimeo.com/video/VIDEO_ID?api=1&player_id=PLAYER_ID',
            // The prefix for the Vimeo video player ID:
            'vimeoPlayerIdPrefix' => 'vimeo-player-',
            // Require a click on the native Vimeo player for the initial playback:
            'vimeoClickToPlay' => true
                ), $defaultOptions);

        // Type specific options
        switch ($type) {
            case self::TYPE_INLINE :
                $defaultOptions['carousel'] = true;
                BGArray::defaultValue('startSlideshow', false, $defaultOptions);
                break;
            case self::TYPE_BS_LIGHTBOX :
                $defaultOptions['useBootstrapModal'] = true;
                $defaultOptions['stretchImages'] = false;
                break;
            case self::TYPE_LIGHTBOX :
            default :
                break;
        }

        return self::buildOptions($options, $defaultOptions);
    }

    /**
     * Returns an array with the normalized options of an item.
     * It is the base for all other items
     *
     * @param array $options
     * @param array $defaultOptions
     * @return array
     */
    public static function item($options, $defaultOptions) {
        return self::buildOptions($options, $defaultOptions);
    }

    /**
     * Returns an array with the normalized options of an image item
     *
     * @param array $options
     * @return array
     * @throws Exception, required options is missing
     */
    public static function image($options) {
        if (is_string($options))
            $options = array('href' => $options);
        if (!isset($options['href']))
            throw new Exception("Option 'href' is required");

        $defaultOptions = array(
            'title' => null,
            'type' => 'image/jpeg',
            'thumbnail' => null,
        );
        return self::item($options, $defaultOptions);
    }

    /**
     * Returns an array with the normalized options of a video item
     *
     * @param array $options
     * @return array
     * @throws Exception, required options is missing
     */
    public static function video($options) {
        if (is_string($options))
            $options = array('href' => $options);
        if (!isset($options['href']))
            throw new Exception("Option 'href' is required");

        $defaultOptions = array(
            'title' => null,
            'type' => 'video/mp4',
            'poster' => null,
        );
        return self::item($options, $defaultOptions);
    }

    /**
     * Returns an array with the normalized options of a youtube item
     *
     * @param array $options
     * @return array
     * @throws Exception, required options is missing
     */
    public static function youtube($options) {
        if (is_string($options))
            $options = array('youtube' => $options);
        if (!isset($options['youtube']))
            throw new Exception("Option 'youtube' is required");

        $defaultOptions = array(
            'title' => null,
            'href' => sprintf('https://www.youtube.com/watch?v=%s', $options['youtube']),
            'type' => 'text/html',
            'poster' => sprintf('https://img.youtube.com/vi/%s/0.jpg', $options['youtube']),
        );
        return self::item($options, $defaultOptions);
    }

    /**
     * Returns an array with the normalized options of a vimeo item
     *
     * @param array $options
     * @return array
     * @throws Exception, required options is missing
     */
    public static function vimeo($options) {
        if (is_string($options))
            $options = array('vimeo' => $options);
        if (!isset($options['vimeo']))
            throw new Exception("Option 'vimeo' is required");

        // Cache info from vimeo if possible
        $cacheKey = 'vimeo-' . $options['vimeo'];
        if (($response = self::getFromCache($cacheKey)) === false) {
            if ($response = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$options[vimeo].php")))
                self::storeToCache($cacheKey, $response);
        }

        $defaultOptions = array(
            'title' => $response ? $response[0]['title'] : null,
            'href' => sprintf('https://vimeo.com/%s', $options['vimeo']),
            'type' => 'text/html',
            'poster' => $response ? $response[0]['thumbnail_large'] : null,
        );
        return self::item($options, $defaultOptions);
    }

    /**
     * HELPER FUNCTIONS
     * * */

    /**
     * Helper function to merge options and defaultOptions
     *
     * @param array $options
     * @param array $defaultOptions
     * @return array
     */
    private static function buildOptions($options, $defaultOptions) {
        foreach ($defaultOptions as $key => $defaultValue) {
            BGArray::defaultValue($key, $defaultValue, $options);
            if ($options[$key] === null)
                unset($options[$key]);
        }
        return $options;
    }

    /**
     * Get cached data if exist
     *
     * @param string $key
     * @param mixed $data
     * @return boolean
     */
    private static function getFromCache($key) {
        if (isset(Yii::app()->cache) && $cached = Yii::app()->cache->get($key))
            return $cached;

        return false;
    }

    /**
     * Save items to cache if possible
     *
     * @param string $key
     * @param mixed $data
     */
    private static function storeToCache($key, $data) {
        if (isset(Yii::app()->cache) && !empty($data))
            Yii::app()->cache->set($key, $data, 600);
    }

}

/**
 * @author Pascal Brewing
 * @package bootstrap.helpers
 */
class BGArray {

    /**
     * Returns a specific value from the given array (or the default value if not set).
     * @param string $key the item key.
     * @param array $array the array to get from.
     * @param mixed $defaultValue the default value.
     * @return mixed the value.
     */
    public static function getValue($key, array $array, $defaultValue = null) {
        return isset($array[$key]) ? $array[$key] : $defaultValue;
    }

    /**
     * Removes and returns a specific value from the given array (or the default value if not set).
     * @param string $key the item key.
     * @param array $array the array to pop the item from.
     * @param mixed $defaultValue the default value.
     * @return mixed the value.
     */
    public static function popValue($key, array &$array, $defaultValue = null) {
        $value = self::getValue($key, $array, $defaultValue);
        unset($array[$key]);
        return $value;
    }

    /**
     * Sets the default value for a specific key in the given array.
     * @param string $key the item key.
     * @param mixed $value the default value.
     * @param array $array the array.
     */
    public static function defaultValue($key, $value, array &$array) {
        if (!isset($array[$key])) {
            $array[$key] = $value;
        }
    }

    /**
     * Sets a set of default values for the given array.
     * @param array $array the array to set values for.
     * @param array $values the default values.
     */
    public static function defaultValues(array $values, array &$array) {
        foreach ($values as $name => $value) {
            self::defaultValue($name, $value, $array);
        }
    }

    /**
     * Removes a specific value from the given array.
     * @param string $key the item key.
     */
    public static function removeValue($key, array &$array) {
        unset($array[$key]);
    }

    /**
     * Removes a set of items from the given array.
     * @param array $keys the keys to remove.
     * @param array $array the array to remove from.
     */
    public static function removeValues(array $keys, array &$array) {
        $array = array_diff_key($array, array_flip($keys));
    }

    /**
     * Copies the given values from one array to another.
     * @param array $keys the keys to copy.
     * @param array $from the array to copy from.
     * @param array $to the array to copy to.
     * @param boolean $force whether to allow overriding of existing values.
     * @return array the options.
     */
    public static function copyValues(array $keys, array $from, array $to, $force = false) {
        foreach ($keys as $key) {
            if (isset($from[$key])) {
                if ($force || !isset($to[$key])) {
                    $to[$key] = self::getValue($key, $from);
                }
            }
        }
        return $to;
    }

    /**
     * Moves the given values from one array to another.
     * @param array $keys the keys to move.
     * @param array $from the array to move from.
     * @param array $to the array to move to.
     * @param boolean $force whether to allow overriding of existing values.
     * @return array the options.
     */
    public static function moveValues(array $keys, array &$from, array $to, $force = false) {
        foreach ($keys as $key) {
            if (isset($from[$key])) {
                $value = self::popValue($key, $from);
                if ($force || !isset($to[$key])) {
                    $to[$key] = $value;
                    unset($from[$key]);
                }
            }
        }
        return $to;
    }

    /**
     * Merges two arrays.
     * @param array $to array to be merged to.
     * @param array $from array to be merged from.
     * @return array the merged array.
     */
    public static function merge(array $to, array $from) {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            $next = array_shift($args);
            foreach ($next as $k => $v) {
                if (is_integer($k)) {
                    isset($res[$k]) ? $res[] = $v : $res[$k] = $v;
                } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = self::merge($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }
        return $res;
    }

}
