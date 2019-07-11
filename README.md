![TravisCI build badge for PrestaCollege](https://travis-ci.com/fitforecommerce/prestacollege.svg?branch=master)

# PrestaCollege
A Prestashop module for use in school classrooms. This module is one of the results of the  project [Fit for E-Commerce](https://fitforecommerce.github.io) which is co-funded by the Erasmus+ programme of the European Union.

## Features
PrestaCollege lets you:

* export and import database and file snapshots of shops which can be easily distributed to student's shops
* create fake customers profiles for your shop

## Todo
- [ ] Add documentation

### Create Snapshots
- [ ] Implement Snapshot process
  - [ ] Add a version check if the database scheme of an export matches the installed version
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
- [ ] fake customer visits (i.e. connections)
- [ ] fake orders by customers
- [ ] fake orphaned carts
- [ ] fake a hacker attack


(c) 2018 Martin Kolb 
issued under the GNU GENERAL PUBLIC LICENSE, Version 3, 29 June 2007

![Co-funded by the Erasmus+ Programme of the European Union](https://fitforecommerce.github.io/img/co-funded-erasmus+.jpg)

The European Commission support for the production of this publication does not constitute an endorsement of the contents which reflects the views only of the authors, and the Commission cannot be held responsible for any use which may be made of the information contained therein.