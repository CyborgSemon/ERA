# ERA PHP Fullstack App and Website

### Requirments
---
This is a PHP, MySQL based project so you will need to have the folowing programs installed on your local machine to run the project.
-- A Local server ([MAMP](https://www.mamp.info/en/), [XAMPP](https://www.apachefriends.org/index.html)) or actual server running PHP and MySQL
-- [Composer](https://getcomposer.org/)

Once you have those programs, and either downloaded or cloned this repo, start up your local server and make a new database in PHPMyAdmin. When it is made, go to the import section of the new database and import the file `era.sql`. This will set up your database to be used within the app and website.

Then open up terminal in the root folder and the `app` folder and run this in each of them:
```sh
composer install
```
After you have run that line, duplicate the `.env.example` file and rename it to `.env`.
Then open up the file and add your credentials into each field. Eg:
```
DATABASE_HOST=localhost
DATABASE_USERNAME=root
DATABASE_PASSWORD=root
DATABASE_NAME=era
```
This `.env` file needs to be located one folder above the root folder. This is to improve security by making your database credentials not accessible by anyone using the site
### Development
---
To get started with development on the app and website, open up the root and `app` folders in terminal, and run:
```sh
npm i
```
This will get you setup with [Grunt](https://gruntjs.com/). Once all those packages are installed, whenever you want to develop on the project, open up one of the folders in terminal and run:
```sh
grunt
```
This will start Grunt and make it start watching for file changes in respective folder.

Enjoy :)