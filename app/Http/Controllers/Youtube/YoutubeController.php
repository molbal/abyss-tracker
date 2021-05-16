<?php


	namespace App\Http\Controllers\Youtube;


	class YoutubeController {
        /**
         * @param string $url
         *
         * @return string
         */
        public static function getYoutubeID(string $url): string
        {
            if(strlen($url) > 11)
            {
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match))
                {
                    return $match[1];
                }
                else
                    return false;
            }

            return $url;
        }

        public static function getEmbed(string $url, int $height = 480): string {
            $url = self::getYoutubeID($url);
            return '<iframe style="width:100%; margin-bottom:16px; height: '.$height.'px" src="https://www.youtube.com/embed/'.urlencode($url).'" frameborder="0" allowfullscreen></iframe>';
        }
	}
