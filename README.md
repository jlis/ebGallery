#ebGallery#
* * *

Simple gallery plugin for [Wolf CMS](http://www.wolfcms.org/). Easily integrate multiple galleries into your sites.
The galleries are built from folders, previews will be generated when the page is saved.

It is still being developed and new features will continue to be added.


##Usage##
* * *

**Step 1:** Download an unpack the ebGallery plugin inside your `wolf/plugins` directory into a folder called `eb_gallery` in your Wolf CMS installation.

**Step 2:** Go to you Wolf CMS backend an active the ebGallery plugin.

**Step 3:** Under `public/images/`create a new folder for your gallery and upload your images. The folder permissions **must** be **0777** (write access).

**Step 4:** Create and publish an new page. Choose `Eb_gallery` as page content filter and insert the gallery shortcode (see *Shortcodes*).

**Step 5:** Visit your new page and check if everything is allright.

###Shortcodes:###

**Simple gallery**

`((your/gallery_folder))` *Path to your gallery folder relative from public/images/*

**Gallery with title**

`((your/gallery_folder|Your gallery Title))` *Path and title are separated with a pipe character |*

**Gallery with title and custom thumbnail size**

`((your/gallery_folder|Your gallery Title|200x200))` *The thumbnail size is in pixels (width x height)*

##Template##
* * *

If you want to customize the HTML for the gallery, you simply have to edit the `gallery.tmpl`file in the ebGallery plugin directory `wolf/plugins/eb_gallery`.

The file is well documented and should itself explain how the template works.

##Lightbox##
* * *

If you like you can easily integrate lightbox-galleries into your site. Just download a lightbox script (for example [fancyBox](http://fancyapps.com/fancybox/)) and set up the files as documented on the lightbox site or in the readme file. As default selector for the lightbox you can use `.gallery a`. For example with fancyBox the JS would look like this:

```
<script type="text/javascript">
  $(document).ready(function() {
    $('.gallery a').fancybox();
  });
</script>
```

##Feedback##
* * *

**Report An Issue/Bug**

Please report issues on the project’s [GitHub Issues](https://github.com/jlis/ebGallery/issues) page.


**Comments/Suggestions**

If you would like to leave some general feedback, please leave me a mail (see index.php for email address) or write me on skype (raiiid).


##Changelog##
* * *

Nothing yet.
