<?php
	/**
	 * Database configuration file.
	 * 
	 * If you use a database to store stuff, keep your connection credentials in this file.
	 */

	/**
	 * php.scaffold recommends to use PDO (php data objects) to work with databases.
	 * 
	 * PDO is a database abstraction interface, that supports different databases.
	 * Because MySQL continues to be very prevalent in web developement, this is set as the default
	 * driver. Change this, if you have to or prefer to use an alternative like postgreSQL or sqlite3.
	 */
	define('DB_DRIVER', "mysql");

	/**
	 * Your database username.
	 */
	define('DB_USER', "root");

	/**
	 * Your database password. If this is the empty string or simply 'root', you should definitly change this.
	 */
  	define('DB_PASS', "root");

  	/**
  	 * This is the database host. A a general rule this is set to 'localhost'. Change this, if you want to 
  	 * access a database via remote.
  	 */ 
  	define('DB_HOST', "localhost");

  	/**
  	 * Your database name.
  	 */
  	define('DB_DB',   "database");
?>