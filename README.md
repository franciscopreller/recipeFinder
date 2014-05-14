
Recipe Finder
========

### Excercise Instructions

Given a list of items in the fridge (presented as a csv list), and a collection of recipes (a collection of JSON formatted recipes), produce a recommendation for what to cook tonight.

Program should be written to take two inputs; fridge csv list, and the json recipe data. How you choose to implement this is up to you; you can write a console application which takes input file names as command line args, or as a web page which takes input through a form.

The only rule is that it must run and return a valid result using the provided input data.


----------

### Installation

Get the repository locally. Curl, git, wget all work, here is some code:

> $ git clone https://github.com/franciscopreller/recipeFinder.git

Navigate to the root directory and update all composer packages.

> $ composer update

At the end of the process, composer will ask for some final options, just hit enter to all of them. They are unecessary to run this application (I've chosen not to use a database for this demo, so no concerns there).

> *Don't have composer? Download it following the instructions on http://getcomposer.org/*

Finally, you can check that Symfony2 has all its required settings by running the following command (please note, warnings may or may not affect your output):

> $ php app/check.php

All done!

---------

### Running the Recipe Finder

There are two ways to run the Recipe Finder, as a console application which takes actual files as input, or through the web application, which provides a GUI for all inputs.

#### Run via Web Browser

If you enjoy the luxury of PHP > 5.4 (which you should), you don't need to concern yourself with a proper web server, simply run the following command:

> $ php app/console server:run

You will notice the following output:

> Server running on http://localhost:8000

At this point, head to the provided address and take it from there, further instructions will be provided on the interface where necessary.

#### Run via Console


----------

### Testing

The project was developed using TDD. The full suite of unit tests can be run by the following command from the root of the project:

> $ phpunit -c app src/FP/RecipeFinderBundle/
