<?php
/**
 * ebGallery Plugin view: Documentation
 */
?>

<h1>ebGallery</h1>

<p>Simple gallery plugin for <a href="http://www.wolfcms.org/">Wolf CMS</a>. Easily integrate multiple galleries into your sites.
The galleries are built from folders, previews will be generated when the page is saved.</p>

<p>It is still being developed and new features will continue to be added.</p>

<h2>Usage</h2>

<hr><p><strong>Step 1:</strong> Download an unpack the ebGallery plugin into your <code>wolf/plugins</code> directory into a folder called <code>eb_gallery</code> in your Wolf CMS installation.</p>

<p><strong>Step 2:</strong> Go to you Wolf CMS backend an active the ebGallery plugin.</p>

<p><strong>Step 3:</strong> Under <code>public/images/</code>create a new folder for your gallery and upload your images. The folder permissions <strong>must</strong> be <strong>0777</strong> (write access).</p>

<p><strong>Step 4:</strong> Create and publish an new page. Choose <code>Eb_gallery</code> as page content filter and insert the gallery shortcode (see <em>Shortcodes</em>).</p>

<p><strong>Step 5:</strong> Visit your new page and check if everything is allright.</p>

<h3>Shortcodes:</h3>

<p><strong>Simple gallery</strong></p>

<p><code>((your/gallery_folder))</code> <em>Path to your gallery folder relative from public/images/</em></p>

<p><strong>Gallery with title</strong></p>

<p><code>((your/gallery_folder|Your gallery Title))</code> <em>Path and title are separated with a pipe character |</em></p>

<p><strong>Gallery with title and custom thumbnail size</strong></p>

<p><code>((your/gallery_folder|Your gallery Title|200x200))</code> <em>The thumbnail size is in pixels (width x height)</em></p>

<h2>Template</h2>

<hr><p>If you want to customize the HTML for the gallery, you simply have to edit the <code>gallery.tmpl</code>file in the ebGallery plugin directory <code>wolf/plugins/eb_gallery</code>.</p>

<p>The file is well documented and should itself explain how the template works.</p>

<h2>Lightbox</h2>

<hr><p>If you like you can easily integrate lightbox-galleries into your site. Just download a lightbox script (for example <a href="http://fancyapps.com/fancybox/">fancyBox</a>) and set up the files as documented on the lightbox site or in the readme file. As default selector for the lightbox you can use <code>.gallery a</code>. For example with fancyBox the JS would look like this:</p>

<pre><code>&lt;script type="text/javascript"&gt;
  $(document).ready(function() {
    $('.gallery a').fancybox();
  });
&lt;/script&gt;
</code></pre>

<h2>Feedback</h2>

<hr><p><strong>Report An Issue/Bug</strong></p>

<p>Please report issues on the project’s <a href="https://github.com/jlis/ebGallery/issues">GitHub Issues</a> page.</p>

<p><strong>Comments/Suggestions</strong></p>

<p>If you would like to leave some general feedback, please leave me a mail (see index.php for email address) or write me on skype (raiiid).</p>

<h2>Changelog</h2>

<hr>

<p>More on the project’s <a href="https://github.com/jlis/ebGallery">GitHub Issues</a> page.</p>
