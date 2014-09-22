<?php

/*
 * Filter logic for the ebGallery plugin
 *
 * This file is part of the ebGallery plugin for Wolf CMS
 */

//security measure
if (!defined('IN_CMS')) { exit(); }

/**
 * Main filter class
 */
class EbGallery {

    // image resizing settings
    private $folder;
    private $thumb_width;
    private $thumb_height;
    private $gallery_title;

    private $default_thumb_width = 150;
    private $default_thumb_height = 94;

    // template settings
    private $gallery_tmpl;
    private $title_tmpl;
    private $image_tmpl;

    private $default_gallery_tmpl = '<div class="gallery">((gallery))</div>';
    private $default_title_tmpl = '<h2>((title))</h2>';
    private $default_image_tmpl = '<a class="photo" rel="((title))" href="((image))"><img src="((thumb))"/></a>';

    // main wolf cms filter function which applies the current filter to the content
    public function apply($text) {
        $this->_setup_tmpl();
        $parsed_text = $this->_parse($text);
        return $parsed_text;
    }

    // prepare the template and get the html
    private function _setup_tmpl() {
        $tmpl_file = PLUGINS_ROOT . '/eb_gallery/gallery.tmpl';
        $tmpl_content = file_get_contents($tmpl_file);

        $template_parts = array('gallery', 'title', 'image');
        foreach ($template_parts as $p) {
            $pattern = '/###' . $p . '_start###([^#]+?)###' . $p . '_end###/i';
            preg_match($pattern, $tmpl_content, $matches);
            $tmpl_var_key = $p . '_tmpl';
            $default_tmpl_var_key = 'default_' . $tmpl_var_key;

            $this->$tmpl_var_key = isset($matches[1]) ? $matches[1] : $this->$default_tmpl_var_key;
        }
    }

    // parse and replace the placeholders
    private function _parse_tmpl($tmpl, $data) {
        if (is_array($data)) {
            foreach ($data as $search => $replace) {
                $search = '((' . $search . '))';
                $tmpl = str_replace($search, $replace, $tmpl);
            }
        }

        return $tmpl;
    }

    // parses the shortcodes
    private function _parse($text) {
        preg_match_all('/\(\((.*)\)\)/i', $text, $matches);
        if (is_array($matches) && isset($matches[1]) && count($mathes[1] > 0)) {
            foreach($matches[1] as $k => $m) {
                $makro = $matches[0][$k];
                $gallery = '';
                $data = explode('|', $m);

                // check for folder
                if (isset($data[0])) {
                    $this->folder = $data[0];
                    $this->folder = rtrim($this->folder, '/') . '/';
                    $image_dir = CMS_ROOT . '/public/images/' . $this->folder;

                    if (is_dir($image_dir) && is_readable($image_dir)) {
                        // check gallery title
                        if (isset($data[1])) {
                            $this->gallery_title = $data[1];
                        } else {
                            $this->gallery_title = false;
                        }

                        // check thumbnail resolution
                        if (isset($data[2]) && strpos($data[2], 'x')) {
                            $res = explode('x', $data[2]);
                            $this->thumb_width = $res[0];
                            $this->thumb_height = $res[1];
                        } else {
                            $this->thumb_width = $this->default_thumb_width;
                            $this->thumb_height = $this->default_thumb_height;
                        }

                        $gallery = $this->_render_gallery($image_dir);
                    }
                }

                // replace makro
                $text = str_replace($makro, $gallery, $text);
            }
        }

        return $text;
    }

    // returns the finished html
    private function _render_gallery($image_dir) {
        // create thumbnails
        if ($this->_create_thumbs($image_dir)) {
            return $this->_create_html($image_dir);
        }
        else {
            return;
        }
    }

    // creates the thumbnails
    // thumbs are rewritten everytime the page is saved
    private function _create_thumbs($image_dir) {
        $handle = opendir($image_dir);
        $count_images = 0;

        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..' && !is_dir($file)) {
                    if(strpos(strtolower($file), '.jpg') || strpos(strtolower($file), '.png') || strpos(strtolower($file), '.gif')) {
                        if(strpos(strtolower($file), '-thumb')) {
                            unlink($image_dir . '/' . $file);
                        } else {
                            $files[] = $file;
                        }
                
                        $count_images++;
                    }
                }
            }
            
            closedir($handle);
        }

        $counter = 0;

        if((int)$this->thumb_width < 1 || (int)$this->thumb_height < 1) {
            //Flash::set('error', 'Specify thumbnail width/height!');
            return false;
        }

        if($count_images == 0) {
            //Flash::set('error', 'There are no images in this folder!');
            return false;
        } else {
            if($files) {
              while ($counter <= count($files) - 1) {
                foreach($files as $file) {
                    $img = $files[$counter]; 

                    // jpg
                    if(substr(strtolower($img), -3) == 'jpg') {
                        $image_type = 'jpg';
                        $starting_image = imagecreatefromjpeg($image_dir . $img);
                    } elseif(substr(strtolower($img), -3) == 'gif') {
                        $image_type = 'gif';
                        $starting_image = imagecreatefromgif($image_dir . $img);
                    } elseif(substr(strtolower($img), -3) == 'png') {
                        $image_type = 'png';
                        $starting_image = imagecreatefrompng($image_dir . $img);
                    }
                    else {
                        $image_type = false;
                    }

                    if ($image_type) {
                        $width = imagesx($starting_image);
                        $height = imagesy($starting_image);

                        $thumb_image = imagecreatetruecolor($this->thumb_width, $this->thumb_height);
                        imagecopyresampled($thumb_image, $starting_image, 0, 0, 0, 0, $this->thumb_width, $this->thumb_height, $width, $height);

                        if ($image_type == 'jpg') {
                            imagejpeg($thumb_image, $image_dir . $img . '-thumb.jpg');
                        } elseif ($image_type == 'gif') {
                            imagegif($thumb_image, $image_dir . $img . '-thumb.gif');
                        } elseif ($image_type == 'png') {
                            imagepng($thumb_image, $image_dir . $img . '-thumb.png');
                        }
                    }

                    $counter++;
                }
              }
                
              //Flash::set('success', 'Thumbnails are successfully created!');
              return true;
            }
        }
    }

    // generates the html for a single gallery (container + title + images)
    private function _create_html($image_dir) {
        $fullpath = str_replace('?', '', BASE_URL) . 'public/images/' . $this->folder;
        
        $handle = opendir($image_dir);
        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..' && strpos($file,'-thumb')) {
                    $files[] = $file;
                }
            }
            closedir($handle);
        }
        
        $images = count($files);
        $counter = 1;
        $html = '';
        $sub_html = '';
        $gallery_title = $this->gallery_title ? md5($this->gallery_title) : '';

        if(count($files)) {
            if ($this->gallery_title) {
                $sub_html.= $this->_parse_tmpl($this->title_tmpl, array('title' => $this->gallery_title));
            }

            while ($counter <= $images) {
                foreach($files as $file) {
                    $counter++;
                    $str = str_replace('_', ' ',$file);
                    $fullpath = str_replace(ADMIN_DIR . '/', '', $fullpath);
                    $thumb_url = $fullpath . $file;
                    $image_url = preg_replace('/-thumb.*/', '', $thumb_url);

                    $sub_html.= $this->_parse_tmpl($this->image_tmpl, array(
                        'title' => $gallery_title,
                        'image' => $image_url,
                        'thumb' => $thumb_url
                    ));
                }
             }

             $html = $this->_parse_tmpl($this->gallery_tmpl, array('gallery' => $sub_html));
        }
        
        return $html;
    }
}
