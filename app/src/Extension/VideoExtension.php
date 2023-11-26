<?php

namespace QI\App\Extension;

use QI\App\Element\ElementVideo;
use QI\App\Model\Video;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

/**
 * Class \QI\App\Extension\VideoExtension
 *
 * @property \QI\App\Element\ElementVideo|\QI\App\Extension\VideoExtension $owner
 * @property string $VideoTitle
 * @property string $VideoURL
 * @property bool $VideoAutoPlay
 * @property int $VideoPreviewImageID
 * @method \SilverStripe\Assets\Image VideoPreviewImage()
 */
class VideoExtension extends DataExtension
{

    private static $casting = [
        'VideoIFrame'           => 'HTMLText',
        'VideoIFrameNoAutoPlay' => 'HTMLText'
    ];
    private static $db = [
        'VideoTitle'    => 'Varchar(256)',
        'VideoURL'      => 'Varchar(256)',
        'VideoAutoPlay' => 'Boolean',
    ];

    private static $has_one = [
        'VideoPreviewImage' => Image::class,
    ];
    private static $owns = [
        'VideoPreviewImage',
    ];

    private static $searchable_fields = [
        'VideoTitle',
        'VideoURL',
    ];

    private static $summary_fields = [
        'VideoTitle' => 'Video Title',
        'VideoURL'   => 'Video URL',
    ];

    private static $translate = [
        'VideoTitle',
        'VideoURL',
        'VideoPreviewImageID',
    ];

    /**
     * Is this Vimeo?
     * uses static function is_vimeo
     *
     * @param $url Video URL (defaults to 'VideoURL')
     * @return boolean
    */
    public function IsVimeo($url = false)
    {
        $url = $url ? $url : $this->owner->VideoURL;
        return (self::is_vimeo($url));
    }

    /**
     * Is this YouTube?
     * uses static function is_youtube
     *
     * @param $url Video URL (defaults to 'VideoURL')
     * @return boolean
    */
    public function IsYouTube($url = false)
    {
        $url = $url ? $url : $this->owner->VideoURL;
        return (self::is_youtube($url));
    }

    public function onBeforeWrite(): void
    {
        parent::onBeforeWrite();
    }

    public function updateCMSFields(FieldList $fields)
    {
        # VideoPreviewImage
        $videoPreviewImageField = new UploadField('VideoPreviewImage', 'Video Preview');
        $videoPreviewImageField->setRightTitle('Best size 1920 x 1080. Overrides video service preview. Remove or Delete to show service preview instead.');
        $videoPreviewImageField->setFolderName("Video-Previews");

        # set up video service preview
        $videoServicePreview = null;
        if (! $this->owner->VideoPreviewImageID
            && ($this->owner->VideoSource() == 'Vimeo' || $this->owner->VideoSource() == 'YouTube')) {
            $videoServicePreview = $this->VideoThumbIMG('m') . '<br />Preview pulled from ' . $this->owner->VideoSource();
        }
        $fieldArray = [
            TextField::create('VideoTitle', 'Video Title'),
            TextField::create('VideoURL', 'Video URL')->setRightTitle('Example: https://www.youtube.com/watch?v=wBNJ0BH3Dgs'),
            $videoPreviewImageField,
            CheckboxField::create('VideoAutoPlay', 'Auto play video'),
            new LiteralField('VideoServicePreview', $videoServicePreview),
        ];

        foreach ($fieldArray as $fieldItem) {
            if (is_a($this->owner, ElementVideo::class) || is_a($this->owner, Video::class)) {
                $fields->addFieldToTab('Root.Main', $fieldItem);
            } else {
                $fields->addFieldToTab('Root.Video', $fieldItem);
            }
        }
    }

    /**
     * Returns the service ID for this video
     *
     * @return string | false
    */
    public function VideoCode()
    {
        if ($this->owner->VideoURL) {
            if ($this->IsYouTube()) {
                return $this->YouTubeVideoID();
            } elseif ($this->IsVimeo()) {
                return $this->VimeoVideoID();
            }
        }
        return false;
    }

    public function VideoHTMLID()
    {
        return 'video-' . $this->owner->ClassName . '-' . $this->owner->ID;
    }

    /**
     * Returns the iframe code for this video
     * uses static function video_iframe_code
     *
     * @param $width Video URL (defaults to '640')
     * @param $height Video URL (defaults to '360')
     * @param $no_resize Do not resize to fit with JS (defaults to false)
     * @return ?string
    */
    public function VideoIFrame($width = '640', $height = '360', $fixed = false, $autoplay = 0, $background = false, $muted = false)
    {
        if ($this->owner->VideoURL) {
            $autoplay = $autoplay ? 1 : $this->owner->VideoAutoPlay;
            return self::video_iframe_code($this->owner->VideoURL, $this->owner->Title, $width, $height, $fixed, $autoplay, $background, $muted);
        }
    }
    public function VideoIFrameNoAutoPlay($width = '640', $height = '360', $fixed = false, $autoplay = 0, $background = false, $muted = false)
    {
        if ($this->owner->VideoURL) {
            $autoplay = 0;
            return self::video_iframe_code($this->owner->VideoURL, $this->owner->Title, $width, $height, $fixed, $autoplay, $background, $muted);
        }
    }

