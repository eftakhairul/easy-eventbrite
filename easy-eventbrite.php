<?php
/**
 * Plugin Name: WP Easy Eventbrite
 * Plugin URI: https://github.com/eftakhairul/category-description
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

// load the API Client library
include_once __DIR__ ."/eventbrite/Eventbrite.php";

/**
 * Add category's description at the top page
 *
 * @param string $content
 * @return string
 *
 * @uses post_name
 * @link http://codex.wordpress.org/Function_Reference
 */
function add_easy_eventbrite_event_filter($content)
{
    global $GLOBALS;

    $app_key    = 'KVQB7FT6UF7VUF6X5H';
    $user_key   = '137692529969928003541';

     if ($GLOBALS['post']->post_name == 'events') {

         $authentication_tokens = array('app_key'  => $app_key,
                                        'user_key' => $user_key);

         $eb_client = new Eventbrite( $authentication_tokens );

         try{
            $events    = $eb_client->user_list_events(array('event_statuses' => 'live,started'));
         } catch(\Exception $e) {
             $content = $content . 'No upcoming events found.';
         }

         if(!empty($events)) {

            foreach($events->events AS $event )
            {

              $singleEventContent =  "<div style='box-shadow:0 0.125em 0.275em 0 rgba(0, 0, 0, 0.075);border-radius:5px;background-color:#fff;padding:1.5em;border:1px solid #aaa;' class='x-column vc two-thirds eventbrite_event'>" .
                                     "<img src='" . (empty($event->event->logo)? plugins_url('/easy-eventbrite/images/logo_events.jpg'):$event->event->logo)      . "' style='width:150px;' class='x-img x-img-rounded left' />" .
                                     "<h2 class='h-custom-headline mtn h3'><span><a href='". $event->event->url . "'>" .$event->event->title . "</a></span></h2>" .
                                     "<p>" .
                                     "<i style='font-size:1em;margin-right:6px;' class='x-icon x-icon-calendar-o'></i> " .$event->event->start_date  . "<br>" .
                                     "<i style='font-size:1em;margin-right:6px;' class='x-icon x-icon-map-marker'></i>" . $event->event->venue->name .
                                     "</p>" .
                                     "<p>" . get_snippet(strip_tags($event->event->description), 35) .
                                     " ...<a href='" . $event->event->url .  "'> more details"  .
                                     "</a></p>" .
                                     "</div>";

                $content =  $content . $singleEventContent;

            }
         }

    }

    return $content;
}

/**
 * It's chunk the string based on word limit
 *
 * @param $str
 * @param int $wordCount
 * @return string
 */
function get_snippet( $str, $wordCount = 10)
{
  return implode('',
                array_slice(
                  preg_split(
                    '/([\s,\.;\?\!]+)/',
                    $str,
                    $wordCount*2+1,
                    PREG_SPLIT_DELIM_CAPTURE
                  ),
                  0,
                  $wordCount*2-1
                )
               );
}

//Filter category page and add category's description at the top
add_filter( 'the_content', 'add_easy_eventbrite_event_filter');