![TravisCI build badge for PrestaCollege](https://travis-ci.com/fitforecommerce/prestacollege.svg?branch=master)

# PrestaCollege
A Prestashop module for use in school classrooms. This module is one of the results of the  project [Fit for E-Commerce](https://fitforecommerce.github.io) which is co-funded by the Erasmus+ programme of the European Union.

## Features
PrestaCollege lets you:

* export and import database and file snapshots of shops which can be easily distributed to student's shops
* create fake data for your shop

## Installation
1. You need a working [Prestashop](https://prestashop.com) installation.
2. Download the latest [PrestaCollege release](https://github.com/fitforecommerce/prestacollege/releases). Make sure to download the prestacollege.zip file!
2. In the Prestashop backend go to the module manager and click 'Upload module'. Drag and drop the prestacollege.zip file onto the dialogue. ![Screenshot add module](https://fitforecommerce.eu/img/2018-09-25-prestacollege-installieren/02_install_module_start.png) ![Screenshot upload module](https://fitforecommerce.eu/img/2018-09-25-prestacollege-installieren/03_upload_module.png)
3. The module should automatically be installed. If the installation fails make sure that your php.ini values for ``upload_max_filesize`` and ``post_max_size`` are set to a larger value than the size of the prestashop.zip file. I would recommend to set the values to ``128M`` - this should also be sufficient for file snapshots.

* 2019-07-21 [Video tutorial [DE]](https://www.youtube.com/watch?v=VhwDSjooOis) on how to import and export snapshots from PrestaCollege
* 2019-06-27 [Video tutorial [DE]](https://www.youtube.com/watch?v=vp7TccnzkQ0) on how to install, import and export snapshots and Jamando shop data

## Todo
### Create Snapshots
- [ ] Implement Snapshot process
  - [ ] Add a version check if the database scheme of an export matches the installed version
  - [ ] Add an option to include/leave out specific tables
  - [X] Export relevant database tables
  - [X] Export relevant asset folders ('/img', '/modules') as zip
  - [X] Import database tables from .sql file
  - [X] Import asset folders from zip file
  - [X] Upload snapshots from remote URL to server
  - [X] Download existing snapshots from the server to your PC
  - [X] Upload snapshot files from your PC to the server
  - [X] Delete a snapshot from the server via the web interface
- [X] add German localization
- [ ] add a popup/banner to avoid real customers from ordering

### Fake stuff
- [X] fake customers
- [ ] fake guests and customer visits (i.e. connections)
- [ ] fake orders by customers
- [X] fake orphaned carts
- [ ] fake a hacker attack
- [ ] fake search terms

(c) 2018-2019 Martin Kolb 
issued under the GNU GENERAL PUBLIC LICENSE, Version 3, 29 June 2007

![Co-funded by the Erasmus+ Programme of the European Union](https://fitforecommerce.github.io/img/co-funded-erasmus+.jpg)

The European Commission support for the production of this publication does not constitute an endorsement of the contents which reflects the views only of the authors, and the Commission cannot be held responsible for any use which may be made of the information contained therein.