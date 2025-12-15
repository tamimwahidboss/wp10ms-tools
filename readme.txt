=== WP10MS Tools ===

Tags: webp, svg, uploads, fonts, utility
Contributors: tamimwahid
Requires at least: 4.0
Requires PHP: 5.2
Tested up to: 6.9
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP10MS Tools provides essential tweaks and utilities you usually need multiple small plugins for – all in one lightweight package.

== Description ==

This is an all-in-one lightweight utility plugin designed to bring together common, essential tweaks that improve WordPress performance, security, and usability. It currently provides features for:

Enabling WebP and SVG uploads.
Optimizing general uploads and file management.
Adding site-wide utility and customization options.

== Features ==

* Enable SVG, Ico, WOFF, TTF, WebP uploads
* Disable XML-RPC and REST API for guests
* Classic Editor support
* Custom header/footer scripts
* Remove emojis and bloat
* …and much more

== Installation ==

1. Upload to `/wp-content/plugins/wp10mstools/`
2. Activate through “Plugins”
3. Configure under **Settings → WP10MS Tools**

== Frequently Asked Questions ==

= Does WP10MS Tools work with the Block Editor (Gutenberg)? =
Yes, absolutely. The core features of WP10MS Tools are designed to integrate seamlessly with both the classic editor environment and the modern Block Editor (Gutenberg). The Classic Editor support is an optional feature you can toggle on if needed.

= Why did I get an error when uploading an SVG file? =
You must first enable SVG uploads within the plugin settings. For security reasons, WP10MS Tools relies on a third-party library to sanitize (clean) the SVG files upon upload. Even when enabled, a malicious or malformed SVG file may still be blocked by the sanitizer for your site's safety.

= Does this plugin conflict with other performance or security plugins? =
WP10MS Tools focuses on very specific, common tweaks. Generally, it should not conflict. However, if you use another plugin that performs the exact same action (e.g., another plugin that already disables the REST API, or another plugin that manages WebP conversions), you should disable that specific feature in one of the plugins to avoid redundancy or potential conflicts.

= How do I disable the REST API for guests? =
Navigate to Settings → WP10MS Tools, find the Security tab, and check the option to disable the REST API. This blocks access to the WordPress API endpoints for any non-logged-in user, which is a common security hardening technique.

= Is this plugin lightweight? =
Yes. WP10MS Tools is designed to be extremely lightweight. It only loads its code when it needs to execute a specific action (like handling an upload) or when you are viewing the settings page. It avoids loading unnecessary scripts or styles on the frontend.

== Screenshots ==

== Changelog ==
= 1.0.0 =
* Initial release

== Upgrade Notice ==
= 1.0.0 =
First release!