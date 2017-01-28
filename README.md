# Koken Lightbox Plugin

This plugin adds a buttons to the webpage, which help out with ease to add photos into a special gallery.

Features Include:
* ya
* da

## Resources
This is a default database that we are going to use in this development.

* [Default Database](http://unumstudios.com/lightbox/storage/amp_lightbox_2017-01-27.sql.gz)
* [Default Images](http://unumstudios.com/lightbox/storage/images.zip)

## Project Setup
1. Create a Project Folder
    * This folder is going to be used as a root folder for a Koken Website.
2. Create a new Host in MAMP:
    * hostname: **lightbox.website.dev**
3. Create a new MYSQL database:
    * database name: **unum_lightbox**
3. Install Koken CMS
    * Follow the instructions on this page: http://help.koken.me/customer/portal/articles/632102-installation
    * Move index.php from Koken_Installer.zip into the root folder we created in step 1.
    * Use the database name we created in step 3.
    * Hostname should be **localhost**, Username name & password should be **root**.
4. Clone this GitHub repository into the _rootfolder_/storage/plugins
5. Download the Default Database, import it over the database Koken created.
6. Download the Default Images and extract two folders into _rootfolder_/storage/cache
