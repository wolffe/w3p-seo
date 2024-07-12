=== W3P SEO ===
Contributors: butterflymedia
Tags: seo, sitemap, local, google, webmaster
Requires at least: 4.9
Requires PHP: 7.1
Requires CP: 2.0
Tested up to: 6.6
Stable tag: 1.8.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

W3P SEO provides the minimum SEO/SEM/local/marketing options for any site owner.

== Description ==

W3P SEO has options for search engines, such as ownership verification, local business JSON-LD data, Open Graph, analytics, header and footer easy code insertion and optimized SEO defaults.

W3P SEO also features native XML sitemaps and advanced topic clustering settings.

For support, feature requests and bug reporting, please visit the [official website](https://getbutterfly.com/wordpress-plugins/ "getButterfly").

== Installation ==

Upload and activate the plugin.

== Screenshots ==

1. Search Engine Verification And Link Relationships
2. Homepage Details
3. Local Business Details
4. Analytics and Tag Management
5. Header/Footer Management
6. Open Graph
7. Miscellaneous
9. Plugin Dashboard

== Changelog ==

= 1.8.0 =
* FIX: Fix Link Whisper feature to use word boundaries, excluding words already inside `<a>` tags
* FIX: Fix excerpt not working with ClassicPress
* UPDATE: Implement custom meta field for meta description as a fallback for excerpt
* UPDATE: Remove Web of Trust verification
* UPDATE: Remove Majestic verification

= 1.7.7 =
* UPDATE: Update WordPress compatibility
* UPDATE: Add FAQs to supported custom post types
* UPDATE: Add robots meta to complement the header

= 1.7.6 =
* FEATURE: Add option to noindex URLs with query strings

= 1.7.5 =
* FIX: Change meta meter functionality to respond to `input` instead of `keyup` events
* FIX: Only loop through content types if XML sitemaps are enabled
* FEATURE: Add Link Whisper functionality (not affiliated with the Link Whisper plugin)
* UPDATE: Update WordPress compatibility

= 1.7.4 =
* UPDATE: Add missing "image" field
* UPDATE: Improve LocalBusiness schema
* UPDATE: Improve image upload functionality
* UPDATE: Update Twitter to X (Twitter)
* UPDATE: Update WordPress compatibility

= 1.7.3 =
* UPDATE: Updated WordPress compatibility

= 1.7.2 =
* UPDATE: Updated WordPress compatibility

= 1.7.1 =
* FIX: Removed property CPT from the list of allowed metabox locations

= 1.7.0 =
* FIX: Fixed description being echoed instead of returned in the `<head>` element
* FIX: Fixed Open Graph tags property names
* FIX: Fixed WPCS (WordPress Coding Standards)
* UPDATE: Added extra Open Graph tags for Twitter Cards and Pinterest
* UPDATE: Removed old `secure_url` image Open Graph tag
* PERFORMANCE: Joined all `wp_head` actions into one
* PERFORMANCE: Changed several options into variables so they can be reused without having to query the database

= 1.6.1 =
* FIX: Fixed auto-adding image attributes from image filename
* FIX: Fixed Schema generating empty image dimensions
* FIX: Sanitized Schema excerpt for the description field

= 1.6.0 =
* UPDATE: Updated author banner
* UPDATE: Updated WordPress compatibility
* UPDATE: Removed unused option (readonly)

= 1.5.9 =
* UPDATE: Added Yoast migrator (temporary)
* UPDATE: Added Meta report for posts

= 1.5.8 =
* FIX: Fixed subpages container not being properly closed

= 1.5.7 =
* FIX: Fixed admin scripts not being enqueued due to broken dependencies
* UI: Improved layout of meta report

= 1.5.6 =
* FIX: Fixed excerpt generation (faster now)
* FIX: Merged two options
* FEATURE: Added Meta Report, similar to Screaming Frog, showing page titles and descriptions

= 1.5.5 =
* FIX: Fixed HTML tags in Schema description/excerpt
* FIX: Fixed duplicate meta description
* UPDATE: Added option to enable/disable SEO title
* UPDATE: Added option to enable/disable SEO meta description
* UPDATE: Improved the [subpages] shortcode

= 1.5.4 =
* UPDATE: Updated SEO title and meta description logic
* UPDATE: Added character counter/meter for SEO titles and meta descriptions

= 1.5.3 =
* FIX: Fixed Sitelinks schema for potentialAction

= 1.5.2 =
* FIX: Fixed several issues with breadcrumbs
* FEATURE: Added better breadcrumbs

= 1.5.1 =
* FIX: Fixed several typos
* FEATURE: Added topic clustering settings
* UPDATE: Started plugin rebranding to W3P
* UPDATE: Updated UI for more intuitive options

= 1.5.0 =
* FIX: Removed unused Facebook administrator ID option
* FEATURE: Added Knowledge Graph Schema details
* FEATURE: Added custom title
* FEATURE: Added excerpt as custom meta description

= 1.4.11 =
* FEATURE: Added native WordPress XML sitemaps
* FEATURE: Added option to automatically add image caption, description and ALT text from image title for all new uploads
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated WPCS (WordPress Coding Standards)

= 1.4.10 =
* FIX: Removed broken custom sitemap functionality
* UPDATE: Updated WordPress compatibility

= 1.4.9.1 =
* UPDATE: Updated WordPress compatibility

= 1.4.9 =
* UPDATE: Updated WordPress compatibility

= 1.4.8 =
* UPDATE: Updated WordPress compatibility

= 1.4.7 =
* FIX: Removed all references to `codor` class
* UPDATE: Updated all non-secure Schema URL to HTTPS

= 1.4.6 =
* UPDATE: Updated WordPress compatibility
* UPDATE: Removed GIT2SVN integration as it's not feasible
* UPDATE: Renamed stylesheet to avoid conflicts with other getButterfly plugins
* PERFORMANCE: Removed custom fonts for code blocks for WordPress Dashboard

= 1.4.5 =
* FEATURE: Added sitemap feature

= 1.4.4 =
* FIX: Fixed excerpt generation (strip shortcodes and remove tags)

= 1.4.3 =
* FIX: Fixed excerpt generation
* FIX: Fixed custom excerpt not being generated for homepage
* UPDATE: Admin UI tweaks

= 1.4.2 =
* UPDATE: Removed Facebook admin ID from Open Graph tags
* UPDATE: Added `og:image:alt` to Open Graph tags

= 1.4.1 =
* UPDATE: Added missing Open Graph tags
* UPDATE: Unified meta description and Open Graph tags
* UPDATE: Added excerpt to pages by default

= 1.4.0 =
* UPDATE: Changed styling of code elements
* UPDATE: Set up groundwork for improved breadcrumbs
* UPDATE: Set up groundwork for improved page descriptions

= 1.3.12 =
* UPDATE: Updated WordPress compatibility
* UPDATE: Incremental testing GIT2SVN

= 1.3.6 =
* UPDATE: Updated help text for custom homepage description
* DEVELOPMENT: Restarted development on GitHub

= 1.3.5 =
* UPDATE: Removed Google+ integration
* UPDATE: Updated PHP requirements
* UPDATE: Updated WordPress compatibility

= 1.3.4 =
* FIX: Removed unused shortcode parameter
* UPDATE: Updated WordPress compatibility

= 1.3.3 =
* UPDATE: Updated string/variable sanitisation

= 1.3.2 =
* UPDATE: Updated plugin name to avoid confusion
* FIX: Fixed readme.txt version

= 1.3.1 =
* UPDATE: Added Baidu verification tag
* UPDATE: Updated Google Tag Manager loading priority
* UPDATE: Removed Google Tag Manager (noscript)

= 1.3.0 =
* UPDATE: Updated WordPress compatibility
* FIX: Added missing Google Analytics and Google Tag Manager tags
* FIX: Added missing header and footer tags
* FIX: Added missing content

= 1.2.1 =
* UPDATE: Updated WordPress compatibility
* FIX: Removed unused files and functions
* FIX: Removed deprecated links
* FIX: Added missing styles (backend)

= 1.2 =
* FIX: Removed double variable declaration
* FIX: Removed unused (inherited) variable declaration
* UPDATE: Moved plugin to Settings area to unclutter menu
* UPDATE: Removed unused welcome mat feature
* UPDATE: UI tweaks
* PERFORMANCE: Removed unused code, fixed line endings and added PSR code changes

= 1.1.3 =
* FEATURE: Added microdata breadcrumbs (unstyled)

= 1.1.2 =
* FIX: Google Tag Manager script position

= 1.1.1 =
* FIX: Fixed excerpt not being generated from the post/page content
* FIX: Fixed settings page description

= 1.1.0 =
* FEATURE: Added welcome mat (scroll mat) feature
* FIX: Fixed performance

= 1.0.4 =
* FIX: Unified gbad.css styles (.codor)
* UPDATE: Removed Google Maps as it now requires a key and a developer account

= 1.0.3 =
* UI: UI and wording tweaks
* UI: Added sharing debugger link for Open Graph/Facebook
* FIX: Added OG schema to DOCTYPE only if Open Graph option is checked
* FIX: Fixed excerpts for SEO description
* FIX: Fixed DOCTYPE prefix for Open Graph
* UPDATE: Added OG default image option
* UPDATE: Added post image capture if no default image or post thumbnail is set
* UPDATE: Added excerpts to pages

= 1.0.2 =
* FIX: Fixed an issue with description improperly escaping quotes
* FIX: Removed version, path and URL constants
* FIX: Removed globally set option
* FIX: Code cleanup
* UPDATE: UI tweaks and section links
* UPDATE: readme.txt improvements
* FEATURE: Added Majestic SEO verification

= 1.0.1 =
* UPDATE: Changed several option names to better reflect the plugin

= 1.0.0 =
* FIX: Removed unsafe built-in security module
* FIX: Better plugin security
* FIX: Removed unused /languages/ directory
* FIX: Renamed some functions to avoid conflicts
* FIX: Removed old Google Maps JS API
* FIX: Added capability check for option saving
* FIX: Removed deprecated contact form feature

= 0.6.4 =
* FIX: Removed tags from og:title content
* FIX: Fixed old support link

= 0.6.3 =
* FIX: Fixed community translations for WordPress 4.6+
* FIX: Fixed several label targets
* UPDATE: Added screenshots

= 0.6.2 =
* FIX: Fixed wrong translatable string
* FIX: Removed unused sitemap module

= 0.6.1 =
* FIX: Fixed local business contextual help
* FIX: Fixed code standards
* FIX: Fixed scripts and styles enqueue
* UPDATE: Added more translatable strings

= 0.6.0 =
* UPDATE: Added proper i18n

= 0.5.3 =
* FIX: Added missing module

= 0.5.2 =
* UPDATE: Removed old files

= 0.5.1 =
* UPDATE: File cleanup and description update

= 0.5.0 =
* UI: UI/UX improvements
* FEATURE: Removed Alexa verification as site claiming has been deprecated
* FEATURE: Added Yandex verification
* FEATURE: Added Pinterest verification
* FEATURE: Added Web of Trust verification
* FEATURE: Added Google+ link relationships (profile URL and page URL)
* FEATURE: Added Twitter link relationship
* FEATURE: Added Google Tag Manager
* FEATURE: Added local business details
* UPDATE: Removed several theme-specific and opinionated defaults
* UPDATE: Removed dashboard widget

= 0.4.0 =
* FIX: Fixed dashboard beacon
* UPDATE: Removed Compete analytics
* UPDATE: Renamed and tweaked the UI and wording of the Webmaster section
* UPDATE: Updated messages and notifications
* UPDATE: Removed 404 redirection as WordPress does the job using canonical redirection
* UPDATE: Removed Google Streetview as it was dependent to an API key
* UPDATE: Removed Yahoo and Ask in SEO Love module
* PERFORMANCE: Added autoloading to options

= 0.3.0 =
* UPDATE: Added getButterfly ad box

= 0.2 =
* UPDATE: Removed Sweeper plugin
* UPDATE: Removed obsolete analytics module
* UPDATE: Removed obsolete sitemap module
* UPDATE: Removed obsolete admin.css
* FIX: Fixed several links
* FIX: Fixed Google Maps URL to automatically pick http:// or https://
* FIX: Added language files

= 0.1.9 =
* FEATURE: Merged WordPress Sweeper plugin
* UPDATE: Removed obsolete SEO tracker module

= 0.1.8 =
* UPDATE: Removed obsolete analytics module
* FIX: Removed old links

= 0.1.7 =
* Fixed Google Streetview (backend)
* Reformatted SEO tracker
* Reformatted plugin dashboard page
* Added dashboard "planet" widget for getbutterfly.com

= 0.1.6.2 =
* Removed deprecated functions from mod-analytics.php
* Fixed unset POST variables in w3p-sitemap.php
* Fixed version number in index.php
* TODO: Include a native WordPress deprecation checker
* TODO: Include a malware check (root string finder)

= 0.1.6.1 =
* Removed empty forms from SEO Tracker
* Removed an inactive function

= 0.1.6 =
* Removed custom login logo (WordPress 3.6 changed the format)
* Removed an erroneus login screen customization
* Removed an inactive function
* Removed Feedburner options as the plugin is outdated, and there was no update from Google for almost 3 years
* Removed all custom dashboard CSS code

= 0.1.5.3 =
* Added media sitemap module
* Added license specification

= 0.1.5.2 =
* Tweaked the Google Maps module (paragraph tag insertion issue)
* Tweaked the Analytics module to work from inside the Perfect Plugin
* Fixed deprecated functions

= 0.1.5.1 =
* Added option to enable/disable analytics module
* Consolidated the SEO tracker
* Merged several options scattered throughout the plugin

= 0.1.5 =
* Merged with SEO Love plugin
* Merged with Smashing Analytics plugin (update/migration is possible)
* Removed hardcoded path

= 0.1.4.2 =
* Added additional (override) style for pages (Google Maps inner images background)
* Improved page speed by removing Google Maps API calls on pages without Google Maps or StreetView
* Removed a getButterfly link
* Removed an empty header call

= 0.1.4.1 =
* Removed Yahoo Site Explorer as it's no longer relevant

= 0.1.4 =
* Official public release

= 0.1.2.7 =
* Removed a duplicate option
* Fixed Google PageRank URL due the October 2011 algorythm change (changed parameter "search" to "tbr")
* Simplified the SEO Tracker module

= 0.1.2.6 =
* Removed Blog Catalog code
* Removed more useless code from webmaster panel
* Removed warning

= 0.1.2.5 =
* Fixed Bing/Yahoo switched codes

= 0.1.2.4 =
* Added gallery fix
* Fixed Google Streetview icon
* Removed RSS dashboard widget

= 0.1.2.2 =
* Added more custom branding
* Fixed a Google Feedburner warning

= 0.1.2.1 =
* Added page speed tracking for Google Analytics
* Added custom login panel

= 0.1.2 =
* Rewritten basic webmaster settings

= 0.1.1 =
* Added submenus
* Added an options page (currently with email address only)

= 0.1.0 =
* First release (buggy, crippled and alpha quality)
