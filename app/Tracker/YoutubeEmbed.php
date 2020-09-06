<?php


	namespace App\Tracker;


	use App\Tracker\DTOs\BookmarkLine;

    class YoutubeEmbed {

	    /** @var string */
	    private $id;
	    /** @var array */
	    private $bookmarks;

        /**
         * YoutubeEmbed constructor.
         *
         * @param string $id
         */
        public function __construct(string $id) {
            $this->id = $id;
        }

        /**
         * @return string
         */
        public function getId() : string {
            return $this->id;
        }

        /**
         * @param string $id
         *
         * @return YoutubeEmbed
         */
        public function setId(string $id) : YoutubeEmbed {
            $this->id = $id;

            return $this;
        }

        /**
         * @return array
         */
        public function getBookmarks() : array {
            return $this->bookmarks;
        }

        /**
         * @param array $bookmarks
         *
         * @return YoutubeEmbed
         */
        public function setBookmarks(array $bookmarks) : YoutubeEmbed {
            $this->bookmarks = $bookmarks;

            return $this;
        }

        /**
         * @return \Illuminate\Support\Collection
         */
        public function getParsedBookmarks() {
            $coll = collect([]);
            foreach ($this->bookmarks as $bookmark =>$label) {
                $line = new BookmarkLine();
                $line->label = $label;
                $line->timeFormatted = $bookmark;
                $bm = explode(":",$bookmark);
                $line->timeSeconds = intval($bm[0])*60+intval($bm[1]);
                $line->timeSecondsNext = 2147483647;
                if ($coll->count() > 0) {
                    $coll->last()->timeSecondsNext = $line->timeSeconds;
                }
                $coll->add($line);
            }
            return $coll;
        }


    }
