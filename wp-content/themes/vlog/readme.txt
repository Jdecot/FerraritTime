== Change Log ==

= 2.2.6 = 

* Improved: WordPress 5.5 compatibility tweaks
* Fixed: Watch later and listen later ajax problem fix (sticky|main and action button cases)
* Added: Shortcode support for FV Flowplayer Video Player plugin
* Added: Support for Fembed and Bitchute
* Fixed: Several minor styling issues

= 2.2.5 = 

* Added: Options to choose multiple stylings for social sharing in the plugin settings in dashboard (Settings -> Meks Easy Social Share)
* Added: Official support for WP Forms WordPress plugin
* Added: Twitch icon for Social menu
* Fixed: Header background image option
* Fixed: Header bottom bar color options (for Layouts 3,4,5,6)
* Fixed: Several minor styling issues

= 2.2.4 = 

* Fixed: Removing modules and sections in admin button not working properly in the previous version

= 2.2.3 = 

* Improved: When video/audio is played in cover, the cover height now works in the respect of "Cover height" option set in Theme Options (i.e. do not resize the cover if the original media element is shorter than cover area)
* Fixed: Several minor styling issues

= 2.2.2 = 

* Fixed: Several minor styling issues

= 2.2.1 = 

* Fixed: Some color options being hidded in (Theme Options -> Content)

= 2.2 =

* Added: Styling support for the latest WordPress blocks (introduced in WordPress 5.2)
* Added: Admin panel styling for WP 5.0+ editor and all blocks
* Modified: Options to choose social networks for sharing are now located in the plugin settings in dashboard (Settings -> Meks Easy Social Share)
* Fixed: Several minor styling issues

Mandatory changes to accommodate the latest Envato/ThemeForest requirements:
* Theme Options panel is removed from the theme. To make it appear again, you need to install and activate Redux Framework Plugin via Appearance -> Vlog plugins
* All theme associated widgets cannot be a part of the theme anymore and are now removed. To get your widgets back, please install and activate Vlog Buddy plugin in Appearance -> Vlog plugins
* Social sharing functionality cannot be a part of the theme anymore. To enable social sharing, please install and activate Meks Easy Social Share plugin in Appearance -> Vlog plugins
* Additional JS field is not allowed in Theme options anymore thus it is removed from the theme. As an alternative, you can use Insert Headers and Footers WordPress Plugin
* Additional CSS field is not allowed in Theme options anymore and is now patched into the WordPress native field in Appearance -> Customize -> Additional CSS

= 2.1 =

* Added: Support for Patreon icon inside social menu in header
* Added: Option to enable/disable automatically playing videos after clicking "play" button in cover area (as some people prefer to have it disabled and rather click twice, because of proper view counting on YouTube)
* Added: Option to customize sticky header layout and also use different elements and different navigation (Theme Options -> Header -> Sticky Header)
* Improved: Option for special tags now accepts multiple tags instead of just one (Theme Options -> Misc.)
* Improved: Styling for Podbean.com embeds on audio/video post formats
* Improved: Quickview option for post layouts now works for both video and audio post formats
* Modified: Removed option to disable YouTube "related" videos after a video is finished as YouTube doesn't support this feature anymore
* Fixed: Pages in admin edit screen not displaying metaboxes when WP 5.x used Classic Editor plugin
* Fixed: Several minor styling issues

= 2.0.3 =

* Added: Styling for Blocks (coming with the new WordPress editor in version 5.0)
* Improved: Fully tested and ready for WordPress 5.0
* Improved: Envato Market plugin is now recommended for theme updates
* Fixed: Series not being displayed in Post admin screen when using Gutenberg plugin
* Fixed: Cover area "do not duplicate" option not working in some cases
* Fixed: Several minor styling issues

= 2.0.2 =

* Added: Initial support for the upcoming new WordPress content editor (Gutenberg)

= 2.0.1 =

* Improved: Support for Patreon icon in social menu
* Fixed: Theme throwing error in old PHP versions (i.e 5.4 and lower)
* Fixed: Few minor styling issues

= 2.0 =

