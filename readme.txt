=== Update Users & Customers using CSV ===
Contributors: passionatebrains
Donate link: https://woocommerceanalytics.com/get-started
Tags: users, customers, update meta, update, csv, bulk update, woocommerce, wordpress, woocommerce customers
Requires at least: 5.0
Tested up to: 5.4
Requires PHP: 7.0
Stable tag: 1.1
Version: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin will help you to update woocommerce customers or/and wp users details in bulk using csv file.

== Description ==
this plugin helps to update customers or users data in bulk using csv file. It will also keep record of which data entry from file is successfully processed and which are not.


= Rules For CSV File =
* File must be comma separated <b>.csv</b> / <b>.txt</b> format.
* Column lables must be same to actual user field name where data needs to be updated.
* File should have one index column which used for finding user for whom data is going to be updated. For example: <b>user_login</b>, <b>username</b>, <b>id</b>, <b>user_id</b>
* Make sure each row of data for user has same number of data elements as many fields we need to update through file.
* If you do not have data of some fields for any user or not want to update some data fileds then you write " <b>skip</b> " in data cell and that perticular data will be skipped for that user.

== Installation ==
* Login as an administrator to your WordPress Admin account. Using the “Add New” menu option under the “Plugins” section of the navigation, you can either search for: "Update users & customers using csv" or if you’ve downloaded the plugin already, click the “Upload” link, find the .zip file you download and then click “Install Now”. Or you can unzip and FTP upload the plugin to your plugins directory (wp-content/plugins/).
* Activate the plugin through the "Plugins" menu in the WordPress administration panel.

== Usage ==

To use this plugin do the following:

* Firstly activate Plugin.
* Go to plugin settings page.
* Upload csv file for bulk update users information.

== Frequently Asked Questions ==

= Does this plugin will have any negative impact on website performance? =
No, this is very light weight plugin and it will have almost zero impact on your website performance.

= Does this plugin will work smoothly with any customized woocommerce installation?=
It may be but we are not 100% guarantee you about this. We tests plugin with standard version of woocommerce only and we not provide any free support for issue arise due to customized version of your any plugins.

== Changelog ==

= 1.0 =
Initial Version of Plugin

== Screenshots ==
1. CSV/TXT File Uploadation Page
2. Rules for Making CSV/TXT File for Bulk USers/Customers information update
3. File Format for making CSV/TXT
4. Data checking process before transferring to database