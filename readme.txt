=== Cleanup Text ===
Contributors: roggie
Donate link: http://www.rogerh.com/donate.html
Tags: Filter, Smart Quotes, HTML, Special Characters
Requires at least: 1.0.0
Tested up to: 3.0.0
Stable tag: 2.0.1

Function to remove smart quotes, HTML and other special characters from text. Call the function with text as argument, function returns clean text.

== Description ==

WordPress posts and pages can contain Smart quotes and other fancy characters. But Smartquotes and other special characters don't work properly if you send the contents of a post by email. This plugin cleans up text so it can be emailed properly.

Instead of using this plugin you could use WordPress filters to reformat text, but WordPress filters cannot be used with PHP functions like strip_tags. If you use a filter to remove Smart quotes you can't also use strip_tags to remove HTML.

Also, WordPress filters don't remove all the characters that could cause problems. For example, double spaces are not removed properly by WordPress, and Europeans will have problems with the UK pound currency symbol.

This very simple plugin removes all sorts of special characters, including double spaces and currency symbols that WordPress filters don't manage.

It also has an option to remove HTML.

== Installation ==

1) Copy the file cleanup_text.php to your WordPress plugins directory.

2) Login to WordPress as an administrator, go to Plugins and Activate it.

3) Call the plugin anywhere in your theme or other PHP code.

 E.g. replace "the_content()" with "cleanup_text( the_content() )"

== Frequently Asked Questions ==

**How do I use the plugin?**<br />
Call the function cleanup_text() from within your theme or other plugin. Supply the text to be cleaned as the first argument.<br />
E.g. `<?php $clean_text = cleanup_text( $text_to_clean ) ; ?>`

**How do I get the plugin to remove HTML?**<br />
Call the function with TRUE as the second argument.<br />
E.g. `<?php $clean_text = cleanup_text( $text_to_clean, TRUE) ;  ?>`

**Can I use cleanup_text for web pages?**<br />
Yes, you could use cleanup_text to clean text that will be displayed on a web page. You would probably use something like:<br />
E.g. `<?php echo cleanup_text( get_the_content() ) ; ?>`

But the results will probably not be what you want because cleanup_text uses "\n" for new lines, and web pages use `<br />` or some other HTML notation.

If you really want to do this let me know and I'll update the plugin so it can be used in this way.

== Screenshots ==

No screenshots.

== Changelog ==

For changelog please visit http://www.thehypervisor.com/cleanup-text/
