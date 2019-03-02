#### 16th february 2017 - Version 2.9.3

* Tweak: Added SSL support for Bandsintown widget
* Tweak: Added Vimeo background option
* Fix: YouTube video background fallback on mobile
* Fix: Advanced slider image fallback issue

#### 10th february 2017 - Version 2.8.9

* Tweak: Added WP link helper to insert link easily
* Fix: Advanced slider button link bug
* Fix: CSS fix for advanced slider settings form
* Fix: JS bugs IE11
* Fix: JS bug with YOAST analysis when page is empty

#### 1rst february 2017 - Version 2.8.4

* Tweak: Added YOAST analysis compatibility (still need improvement for live analysis, at the moment, the page needs to be updated)
* Tweak: Added "remove image" button in image set field
* Tweak: Added WP nav menu widget to elements
* Tweak: Added templates filter (wpb_templates)
* Tweak: Added social services filter (wpb_socials)
* Tweak: Improved files inclusion to allow more filtering
* Tweak: Added Mixcloud to social settings
* Tweak: Added default button shape filter (wpb_default_button_shape)
* Tweak: Minor styling improvement
* Fix: Fixed Safari/IOS lazyload bug
* Fix: Icon position

#### 19th january 2017 - Version 2.7.3

* Tweak: Added lazyload option
* Tweak: Added default settings filter (wpb_default_settings)
* Tweak: Added plugin activation hook (wpb_activated)
* Tweak: Added link option to process item
* Tweak: Changed couter up JS script to make it look smoother
* Tweak: Added Linearicons pack
* Tweak: Added Advanced Slider title font familiy option
* Tweak: Added YoutTube to team member socials
* Tweak: Apply overlay for block and section even when no background is set (useful when "transparent option" is set)
* Fix: Duplicated "Image Link" setting field
* Fix: Advanced slider overlay transition glitch with "slide" animation

#### 13th january 2017 - Version 2.6.2

* Tweak: Allow decimal in price tables
* Tweak: Added "Add element" button when container is empty
* Tweak: Improve admin CSS
* Fix: Parallax in TentySeventeen

#### 8th january 2017 - Version 2.5.8

* Fix: Missing editor toggle button when switching back from standard mode

#### 6th january 2017 - Version 2.5.7

* Tweak: Improved dialog box. Now works without jquery UI. It fixes glitch with autofocus and improves speed. Cosmetic improvement to come.
* Fix: Loader not hiding when loading the elements panel

#### 5nd january 2017 - Version 2.5.5

* Tweak: Advanced slide video backgrounds now use HTML5 video to avoid conflict with other players (previously used mejs)
* Tweak: Added "Fill-in-up" button type
* Tweak: Added caption setting to scroll down arrow for full height section
* Tweak: Minor styling improvements
* Tweak: Improved Google font loading with wp_resource_hints filter
* Fix: Link feature in Text block
* Fix: Regex for Cyrillic symbols ц
* Fix: Advanced Slider Target

#### 17th december 2016 - Version 2.4.7

* Tweak: Added WooCommerce "Sale products" element
* Tweak: Added post type option to "Last Post big Slider" (for Wolf Albums, Wolf Videos plugin etc...)
* Fix: Admin menu item missing on some installation (role capability now set to "activate_plugins" to be more permissive)
* Fix: Separator alignment setting
* Fix: Minor CSS fix & improvements

#### 3th december 2016 - Version 2.4.2

* Tweak: Increase text field length
* Tweak: Change separator from comma to line break for autotyping, services and pricing tables
* Tweak: Icons CSS position
* Tweak: Added advanced slide caption options
* Tweak: Added autotype element
* Tweak: Removed minified script options. Now SCRIPT_DEBUG constant must be used.
* Tweak: Improved script enqueuing by adding the wpb_force_enqueue_scripts filter to allow theme to force enqueuing scripts for AJAX navigation for example.
* Fix: Autotyping script path
* Fix: Video background issue on firefox

#### 25th november 2016 - Version 2.3.2

* Tweak: Added filters to add last post shortcode display type from theme

#### 23th november 2016 - Version 2.3.1

* Tweak: Removed theme button style option. Now additional button type can be added from theme.
* Tweak: Minor CSS improvements
* Tweak: Minor PHP improvements
* Fix: Foursquare duplicated in social icons

