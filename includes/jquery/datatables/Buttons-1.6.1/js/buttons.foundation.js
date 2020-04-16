/*******************************************************************************
 * -------------------------------------------------------+
 * | PHP-Fusion Content Management System
 * | Copyright (C) PHP-Fusion Inc
 * | https://www.php-fusion.co.uk/
 * +--------------------------------------------------------+
 * | Filename:
 * | Author:
 * +--------------------------------------------------------+
 * | This program is released as free software under the
 * | Affero GPL license. You can redistribute it and/or
 * | modify it under the terms of this license which you
 * | can read by viewing the included agpl.txt or online
 * | at www.gnu.org/licenses/agpl.html. Removal of this
 * | copyright header is strictly prohibited without
 * | written permission from the original author(s).
 * +--------------------------------------------------------
 ******************************************************************************/

/*! Foundation integration for DataTables' Buttons
 * ©2016 SpryMedia Ltd - datatables.net/license
 */

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'datatables.net-zf', 'datatables.net-buttons'], function ($) {
            return factory($, window, document);
        });
    } else if (typeof exports === 'object') {
        // CommonJS
        module.exports = function (root, $) {
            if (!root) {
                root = window;
            }

            if (!$ || !$.fn.dataTable) {
                $ = require('datatables.net-zf')(root, $).$;
            }

            if (!$.fn.dataTable.Buttons) {
                require('datatables.net-buttons')(root, $);
            }

            return factory($, root, root.document);
        };
    } else {
        // Browser
        factory(jQuery, window, document);
    }
}(function ($, window, document, undefined) {
    'use strict';
    var DataTable = $.fn.dataTable;


// F6 has different requirements for the dropdown button set. We can use the
// Foundation version found by DataTables in order to support both F5 and F6 in
// the same file, but not that this requires DataTables 1.10.11+ for F6 support.
    var collection = DataTable.ext.foundationVersion === 6 ?
        {
            tag: 'div',
            className: 'dropdown-pane is-open button-group stacked'
        } :
        {
            tag: 'ul',
            className: 'f-dropdown open dropdown-pane is-open',
            button: {
                tag: 'li',
                className: 'small',
                active: 'active',
                disabled: 'disabled'
            },
            buttonLiner: {
                tag: 'a'
            }
        };

    $.extend(true, DataTable.Buttons.defaults, {
        dom: {
            container: {
                tag: 'div',
                className: 'dt-buttons button-group'
            },
            buttonContainer: {
                tag: null,
                className: ''
            },
            button: {
                tag: 'a',
                className: 'button small',
                active: 'secondary'
            },
            buttonLiner: {
                tag: null
            },
            collection: collection
        }
    });


    DataTable.ext.buttons.collection.className = 'dropdown';


    return DataTable.Buttons;
}));