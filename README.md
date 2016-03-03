# CS319 Team Se7en - Huddle [![Build Status](https://travis-ci.com/vinlore/huddle.svg?token=zB8c5qdNPFZStxQrWSux&branch=master)](https://travis-ci.com/vinlore/huddle)
A conference Management System for managing and organizing local and international Gobind Sarvar conferences.
- - - -
Readme adapted from https://github.com/angular/angular-seed.

### Prerequisites

You must have PHP, node.js and composer installed. You can get them from [https://www.apachefriends.org/index.html](XAMPP), [http://nodejs.org/](Node.js), and [https://getcomposer.org/](Composer).

### Install Dependencies

We have 3 kinds of dependencies in this project: laravel, tools and angular framework code. The tools help us manage and test the application.

* We get the laravel depencies via `composer`.
* We get the tools we depend upon via `npm`, the [node package manager][npm].
* We get the angular code via `bower`, a [client-side (front-end) code package manager][bower].

We have preconfigured `npm` to automatically run `bower` and `composer` so we can simply do:

```
npm install
```

Behind the scenes this will also call `bower install` and `composer install --prefer-dist`.  You should find that you have two new
folders in your project.

* `node_modules` - contains the npm packages for the tools we need
* `vendor` - contains the required Laravel packages
* `public/assets/libs` - contains the angular framework files (bower components)

`npm install` may give errors while installing `protractor` due to it installing its optional dependency `node-gyp` which requires python, it's okay to ignore it. Instead, you may use `npm install --no-optional` to not display these errors.

### Run the Application

We have preconfigured the project with a simple development web server. The simplest way to start this server is:

```
npm start
```

This will automatically run `npm install --no-optional`, `bower install`, and `composer install --prefer-dist` to install any dependencies.
Followed by `php artisan serve` to launch the development server.

To avoid any installations you can also start the server with:

```
php artisan serve
```

Now browse to the app at `http://localhost:8000/`.

## Directory Layout

Adapted from https://scotch.io/tutorials/angularjs-best-practices-directory-structure.

```
app/ 						// backend laravel api folder
  routes.php                    // where we register the routes of the application
public/                     // frontend angularjs application folder
  shared/                       // acts as reusable components or partials of our site (such as headers/sidebars)
  components/                   // each component is treated as a "mini" Angular app
    home/
      homeController.js         	// controller for the "mini" app
      homeView.html             	// view for the "mini" app
  assets/
      img/                      	// images and icons for your app
      css/                      	// all styles and style related files
      js/                       	// javaScript files written for your app that are not for angular
      libs/                     	// Where we're going to store the bower components
  app.js 
  index.php 					// index.html of the angularjs app
node_modules/               // all the node modules
tests/ 						// test folder
  karma.conf.js                 // config file for running unit tests with Karma
vendor/                     // core of the Laravel application
```

## Testing

There are two kinds of tests in the angular-seed application: Unit tests and End to End tests.

### Running Unit Tests

The angular-seed app comes preconfigured with unit tests. These are written in
[Jasmine][jasmine], which we run with the [Karma Test Runner][karma]. We provide a Karma
configuration file to run them.

* the configuration is found at `karma.conf.js`
* the unit tests are found next to the code they are testing and are named as `..._test.js`.

The easiest way to run the unit tests is to use the supplied npm script:

```
npm test
```

This script will start the Karma test runner to execute the unit tests. Moreover, Karma will sit and
watch the source and test files for changes and then re-run the tests whenever any of them change.
This is the recommended strategy; if your unit tests are being run every time you save a file then
you receive instant feedback on any changes that break the expected code functionality.

You can also ask Karma to do a single run of the tests and then exit.  This is useful if you want to
check that a particular version of the code is operating as expected.  The project contains a
predefined script to do this:

```
npm run test-single-run
```


### End to end testing

The angular-seed app comes with end-to-end tests, again written in [Jasmine][jasmine]. These tests
are run with the [Protractor][protractor] End-to-End test runner.  It uses native events and has
special features for Angular applications.

* the configuration is found at `e2e-tests/protractor-conf.js`
* the end-to-end tests are found in `e2e-tests/scenarios.js`

Protractor simulates interaction with our web app and verifies that the application responds
correctly. Therefore, our web server needs to be serving up the application, so that Protractor
can interact with it.

```
npm start
```

In addition, since Protractor is built upon WebDriver we need to install this.  The angular-seed
project comes with a predefined script to do this:

```
npm run update-webdriver
```

This will download and install the latest version of the stand-alone WebDriver tool.

Once you have ensured that the development web server hosting our application is up and running
and WebDriver is updated, you can run the end-to-end tests using the supplied npm script:

```
npm run protractor
```

This script will execute the end-to-end tests against the application being hosted on the
development server.