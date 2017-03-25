<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: /Nebula/Templates/News.php
| Author: Hien (Frederick MC Chan)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

namespace ThemePack\Nebula\Templates;

use PHPFusion\Panels;
use ThemeFactory\Core;

/**
 * Class News
 *
 * @package ThemePack\Nebula\Templates
 */
class News extends Core {

    /**
     * News Main Page
     * @param $info
     */
    public static function display_news($info) {

        /*
         * FusionTheme Controller
         */
        self::setParam('subheader_content', $info['news_cat_name']);
        self::setParam('breadcrumbs', TRUE);
        self::setParam('body_container', TRUE);
        ?>

        <ul class='m-b-20 list-group-item'>
            <li class='pull-right m-b-0'>
                <a href='<?php echo INFUSIONS.'news/news.php' ?>'><h5><?php echo fusion_get_locale('news_0018') ?></h5></a>
            </li>
            <li class='display-inline-block m-r-10'>
                <?php echo fusion_get_locale('news_0017') ?>
            </li>
            <?php foreach ($info['news_filter'] as $filter_link => $filter_name) : ?>
                <li class='display-inline-block m-r-10'>
                    <a href='<?php echo $filter_link ?>'>
                        <h5 class='m-0 p-t-10 p-b-5'><?php echo $filter_name ?></h5>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
        if (!empty($info['news_items'])) {
            foreach ($info['news_items'] as $news_id => $data) {
                self::render_news($data);
            }
        } else {
            echo "<div class='well text-center'>".fusion_get_locale('news_0005')."</div>\n";
        }

        // Send categories to the right panel
        ob_start();
        openside(fusion_get_locale('news_0009'));
        ?>
        <ul>
            <?php foreach ($info['news_categories'][0] as $category_id => $category) : ?>
                <li class='list-group-item'>
                    <a href='<?php echo $category['link'] ?>'>
                        <h5 class='text-uppercase m-0 p-t-10 p-b-5'>
                            <strong><?php echo $category['name'] ?></strong>
                        </h5>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
        closeside();
        $news_category_html = ob_get_contents();
        ob_end_clean();
        self::setParam('right_post_content', $news_category_html);
    }

    /**
     * News Item Container
     * @param $info
     */
    public static function render_news($info) {
        ?>
        <div class='news_item wow fadeInDown' data-wow-duration='700ms' data-wow-delay='200ms'>
            <article id='news_<?php echo $info['news_id'] ?>'>
                <div class='post-image'>
                    <?php if (!empty($info['news_image_src']) && strpos($info['news_image_src'], '.svg') == FALSE) : ?>
                        <a href='<?php echo $info['news_link'] ?>'>
                            <img class='img-responsive' src='<?php echo $info['news_image_src']; ?>'>
                        </a>
                    <?php endif; ?>
                </div>
                <div class='post-title'>
                    <h3>
                        <a href='<?php echo $info['news_url'] ?>' rel='bookmark'>
                            <strong class='m-r-10'><?php echo date('M d', $info['news_datestamp']) ?>:</strong><?php echo $info['news_subject'] ?>
                        </a>
                    </h3>
                </div>
                <?php
                $start_nc_url = ($info['news_cat_url'] ? "<a href='".$info['news_cat_url']."' title='".$info['news_cat_name']."'>" : '');
                $end_nc_url = ($info['news_cat_url'] ? "</a>" : '');
                ?>
                <div class='post-meta'>
                    <ul class="meta-left">
                        <li><?php echo showdate('newsdate', $info['news_datestamp']) ?></li>
                        <li>By <?php echo profile_link($info['user_id'], $info['user_name'], $info['user_status']) ?> / <?php echo $start_nc_url.$info['news_cat_name'].$end_nc_url ?></li>

                    </ul>
                    <ul class='meta-right'>
                        <li><i class='fa fa-comment-o'></i> <?php echo $info['news_display_comments'] ?></li>
                        <li><i class='fa fa-heart-o'></i> <?php echo $info['news_display_ratings'] ?></li>
                        <?php if (!empty($info['news_admin_actions'])) : ?>
                            <li>
                                <?php
                                echo implode(' &middot; ', array_map(function ($e) {
                                    return "<a href='".$e['link']."'>".$e['title']."</a>";
                                }, $info['news_admin_actions']));
                                ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class='post-text'>
                    <?php if (!empty($info['news_image_src']) && strpos($info['news_image_src'], '.svg')) : ?>
                        <div class='pull-left m-r-15' style='width: 100px;'>
                            <a href='<?php echo $info['news_link'] ?>'>
                                <img class='img-responsive' src='<?php echo $info['news_image_src']; ?>'>
                            </a>
                </div>
                    <?php endif; ?>
                    <p>
                        <?php echo $info['news_news'] ?>
                        <?php if ($info['news_ext'] == 'y') : ?>
                            ... <a class='text-uppercase text-smaller' href='<?php echo $info['news_url'] ?>'><?php echo fusion_get_locale('news_0001') ?> +</a>
                        <?php endif; ?>
                    </p>
                </div>
            </article>
        </div>
        <?php
    }

