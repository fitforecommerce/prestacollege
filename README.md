# PrestaCollege
A Prestashop module for use in school classrooms. This module is one of the results of the  project [Fit for E-Commerce](https://fitforecommerce.github.io) which is co-funded by the Erasmus+ programme of the European Union.

## Features
PrestaCollege lets you:

* export and import database and file snapshots of shops which can be easily distributed to student's shops
* create fake customers profiles for your shop

## Todo
- [ ] Add documentation
- [ ] Implement Snapshot process
  - [ ] Add a version check if the database scheme of an export matches the installed version- TODO
  - [X] Export relevant database tables - DONE
  - [X] Export relevant asset folders ('/img', '/modules') as zip - DONE
  - [X] Import database tables from .sql file - TODO
  - [X] Import asset folders from zip file - TODO
- [ ] fake orphaned carts

![Co-funded by the Erasmus+ Programme of the European Union](https://fitforecommerce.github.io/img/co-funded-erasmus+.jpg)