* Added: Option to add category featured image (thumbnail) so it can be displayed in Category modules
* Added: Supports for displaying Custom Post Types in Cover area on Modules Template (if custom post type is registered, it will be detected automatically and you can choose it instead of standard posts)
* Added: Option to enable Subscribe button/icon next to Watch later and Cinema mode icons (Theme Options -> Single Post, Cover area 1 & 2)
* Added: Option to open videos in popup when you click the post thumbnail, instead of opening the post (Theme Options -> Post Layouts)
* Added: Styling support for more video sources: XHamster.com, PornHub.com, Rumble.com, Ustream.tv, Aparat.com
* Added: Options to display child category links on parent category template (Theme Options -> Category Template)
* Added: Blank page template, with which you can display the page content only (optionally without page title, site header and footer)
* Added: Support to display only Primary category feature by Yoast SEO plugin (Theme Options -> Misc.)
* Added: Option to disable ads on specific pages, i.e contact, 404, etc... (Theme Options -> Ads)
* Improved: Now you can separately choose which special elements (watch later, search, etc...) to include in header navigation depending on desktop vs mobile mode (Theme options -> Header -> Main, Responsive)
* Improved: Styling for GDPR cookie consent checkbox field in comment form
* Improved: Password protected functionality is now supported in Modules Template
* Improved: If main navigation is too wide on smaller desktop resolutions, it will be automatically optimized to not overlap with the site logo
* Fixed: Bug with cover videos always being displayed even if posts are restricted with Simple Membership WordPress plugin
* Fixed: Font size options not working properly on specific server configurations
* Fixed: Lost of minor styling issues across various resolutions and browsers


= 1.9 =

* Added: Options to manage font sizes for various text elements through Theme Options panel (Theme Options -> Typography) 
* Added: Support for embedding videos hosted on SproutVideo platform
* Added: Option to pull only Video posts in cover area related/playlist posts (Theme Options -> Single Post -> Video)
* Added: Option to ignore category when pulling prev/next post links for Single Post (Theme Options -> Single Post -> General)
* Added: User login form can be added as a header element (Theme Options -> Header)
* Added: Option to specify "number of words per minute" in order to fine-tune calculation of posts "reading time" (Theme Options -> Misc.)
* Improved: Compatibility for the latest WooCommerce plugin version
* Fixed: Bug with cinema mode not automatically playing videos
* Fixed: Filtering posts by tag in Cover area on Modules template
* Fixed: Problem with WPML special languages not pulling proper post content in cover area
* Fixed: Several minor styling issues in various browsers and special cases


= 1.8.1 =

* Fixed: Links to series/playlists in Series Module and Series Widget not working in latest WordPress version 4.9 
* Fixed: Several minor styling issues

= 1.8 =

* Added: New demo example: Podcast (for using Vlog theme with audio)!
* Added: Option to make video "sticky" while scrolling through single posts (Theme Options -> Single Post -> Video)
* Added: Option to enable playlist mode (related videos) alongside current video in cover area (Theme Options -> Single Post -> Video)
* Added: Option to display Series link in post meta data (All layouts)
* Added: When choosing posts manually inside modules, now you have a quick search field for an easier selection, instead of entering post IDs 
* Added: Option to switch logic from include to exclude when filtering posts by tags or categories in Modules (Modules Template)
* Added: Option to add social menu and/or secondary menus to responsive navigation (Theme Options -> Header -> Responsive)
* Added: Options to remove shadow/gradient styling over images in cover area (Theme Options -> Cover Area -> General)
* Added: Support for Flow Player WordPress plugin. The theme will detect its shortcode and display videos in cover area as for regular WordPress embeds
* Added: Styling support for liveleak.com videos
* Added: vKontakte Share button option (Theme Options -> Misc.)
* Added: Support for paginated pages using <!--nextpage--> tag
* Improved: Video embeds now have the same look in audio posts as in video posts (i.e if you are using YouTube inside audio post in cover)
* Fixed: Several minor styling issues in various browsers and devices

= 1.7 =
* Added: Support for PlayWire videos script embed code
* Added: Option to display custom content inside cover area on modules pages (Modules Template)
* Added: Option to specify custom logo URL if you want to point out logo to different location instead of your home page (Theme Options -> Branding)
* Added: Option to expand some widgets to full-width (300px) inside its container
* Added: Option to choose posts from specific series and also auto detect current serie of a post (Vlog Posts Widget)
* Added: Option to on/off whether to choose related posts from series (Theme Options -> Single Post -> Related)
* Improved: Support for WooCommerce 3.0+
* Fixed: Gallery post format not displaying image captions in pop-up in cover layouts
* Fixed: Demo importer panel not importing nav menus on PHP7
* Fixed: Series template throwing notices when a serie is created via single post admin screen
* Fixed: Several minor styling issues

