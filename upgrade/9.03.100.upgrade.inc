<?php
/*-------------------------------------------------------+
| PHPFusion Content Management System
| Copyright (C) PHP Fusion Inc
| https://www.phpfusion.com/
+--------------------------------------------------------+
| Filename: 9.03.100.upgrade.inc
| Author: Core Development Team (coredevs@phpfusion.com)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
$settings = fusion_get_settings();

$update_settings_tbl = [
    'version' => '9.03.100'
];

foreach ($update_settings_tbl as $key => $value) {
    if (isset($settings[$key])) {
        $inf_updatedbrow[] = DB_SETTINGS." SET settings_value='$value' WHERE settings_name='$key'";
    }
}

$insert_settings_tbl = [
    'username_change' => !empty($settings['userNameChange']) ? $settings['userNameChange'] : '',
    'username_ban'    => !empty($settings['user_name_ban']) ? $settings['user_name_ban'] : ''
];

foreach ($insert_settings_tbl as $key => $value) {
    if (!isset($settings[$key])) {
        $inf_insertdbrow[] = DB_SETTINGS." (settings_name, settings_value) VALUES ('$key', '$value')";
    }
}

$inf_deldbrow[] = DB_SETTINGS." WHERE settings_name='userNameChange'";
$inf_deldbrow[] = DB_SETTINGS." WHERE settings_name='user_name_ban'";

if (db_exists(DB_PREFIX.'captcha')) {
    dbquery("DROP TABLE ".DB_PREFIX.'captcha');
}