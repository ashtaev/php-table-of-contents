<?php

namespace ashtaev;

class Toc {

    private $content;
    private $count;
    private $title;
    private $level;
    private $text;
    private $place = 'title';
    private $shortcode = "#<!--\[toc\]-->#is";


    public function __construct($content) {

        preg_match_all("#<[hH]([1-6])>(.*?)</[hH][1-6]>#is", $content, $match);

        $this->content = $content;
        $this->count   = count($match[0]);
        $this->title   = $match[0];
        $this->level   = $match[1];
        $this->text    = $match[2];
    }


    public function getDataToc() {

        $count = $this->count;
        $level = $this->level;
        $text  = $this->text;


        for ($i=0, $j=0; $i<$count; $i++, $j++) {

            if ($i === 0) {
                $toc[$i]['list_open']  = true;
                $toc[$i]['item_open']  = true;
                $toc[$i]['text']       = $text[$i];
                $toc[$i]['href']       = $this->getHref($text[$i]);
                $toc[$i]['item_close'] = $level[$i] == $level[$i+1] or (!isset($level[$i+1]));
                $toc[$i]['list_close'] = $level[$i] >  $level[$i+1] or (!isset($level[$i+1]));

                continue;
            }

            if ($i == $count-1) {
                $toc[$j]['list_open']  = $level[$i] > $level[$i-1];
                $toc[$j]['item_open']  = true;
                $toc[$j]['text']       = $text[$i];
                $toc[$j]['href']       = $this->getHref($text[$i]);
                $toc[$j]['item_close'] = true;
                $toc[$j]['list_close'] = $level[$i] > $level[$i-1];

                ++$j;
                $toc[$j]['list_open']  = false;
                $toc[$j]['item_open']  = false;
                $toc[$j]['text']       = "";
                $toc[$j]['href']       = "";
                $toc[$j]['item_close'] = true;
                $toc[$j]['list_close'] = true;

                break;
            }

            $toc[$j]['list_open']  = $level[$i] > $level[$i-1];
            $toc[$j]['item_open']  = true;
            $toc[$j]['text']       = $text[$i];
            $toc[$j]['href']       = $this->getHref($text[$i]);
            $toc[$j]['item_close'] = $level[$i] >= $level[$i+1];
            $toc[$j]['list_close'] = $level[$i] >  $level[$i+1];

            if ($level[$i] > $level[$i+1]) {
                ++$j;
                $toc[$j]['list_open']  = false;
                $toc[$j]['item_open']  = false;
                $toc[$j]['text']       = "";
                $toc[$j]['href']       = "";
                $toc[$j]['item_close'] = true;
                $toc[$j]['list_close'] = false;
            }
        }

        return $toc;
    }


    public function getPost() {

        $content = $this->content;
        $count   = $this->count;
        $level   = $this->level;
        $title   = $this->title;
        $text    = $this->text;

        for ($i=0; $i<$count; $i++) {

            $tag_id = $this->getTagId($text[$i]);

            $new_title = "<h{$level[$i]}><span id=\"{$tag_id}\">"
                       . $text[$i]
                       . "</span></h{$level[$i]}>";

            $content = str_replace($title[$i],
                                   $new_title,
                                   $content);
        }

        return $content;
    }


    public function getToc() {
        ob_start();
        $dataToc = $this->getDataToc();
        include "templates/toc.php";
        $toc = ob_get_clean();

        return $toc;
    }


    public function getPostWithToc() {
        switch ($this->place) {
            case "top":
                return $this->getToc() . $this->getPost();
            case "title":
                return preg_replace('#(?=<h\d*\s*)#is',
                                     $this->getToc(),
                                     $this->getPost(), 1);
            case "shortcode":
                return preg_replace($this->shortcode,
                                    $this->getToc(),
                                    $this->getPost(), 1);
        }
    }


    private function getHref($str) {

        return "#" . str_replace(' ', '_', $str);
    }


    private function getTagId($str) {

        return str_replace(' ', '_', $str);
    }


    public function setPlace($place) {

        $this->place = $place;
    }


    public function setShortcode($shortcode) {

        $this->shortcode = "#" . preg_quote($shortcode) . "#is";
    }


    public function getSC() {
        return $this->shortcode;
    }
}