    /**
     * Full News
     * @param $info
     */
    public static function render_news_item($info) {

        self::setParam('subheader_content', $info['news_item']['news_subject']);
        self::setParam('breadcrumbs', TRUE);
        self::setParam('container', TRUE);

        $news = $info['news_item'];
        $news_image = '';
        if ($news['news_image_src']) {
            $news_image = "<div class='post-image'>
                <div class='center-margin-x'>
                ".colorbox($news['news_image_src'], $news['news_subject'])."
                </div>
            </div>";
        }
        ?>
        <ul class='m-b-20 list-group-item row'>
            <li class='pull-right m-b-0'>
                <a href='<?php echo INFUSIONS.'news/news.php'; ?>'><h5><?php echo fusion_get_locale('news_0018') ?></h5></a>
            </li>
            <li class='display-inline-block m-r-10'>
                <?php echo fusion_get_locale('news_0017') ?>
            </li>
            <?php foreach ($info['news_filter'] as $filter_link => $filter_name) : ?>
                <li class='display-inline-block m-r-10'>
                    <a href='<?php echo $filter_link ?>'>
                        <h5 class='m-0 p-t-10 p-b-5'>
                            <?php echo $filter_name ?>
                        </h5>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <!--news_pre_readmore-->
        <article class='news_item clearfix'>
            <?php echo(($news['news_image_align'] == 'news-img-center') ? "<div class='".$news['news_image_align']."'>$news_image</div>" : '') ?>
            <div class='post-meta'>
                <ul class='meta-left'>
                    <li>By <?php echo profile_link($news['user_id'], $news['user_name'], $news['user_status']) ?></li>
                    <?php
                    $start_nc_url = ($news['news_cat_url'] ? "<a href='".$news['news_cat_url']."' title='".$news['news_cat_name']."'>" : '');
                    $end_nc_url = ($news['news_cat_url'] ? "</a>" : '');
                    ?>
                    <li><?php echo $start_nc_url.$news['news_cat_name'].$end_nc_url ?></li>
                    <li><?php echo showdate('newsdate', $news['news_datestamp']).', '.timer($news['news_datestamp']); ?></li>
                </ul>
                <ul class='meta-right'>
                    <li><i class='fa fa-eye'></i> <?php echo number_format($news['news_reads']) ?></li>
                    <li>
                        <a class='btn btn-default btn-bordered' title='<?php echo fusion_get_locale('news_0002') ?>' href='<?php echo $news['print_link'] ?>'>
                            <i class='fa fa-print'></i>
                            <?php echo fusion_get_locale('news_0002') ?>
                        </a>
                    </li>
                    <?php if (!empty($news['news_admin_actions'])) : ?>
                        <li>
                            <?php
                            echo implode(' &middot; ', array_map(function ($e) {
                                return "<a href='".$e['link']."'>".$e['title']."</a>";
                            }, $news['news_admin_actions']));
                            ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class='post-title'>
                <h3>
                    <strong><?php echo $news['news_subject'] ?></strong>
                </h3>
            </div>
            <div class='post-text'>
                <?php echo(($news['news_image_align'] == 'pull-left' || $news['news_image_align'] == 'pull-right') ? "<div class='display-inline-block p-l-0 m-r-15 col-xs-12 col-sm-5 ".$news['news_image_align']."'>$news_image</div>" : '') ?>
                <p>
                    <?php
                    echo $news['news_news']
                    ?>
                </p>
                <p>
                    <?php echo $news['news_extended'] ?>
                </p>

                <?php echo $news['news_pagenav']; ?>
            </div>
        </article>

        <?php if (!empty($news['news_gallery'])) : ?>
            <div class='post-gallery'>
                <div class='row'>
                    <?php $animate_delay = 200; ?>
                    <?php foreach ($news['news_gallery'] as $news_image_id => $news_image) : ?>
                        <div class='col-xs-12 col-sm-4 post-gallery-item wow fadeInUp' data-wow-duration='700ms' data-wow-delay='<?php echo $animate_delay ?>ms'>
                            <?php echo colorbox(IMAGES_N.$news_image['news_image'], '') ?>
                        </div>
                        <?php $animate_delay = $animate_delay + 150; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>


        <!--news_sub_readmore-->
        <?php
        if (fusion_get_settings('comments_enabled') && $news['news_show_comments']) {
            echo "<hr />".$news['news_show_comments']."\n";
        }
        $ratings_html = "";
        if (fusion_get_settings('ratings_enabled') && $news['news_show_ratings']) {
            ob_start();
            openside('');
            ?>
            <div class='list-group-item'>
                <?php echo $news['news_show_ratings']; ?>
            </div>
            <?php
            closeside();
            $ratings_html = ob_get_contents();
            ob_end_clean();
        }

        self::setParam('right_post_content', $ratings_html);

        // Send categories to the right panel
        ob_start();
        openside(fusion_get_locale('news_0009'));
        ?>
        <ul>
            <?php foreach ($info['news_categories'][0] as $category_id => $category) : ?>
                <li class='list-group-item'>
                    <a href='<?php echo $category['link'] ?>'>
                        <h5 class='text-uppercase m-0 p-t-10 p-b-5'>
                            <strong><?php echo $category['name'] ?></strong>
                        </h5>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
        closeside();
        $news_category_html = ob_get_contents();
        ob_end_clean();
        self::setParam('right_post_content', $news_category_html);
    }
}