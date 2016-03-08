# Huddle [![Build Status](https://travis-ci.com/vinlore/huddle.svg?token=zB8c5qdNPFZStxQrWSux&branch=master)](https://travis-ci.com/vinlore/huddle)
A conference management system for organizing Gobind Sarvar conferences.
- - - -
Readme adapted from https://github.com/angular/angular-seed.

### Prerequisites

You must have PHP, node.js and composer installed. You can get them from [https://www.apachefriends.org/index.html](XAMPP), [http://nodejs.org/](Node.js), and [https://getcomposer.org/](Composer).

### Install Dependencies

We have 3 kinds of dependencies in this project: Laravel, tools, and AngularJS. The tools help us manage and test the application.

* We get the Laravel depencies via `composer`.
* We get the tools we depend upon via `npm`, the Node Package Manager.
* We get the AngularJS code via `bower`, a client-side (front-end) code package manager.

We have pre-configured `npm` to automatically run `bower` and `composer` so we can simply do:

```
npm install
```

Behind the scenes this will also call `bower install` and `composer install --prefer-dist`. You should find that you have two new
folders in your project.

* `node_modules` contains the npm packages for the tools we need.
* `vendor` contains the required Laravel packages.
* `public/assets/libs` contains the AngularJS framework files (Bower components).

`npm install` may give errors while installing `protractor` due to it installing its optional dependency `node-gyp` which requires Python, it's okay to ignore it. Instead, you may use `npm install --no-optional` to not display these errors.

### Running the Application

We have pre-configured the project with a simple development web server. The simplest way to start this server is:

```
npm start
```

This will automatically run `npm install --no-optional`, `bower install`, and `composer install --prefer-dist` to install any dependencies.
Followed by `php artisan serve` to launch the development server.

To avoid any installations you can also start the server with:

```
php artisan serve
```

Now browse the application at `http://localhost:8000/`.

## Directory Layout

Adapted from https://scotch.io/tutorials/angularjs-best-practices-directory-structure.

```
app/                        // Laravel application
  routes.php                // Application routes
public/                     // AngularJS application
  shared/                   // Reusable components (e.g. headers and sidebars)
  components/               // Each component is treated as a "mini" app
    home/                   // Example of a "mini" AngularJS app
      homeController.js     // Controller for the "mini" app
      homeView.html         // View for the "mini" app
  assets/
      img/                  // Images and icons
      css/                  // Stylesheets
      js/                   // JavaScript files
      libs/                 // Bower components
  app.js 
  index.php                 // index.html
node_modules/               // Node.js modules
tests/                      // Test folder
  karma.conf.js             // Config file for Karma unit tests
vendor/                     // Laravel core
```

## Testing

There are two kinds of tests in this application: Unit tests and end-to-end tests.

### Unit Testing

The application comes pre-configured with unit tests. These are written in
Jasmine, which we run with the Karma Test Runner. We provide a Karma
configuration file to run them.

* The configuration is found at `karma.conf.js`
* The unit tests are found next to the code they are testing and are named as `..._test.js`.

The easiest way to run the unit tests is to use the supplied npm script:

```
npm test
```

This script will start the Karma test runner to execute the unit tests. Moreover, Karma will sit and
watch the source and test files for changes and then re-run the tests whenever any of them change.
This is the recommended strategy; if your unit tests are being run every time you save a file then
you receive instant feedback on any changes that break the expected code functionality.

You can also ask Karma to do a single run of the tests and then exit. This is useful if you want to
check that a particular version of the code is operating as expected. The project contains a
predefined script to do this:

```
npm run test-single-run
```


### End-to-End Testing

The application comes with end-to-end tests, again written in Jasmine. These tests
are run with the Protractor end-to-end test runner. It uses native events and has
special features for AngularJS applications.

* The configuration is found at `e2e-tests/protractor-conf.js`.
* The end-to-end tests are found in `e2e-tests/scenarios.js`.

Protractor simulates interaction with our application and verifies that the application responds
correctly. Therefore, our web server needs to be serving up the application, so that Protractor
can interact with it.

```
npm start
```

In addition, since Protractor is built upon WebDriver we need to install this. This
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
