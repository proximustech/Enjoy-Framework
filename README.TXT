DIRECTORIES OF THE ENJOY MVC APPLICATION SERVER
===================
root
|__	applications: each subdirectory in this directory represents an application.
|	|__	appServerConfig.php : various global parameters of the application server
|	|__ basicExample : Directory with a really basic MVC application
|		|__ config.php : application configuration file
|		|__ layout.php : application layout
|		|__ modules : Directory containing the modules of the application
|			|__ home : a module for the example
|				|__ controller_home.php : main controller for the module
|				|__ models : Directory containing the models for the module
|				|__ views : Directory containing the views for the module
|__	assets: various useful files and libraries like images,css,java script etc.
|__	dataRep: data Repositories for the application server
|__	lib: php libraries for the common use within the application server and Its applications


HOW TO CALL THE basicExample APPLICATION
===================

index.php?app=basicExample&mod=home&act=index

Above, app means application, mod module and act action wich is the method inside the module controller.

HOW TO USE THE CRUD FUNCTIONALITIES
===================
Visit http://www.enjoyframework.com and watch the videos

More documentation comes soon!!!