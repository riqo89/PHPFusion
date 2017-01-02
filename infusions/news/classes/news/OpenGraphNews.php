<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: OpenGraphNews.php
| Author: Chubatyj Vitalij (Rizado)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
namespace PHPFusion;


class OpenGraphNews extends OpenGraph {
	public static function ogNews($news_id = 0) {
		$settings = fusion_get_settings();
		$info = array();

		$result = dbquery("SELECT `news_subject`, `news_news`, `news_keywords` FROM `" . DB_NEWS . "` WHERE `news_id` = '$news_id'");
		if (dbrows($result)) {
			$data = dbarray($result);
			$info['url'] = $settings['siteurl'].'infusions/news/news.php?readmore='.$news_id;
			$info['keywords'] = $data['news_keywords'] ? $data['news_keywords'] : fusion_get_settings('keywords');
			$info['title'] = $data['news_subject'].' - '.fusion_get_settings('sitename');
			$info['description'] = $data['news_news'] ? fusion_first_words(strip_tags(html_entity_decode($data['news_news'])), 50) : $settings['description'];
			$info['type'] = 'article';

			$result_img = dbquery("SELECT `news_image_t1` FROM `" . DB_NEWS_IMAGES . "` WHERE `news_id` = '$news_id'");
			if (dbrows($result_img)) {
				$data_img = dbarray($result_img);
				$info['image'] = $settings['siteurl'].'infusions/news/images/thumbs/' . $data_img['news_image_t1'];
			} else {
				$info['image'] = $settings['siteurl'].'images/favicons/mstile-150x150.png';
			}
		}

		OpenGraphNews::setValues($info);
	}
}
