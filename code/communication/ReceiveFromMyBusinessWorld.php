<?php


class ReceiveFromMyBusinessWorld extends Controller {

	protected static $url_segment = "mybusinessworldupdate";
		static function set_url_segment($s) {self::$url_segment = $s;}
		static function get_url_segment() {return self::$url_segment;}


}