= 1.6 =
* Added: Complete functionality for Audio posts to work the same way as Videos (i.e. Listen Later)
* Added: Support for Custom Post Types in modules (Modules Template). If website is using custom post type, it will automatically be detected and ready for use.
* Added: Option to temporarily activate/deactivate module (Modules Template)
* Added: Option to choose mini logo as sticky header logo (Theme Options -> Header -> Sticky Header)
* Added: Option to display Cart icon in header if WooCommerce plugin is enabled (Theme Options -> Header)
* Added: Option to disable "related" YouTube videos after currently playing video is finished (Theme Options -> Single Post -> Formats)
* Fixed: Filtering by tag not working in cover area on modules page
* Fixed: Vlog categories and series widgets always showing "count" even if option was unchecked
* Fixed: Cover slider wasn't stopping when video in slider was playing
* Fixed: Several minor styling issues

= 1.5 =
* Added: Support for WooCommerce WordPress plugin
* Added: Support for bbPress WordPress plugin
* Added: Options to display breadcrumbs using SEO by Yoast or Breadcrumb NavXT WordPress plugin (Theme Options -> Misc.)
* Added: Possibility to override layout and sidebar options per each Category or Series separately
* Added: Option to set video posts default layout which may be different from regular posts layout (Theme Options -> Single Post -> Layout)
* Added: Option to define a special tag which can be displayed as a label on post layouts, i.e. posts tagged with HD tag will display "HD" label (Theme Options -> Misc. )
* Added: Option to open regular content images in popup (Theme Options -> Misc.)
* Added: "Custom CSS class" option field for each section and module with which you get a possibility to apply custom styling to a section or a module using CSS
* Added: Support for "vooplayer.com" videos
* Fixed: Ordering (drag and drop) items in "Series module" not working properly (Modules Template)
* Fixed: Author name on author archive not working properly in specific cases in WP 4.7
* Fixed: Minor RTL styling issues


= 1.4.1 =

Fixed: Autoplay slider feature in modules (added in 1.4) not working properly 

= 1.4 =

* Added Support for Wistia video platform
* Added: Option to autoplay (rotate) slider items in cover area (Theme Options -> Cover Area -> General)
* Added: Option to autoplay (rotate) slider items in post modules and category modules
* Added: WhatsApp share button (Theme Options -> Misc.)
* Improved: Restrict Content Pro plugin compatibility - support for videos and other non-standard post formats
* Improved: FontAwesome icon library updated
* Improved: Reading time and excerpt text functionality now works fine for languages with special characters (i.e. Russian, Hebrew, Turkish...)
* Fixed: Password protected posts showing content on non-standard post formats
* Fixed: Full screen icon now appears on default WordPress video player
* Fixed: Demo importer not working on specific server configurations
* Fixed: Some widgets throwing JS errors in "accessibility mode"
* Fixed: Minor styling issues

= 1.3 =

* Added: "X" button in watch later area to for easier posts removal
* Added: Watch later menu in mobile navigation
* Added: Option to load watch later area asynchronously and prevent conflicts with caching plugins (Theme Options -> Misc.)
* Added: Option to display full post content instead of excerpt in Layout A (Theme Options -> Post Layouts)
* Added: More social media icons for header social menu (500px.com, amazon.com, ok.ru, mixcloud.com)
* Improved: Social sharing buttons not working in some specific cases (i.e. having UTF8 characters in post titles)
* Improved: Mobile navigation
* Improved: Theme rendering performances
* Fixed: RTL styles and few minor styling issues
* Fixed: Featured area 1 minor styling issues

= 1.2 =
* Added: Support for Facebook Videos
* Added: Support for JW Player Platform videos
* Fixed: RTL styles and few minor styling issues
* Improved previous/next navigation of single posts on mobile devices


= 1.1 =
* Added: 2 new demo examples in Theme Options -> Demo Importer
* Fixed: Few minor styling bugs

= 1.0 =
* Initial release