#### 17th november 2016 - Version 2.2.7

* Tweak: Added lightbox option with fancybox alernative to swipebox
* Tweak: Added apple (itunes) and amazon as social profiles
* Tweak: Set social meta from user profile in plugin settings social tabs on plugin activation
* Tweak: Minor CSS improvements (for twentysixteen theme)
* Fix: Item price element column float

#### 9th november 2016 - Version 2.2.2

* Tweak: Updated Font Awesome to 4.7
* Tweak: Added exclude IDs parameters to last posts shortcode to choose the post to display if needed
* Tweak: Added default widget class to WP widget elements to get the widget theme style
* Tweak: Minor CSS improvement
* Fix: Uppercase cyrilic saving issue
* Fix: Post excerpt lenght
* Fix: Icons in admin resetting

#### 2nd november 2016 - Version 2.1.5

* Tweak: Added include IDs parameters to last posts shortcode to choose the post to display if needed
* Tweak: Minor CSS improvement
* Tweak: Add setting to hide background in mailchimp element
* Fix: 6 columns block layout fix

#### 31th october 2016 - Version 2.1.1

* Tweak: Added theme button style option
* Tweak: Added bleed pixels to full height calculation to avoid "white lines"
* Fix: Typos in admin
* Fix: YouTube closing div

#### 30th october 2016 - Version 2.0.7

* Tweak: Improved CSS grid system
* Tweak: Added file inclusion system to extend the plugin in themes
* Tweak: Added MailChimp settings
* Tweak: Added WordPress common class and markup to widget element
* Tweak: Added last posts big slider
* Tweak: Added "Hide text" option to  last posts elements
* Tweak: Added text size settin to tinyMCE
* Tweak: Updated style for Twentysixteen
* Tweak: Set advanced slider slide default height unit to pixel
* Tweak: Improved settings system
* Tweak: Added background size settings
* Tweak: Added margin and transparent background settings to section
* Fix: Counter up not loading when concatenated script used
* Fix: Slideshow background issue on edge
* Fix: Process display with parallax background
* Fix: "Start now" link in welcome message

#### 20th october 2016 - Version 1.9.1

* Tweak: Added offset to full width section when there is a sticky player
* Tweak: Improved shortcode regex (now supports slovenian alphabet)
* Tweak: Re-organized settings
* Fix: Improved wpb_do_admin_wpb function

#### 15th october 2016 - Version 1.8.7

* Fix: Improved TinyMCE initialization for text editor to fix glitch. Now works on firefox as well.

#### 14th october 2016 - Version 1.8.6

