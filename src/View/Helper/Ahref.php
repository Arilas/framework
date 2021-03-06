<?php
/**
 * Bluz Framework Component
 *
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/framework
 */

/**
 * @namespace
 */
namespace Bluz\View\Helper;

use Bluz\View\View;
use Bluz\Translator\Translator;

return
    /**
     * Generate HTML for <a> element
     *
     * @author ErgallM
     *
     * @var View $this
     * @param string $text
     * @param string|array $href
     * @param array $attributes HTML attributes
     * @return string
     */
    function ($text, $href, array $attributes = []) {
    // if href is settings for url helper
    if (is_array($href)) {
        $href = call_user_func_array(array($this, 'url'), $href);
    }

    // href can be null, if access is denied
    if (null === $href) {
        return '';
    }

    if ($href == app()->getRequest()->getRequestUri()) {
        if (isset($attributes['class'])) {
            $attributes['class'] .= ' on';
        } else {
            $attributes['class'] = 'on';
        }
    }

    $attributes = $this->attributes($attributes);

    return '<a href="' . $href . '" ' . $attributes . '>' . Translator::translate($text) . '</a>';
    };
