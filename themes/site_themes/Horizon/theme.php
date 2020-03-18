<?php

use PHPFusion\SiteLinks;
use PHPFusion\Steam;

Steam::getInstance()->setBoilerPlate('bootstrap4');

function render_page($license = '') {

    $theme_path = THEME.'templates/';
    $settings = fusion_get_settings();
    $menu_options = [
        //'container_fluid'   => TRUE,
        'show_banner'    => FALSE,
        'container'      => TRUE,
        'header_content' => '<a class="navbar-brand" href="'.BASEDIR.$settings['opening_page'].'"><img src="'.BASEDIR.$settings['sitebanner'].'" alt="'.$settings['sitename'].'" class="img-responsive"/></a>',
        'grouping'       => TRUE,
        'links_per_page' => 10,
        //'html_pre_content'  => $this->userMenu(),
        'show_header'    => TRUE
    ];

    $content = ['sm' => 12, 'md' => 12, 'lg' => 12];
    $left = ['sm' => 3, 'md' => 2, 'lg' => 2];
    $right = ['sm' => 3, 'md' => 2, 'lg' => 2];
    $ifLeft = FALSE;
    $ifRight = FALSE;

    if (defined('LEFT') && LEFT) {
        $content['sm'] = $content['sm'] - $left['sm'];
        $content['md'] = $content['md'] - $left['md'];
        $content['lg'] = $content['lg'] - $left['lg'];
        $ifLeft = TRUE;
    }

    if (defined('RIGHT') && RIGHT) {
        $content['sm'] = $content['sm'] - $right['sm'];
        $content['md'] = $content['md'] - $right['md'];
        $content['lg'] = $content['lg'] - $right['lg'];
        $ifRight = TRUE;
    }

    $theme_info = [
        'top_navigation' => SiteLinks::setSubLinks($menu_options)->showSubLinks(),

        //'locale'        => fusion_get_locale(),
        'settings'       => $settings,
        //'themesettings' => get_theme_settings('Horizon'),
        //'mainmenu'      => $sublinks,
        //'getparam'      => ['container' => $this->getParam('container')],
        //'banner1'       => showbanners(1),
        //'banner2'       => showbanners(2),
        'ifleft'         => $ifLeft,
        'left'           => $left,
        'content'        => $content,
        'notices'        => renderNotices(getNotices(['all', FUSION_SELF])),
        'ifright'        => $ifRight,
        'right'          => $right,
        //'right_content' => $this->getParam('right_content'),
        //'right_const'   => ($this->getParam('right') == TRUE && defined('RIGHT') && RIGHT) ? RIGHT : '',
        //'errors'        => showFooterErrors(),
        'footer_text'    => nl2br(parse_textarea($settings['footer'], FALSE, TRUE)),
        'copyright'      => showcopyright('', TRUE).showprivacypolicy(),
        'ifrendertime'   => ($settings['rendertime_enabled'] == 1 || $settings['rendertime_enabled'] == 2) ? TRUE : FALSE,
        'rendertime'     => showrendertime(),
        'memoryusage'    => showMemoryUsage(),
        'counter'        => showcounter()
    ];
    //print_p($theme_info);
    return fusion_render($theme_path, 'theme.twig', $theme_info, TRUE);
}


