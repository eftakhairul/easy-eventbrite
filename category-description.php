<?php
/**
 * Plugin Name: WP Category Description
 * Plugin URI: http://wedevs.com/plugin/wp-project-manager/
 * Description: A WordPress Project Management plugin. Simply it does everything and it was never been easier with WordPress.
 * Author: Eftakhairul Islam
 * Author URI: http://eftakhairul.com
 * Version: 0.1
 * License: GPL2
 */

/**
 * Copyright (c) 2014 Eftakhairul Islam (email: eftakhairul@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */


/**
 * Add category's description at the top page
 *
 * @param string $content
 * @return string
 *
 * @uses is_category()
 * @uses category_description()
 */
function add_category_description_filter($content)
{
    if (is_category() AND category_description()) {
        $content = '<div>' . category_description() . '</div>' . $content;
    }

    return $content;
}

//Filter category page and add category's description at the top
add_filter( 'the_content', 'my_the_content_filter' );