    public function VideoIFrameURL()
    {
        if ($this->owner->VideoURL) {
            return self::video_iframe_url($this->owner->VideoURL);
        }
    }

    public function VideoService()
    {
        if ($this->IsVimeo()) {
            return 'vimeo';
        } elseif ($this->IsYouTube()) {
            return 'youtube';
        }
    }

    /**
     * Returns the name of the service for this video
     *
     * @return ?string
    */
    public function VideoSource()
    {
        if ($this->owner->VideoURL) {
            if ($this->IsYouTube()) {
                return 'YouTube';
            } elseif ($this->IsVimeo()) {
                return 'Vimeo';
            } else {
                return 'None';
            }
        }
        return null;
    }

    /**
     * Gets a thumbnail img tag of the video
     *
     * @param mixed $size 's' small, 'm' medium, 'l' large
     * @return string|false
    */
    public function VideoThumbIMG($size = 's')
    {
        $tag = $this->VideoThumbURL($size);
        if ($tag) {
            return '<img class="video-thumb" src="' . $this->VideoThumbURL($size) . '" loading="lazy" />';
        } else {
            return false;
        }
    }

    // case 's':
    // 	return "//img.youtube.com/vi/$id/mqdefault.jpg";
    // case 'm':
    // 	return "//img.youtube.com/vi/$id/mqdefault.jpg";
    // case 'l':
    // 	return "//img.youtube.com/vi/$id/maxresdefault.jpg";

    // case 's':
    // 	return "http://img.youtube.com/vi/$id/default.jpg";
    // case 'm':
    // 	return "http://img.youtube.com/vi/$id/mqdefault.jpg";
    // case 'l':
    // 	return "http://img.youtube.com/vi/$id/maxresdefault.jpg";

    /**
     * Gets a YouTube thumbnail url
     *
     * @param mixed $id A YouTube id (ie. mXWSkBp0z8Y)
     * @param mixed $size 's' small, 'm' medium, 'l' large, 'h' huge
     * @return string|false
    */
    public function VideoThumbURL($size = 'm')
    {
        if ($this->owner->VideoURL) {
            # we have a VideoPreviewImage
            if ($this->owner->VideoPreviewImage()->exists() && $this->owner->VideoPreviewImage()->getIsImage()) {
                switch ($size) {
                    case 's':
                        return $this->owner->VideoPreviewImage()->ScaleWidth(100)->getURL();
                    case 'm':
                        return $this->owner->VideoPreviewImage()->ScaleWidth(320)->getURL();
                    case 'l':
                        return $this->owner->VideoPreviewImage()->ScaleWidth(640)->getURL();
                    case 'h':
                        return $this->owner->VideoPreviewImage()->ScaleWidth(1920)->getURL();
                }
            }
            # no VideoPreviewImage
            elseif ($this->IsVimeo()) {
                return self::vimeo_thumb_url($this->VideoCode(), $size);
            } elseif ($this->IsYouTUbe()) {
                return self::youtube_thumb_url($this->VideoCode(), $size);
            }
        }
        return false;
    }

    /**
     * Parse the ID from a Vimeo URL
     * uses static function vimeo_video_id
     *
     * @param $url Video URL (defaults to 'VideoURL')
     * @return string
    */
    public function VimeoVideoID($url = false)
    {
        $url = $url ? $url : $this->owner->VideoURL;
        return (self::vimeo_video_id($url));
    }

    /**
     * Parse the ID from a YouTube URL
     * uses static function youtube_video_id
     *
     * @param $url Video URL (defaults to 'VideoURL')
     * @return string
    */
    public function YouTubeVideoID($url = false)
    {
        $url = $url ? $url : $this->owner->VideoURL;
        return (self::youtube_video_id($url));
    }
    public static function is_vimeo($url = false)
    {
        return (preg_match('/vimeo\.com/i', $url));
    }
    public static function is_youtube($url)
    {
        return (preg_match('/youtu\.be/i', $url) || preg_match('/youtube\.com\/watch/i', $url));
    }

    /**
     * Shortcode parser for embedding video overlay links in RTEs
     *
     * process video urls
     * [popvid src=https://vimeo.com/72856974]
     * [popvid src=https://vimeo.com/72856974]Play Me[/popvid]
     * @return mixed thumbnail's url
    */
    public static function popvid_code_handler($arguments, $caption = null, $parser = null)
    {
        $url = false;
        $caption = $caption ? $caption : 'Play Me';

        if (isset($arguments['src'])) {
            $url = $arguments['src'];

            # did we find a URL?
            if ($url) {
                $result = '<a href="#overlay-video-' . self::video_id($url) . '" data-overlay-src="' . self::video_iframe_url($url) . '" data-overlay-type="video">' . $caption . '</a>';
                return $result;
            }
        }

        return false;
    }

