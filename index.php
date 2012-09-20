<?php

/**
 * ebGallery for Wolf CMS- Simply create multiple galleries from folders
 * This plugin is free for non-profit and commercial usage.
 *
 * @package wolf
 * @subpackage plugin.eb_gallery
 *
 * @author Julius Ehrlich <julius@ehrlich-bros.de>
 * @version 1.0
 * @for Wolf version 0.7.0 and above
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright ehrlich-bros, 2012
 */

//security measure
if (!defined('IN_CMS')) { exit(); }

Plugin::setInfos(array(
    'id'          => 'eb_gallery',
    'title'       => 'ebGallery', 
    'description' => 'Allows you to display multiple galleries on every site you want. Galleries are created from folders, thumbnails will be auto generated.', 
    'version'     => '1.0',
    'license'     => 'GPL',
    'author'      => 'Julius Ehrlich',
    'website'     => 'https://github.com/jlis/ebGallery',
    'update_url'  => 'https://raw.github.com/jlis/ebGallery/master/version.xml',
    'require_wolf_version' => '0.7.0')
);
 
Filter::add('eb_gallery', 'eb_gallery/filter.php');