* Tweak: Added custom social icons elements
* Tweak: Makes Bandsintown work on AJAX load
* Tweak: Added artist parameter to Bandsintown elements to allow to display multiple artist event list
* Tweak: Hide Import/Export button if "uploads" folder is not writable
* Tweak: Added font family option to text editor
* Tweak: Improved font loading system
* Tweak: Improved shortcode parsing and improved regular expressions to accept some special characters and cyrilic alphabet
* Tweak: Added video carousel
* Tweak: Added background preview in admin
* Tweak: Added full width button option
* Tweak: Added image preview fallback for image background setting
* Tweak: Improved admin element search filter by adding tags to elements
* Fix: Removed force parallax background on mobile option (too much glitch on touchable devices and not recommended)
* Fix: Add force animation option on mobile (so it's disabled by default)
* Fix: Visual glitch in admin when demo images from import are mixed with actual images in image set field (for slider, image galleries etc...)

#### 8th october 2016 - Version 1.6.9

* Fix: Remove disabled shortcodes to avoid breaking the markup
* Fix: Video opener autoplay when multiple youtube videos
* Tweak: Improve smooth scroll logic
* Tweak: Admin style improvement

#### 6th october 2016 - Version 1.6.6

* Tweak: Fix autofocus glitch in page builder element settings
* Tweak: Fix "click to next section arrow"

#### 5th october 2016 - Version 1.6.4

* Tweak: Added Wolf Playlist element
* Tweak: Change the way to include files to improve security
* Tweak: Added section visibility setting to block type section
* Tweak: Improve Mailchimp error handling
* Tweak: Improve buttons responsive behavior

#### 1rst october 2016 - Version 1.6.0

* Tweak: Added hover image in image element
* Tweak: Added scale effect to image element
* Tweak: Added link option to fittext and bigtext
* Tweak: Added scroll to bottom arrow style option in section settings
* Tweak: Minor styling Improvement

#### 29th september 2016 - Version 1.5.5

* Tweak: Added more HTML tag options to elements that use title tags
* Tweak: Improved Big Text behavior to avoid line overflow

#### 22th september 2016 - Version 1.5.3

* Tweak: Added section background repeat options

#### 20th september 2016 - Version 1.5.2

* Tweak: Moved the tmp WPB export folder into the wp-content/uploads folder (import/export feature) to avoid issues with file permission
* Tweak: Improve responsive behavior in admin interface
* Tweak: Minified JS files to increase performance
* Tweak: Added automatic translation for countdown
* Tweak: Added Big Text element
* Tweak: Added carousel gallery layout option
* Fix: Image element custom URL
* Fix: Mailchimp widget with ajax

#### 6th september 2016 - Version 1.4.3

* Fix: Remove/duplicate element after drag 'n drop

#### 24th august 2016 - Version 1.4.2

* Fix: JS error notice for advanced slide with video background

#### 4th august 2016 - Version 1.4.1

* Fix: TinyMce link feature bug
* Fix: TinyMce quicktags tab
* Fix: Icon color on hover when a custom style is set
* Fix: Page jump on toggle element click
* Fix: Call to action button shape
* Fix: Google font name bug in customizer with italic attribute
* Tweak: Added Mailchimp element
* Tweak: Display slider in post columns element for gallery post format
* Tweak: Improve CSS for theme compatibility
* Tweak: Added Bandsintown plugin element

#### 15th july 2016 - Version 1.3.1

* Fix: minor bug, default image showing in section background settings instead of actual one

#### 13th july 2016 - Version 1.3.0

* Fix: issue when there is multiple author with the last post element

#### 5th july 2016 - Version 1.2.9

* Tweak: minor improvements
* Fix: minor bug fixes

#### 24th june 2016 - Version 1.2.7

* Tweak: minor improvements
* Fix: bugs on template importation
* Fix: "process" elment width issue
* Fix: issue with image size in team member module when "round" image style is set

#### 15th june 2016 - Version 1.2.3

* Fix: additional fixes for firefox

#### 14th june 2016 - Version 1.2.2

* Fix: element panel not opening in firefox
* Tweak: Added "Advanced slider" element

#### 6th may 2016 - Version 1.2.0

* Tweak: Improved text editor loading in modal window

#### 8th april 2016 - Version 1.1.9

* Tweak: Disable scroll on contact map when scrolling the page 

#### 8th april 2016 - Version 1.1.8

* Tweak: Minor improvements
* Tweak: Added video background controls (self hosted video only)

#### 4th april 2016 - Version 1.1.6

* Fix: Youtube Video background admin page builder bug

#### 29th march 2016 - Version 1.1.5

* Fix: Font option in "headline" element
* Fix: Google map width

#### 18th march 2016 - Version 1.1.3

* Fix: Errors with PHP7.0.0
* Other: Unminified fittext jquery script to avoid being flagged as trojan by several antivirus

#### 14th march 2016 - Version 1.1.1

* Fix: Fixed a few errors to improve HTML validation
* Other: Updated swipebox js

#### 10th march 2016 - Version 1.0.9

* Fix: Hide socials ( if any ) in team member element if "Add social profiles" option is off
* Tweak: Social icon color in team member element

#### 09th march 2016 - Version 1.0.7

* Tweak: You can now add "wpb-nav-scroll" class to your menu items to create one-page website
* Tweak: Added warning message for PHP version inferior to 4.0.5
* Tweak: Improved slug sanitization for section anchor
* Tweak: Disable submit button when inserting content to avoid bug

#### 8th march 2016 - Version 1.0.3

* Fix: Image fallback on mobile
* Fix: Don't show content on private or password protected pages
* Tweak: Disable plugin style on albums, videos, and portfolio page (wolf plugins compatibility http://wlfthm.es/7lJ1lD )

#### 3rd march 2016 - Version 1.0.0b

* Initial Release