    /**
     * Shortcode parser for embedding videos in RTEs
     *
     * process video urls
     * [video title="Title of Video" src=https://vimeo.com/72856974]
     * [video title="Title of Video" src=https://vimeo.com/72856974 width=640 height=480]
     * [video title="Title of Video" src=https://vimeo.com/72856974 width=640 height=480 fixed=true]
     *
     * @return mixed thumbnail's url
    */
    public static function video_code_handler($arguments, $caption = null, $parser = null)
    {
        $width = $height = false;
        $url = $arguments['src'] ?? false;
        $title = $arguments['title'] ?? 'Untitled Video';
        if ($url) {
            $width = $arguments['width'] ?? null;
            $height = $arguments['height'] ?? null;
            $fixed = isset($arguments['fixed']) ? true : false;
            return self::video_iframe_code($url, $title, $width, $height, $fixed);
        }

        return false;
    }

    public static function video_id($url)
    {
        if (self::is_vimeo($url)) {
            return self::vimeo_video_id($url);
        } elseif (self::is_youtube($url)) {
            return self::youtube_video_id($url);
        }
    }
    public static function video_iframe_code($url, $title, $width = '640', $height = '360', $fixed = false, $autoplay = 0, $background = false, $muted = false)
    {
        $frame_class = $fixed ? 'video__iframe -fixed' : 'video__iframe -resize';
        $wrapper_class = '';
        if ($autoplay) {
            $frame_class .= ' is-autoplay';
        }
        if ($muted) {
            $frame_class .= ' is-muted';
        }
        if ($background) {
            $wrapper_class .= ' is-background';
        }
        if (self::is_vimeo($url)) {
            $code = self::vimeo_video_id($url);
            return "<div class=\"video__wrapper {$wrapper_class}\"><iframe title=\"{$title}\" class=\"{$frame_class}\" src=\"//player.vimeo.com/video/{$code}?dnt=1&autoplay={$autoplay}&background={$background}\" width=\"{$width}\" height=\"{$height}\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen loading=\"lazy\"></iframe></div>";
        } elseif (self::is_youtube($url)) {
            $code = self::youtube_video_id($url);
            return "<div class=\"video__wrapper {$wrapper_class}\"><iframe title=\"{$title}\" class=\"{$frame_class}\" width=\"{$width}\" height=\"{$height}\" src=\"//www.youtube.com/embed/{$code}?autoplay={$autoplay}&background={$background}\" frameborder=\"0\" allowfullscreen loading=\"lazy\"></iframe></div>";
        }
    }

    public static function video_iframe_url($url)
    {
        if ($url) {
            if (self::is_vimeo($url)) {
                $code = self::vimeo_video_id($url);
                return "//player.vimeo.com/video/{$code}";
            } elseif (self::is_youtube($url)) {
                $code = self::youtube_video_id($url);
                return "//www.youtube.com/embed/{$code}";
            }
        }
    }

    /**
     * Gets a Vimeo thumbnail url
     *
     * @param mixed $id A vimeo id (ie. 1185346)
     * @param mixed $size 's' small, 'm' medium, 'l' large
     * @return mixed thumbnail's url
    */
    public static function vimeo_thumb_url($id, $size = 'm')
    {
        $data = @file_get_contents("https://vimeo.com/api/v2/video/{$id}.json");
        if ($data) {
            $data = json_decode($data);
            switch ($size) {
                case 's':
                    return $data[0]->thumbnail_small;
                case 'm':
                    return $data[0]->thumbnail_medium;
                case 'l':
                    return $data[0]->thumbnail_large;
                case 'h':
                    return $data[0]->thumbnail_large;
            }
        }
        return false;
    }
    public static function vimeo_video_id($url)
    {
        if (self::is_vimeo($url)) {
            $pattern = '/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/';
            preg_match($pattern, $url, $matches);
            if (count($matches)) {
                return $matches[2];
            }
        }
        return false;
    }

    /**
     * Gets a YouTube thumbnail url
     *
     * @param mixed $id A YouTube id (ie. mXWSkBp0z8Y)
     * @param mixed $size 's' small, 'm' medium, 'l' large
     * @return string|false
    */
    public static function youtube_thumb_url($id, $size = 'm')
    {
        switch ($size) {
            case 's':
                return "//img.youtube.com/vi/{$id}/default.jpg";
            case 'm':
                return "//img.youtube.com/vi/{$id}/mqdefault.jpg";
            case 'l':
                return "//img.youtube.com/vi/{$id}/maxresdefault.jpg";
            case 'h':
                return "//img.youtube.com/vi/{$id}/maxresdefault.jpg";
        }
        return false;
    }
    public static function youtube_video_id($url)
    {
        if (self::is_youtube($url)) {
            $pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
            preg_match($pattern, $url, $matches);
            if (count($matches) && strlen($matches[7]) == 11) {
                return $matches[7];
            }
        }
        return false;
    }
}
