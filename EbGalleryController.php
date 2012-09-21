<?php

/*
 * Controller for the documentation page in the Wolf CMS backend
 *
 * This file is part of the ebGallery plugin for Wolf CMS
 */

//security measure
if (!defined('IN_CMS')) { exit(); }

class EbGalleryController extends PluginController {
    function __construct() {
        AuthUser::load();
        if (!AuthUser::isLoggedIn()) {
            redirect(get_url('login'));
        }
 
        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/eb_gallery/views/sidebar'));
    }

    function index() {
        redirect(get_url('plugin/eb_gallery/documentation'));
    }
 
    function documentation() {
        $this->display('eb_gallery/views/documentation');
    }
}