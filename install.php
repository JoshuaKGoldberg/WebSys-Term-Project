<?php
  /* Complete installation script
   * 
   * Starts the system off with a new, blank set of database tables
   * 1. Create the database if it doesn't yet exist
   * 2. Create the `users` table
   * 3. Create the `books` table
   * 4. Create the `history` table
  */
  require_once('settings.php');
  
  // Get a connection to the server (no specific database yet)
  $dbConn = getPDO($dbHost, '', $dbUser, $dbPass);
  
  // 1. Create the database if it doesn't yet exist
  $dbConn->prepare('
    CREATE DATABASE IF NOT EXISTS ' . $dbName
  )->execute();
  // From now on, everything will be in that database
  $dbConn->exec('USE ' . $dbName);
  
  // 2. Create the `users` table
  // * These are identified by the user_id int
  // (this should also be extended for Facebook integration)
  $dbConn->exec('
    CREATE TABLE IF NOT EXISTS `users` (
      `user_id` INT(10) NOT NULL AUTO_INCREMENT,
      `username` VARCHAR(127) NOT NULL,
      `password` VARCHAR(127) NOT NULL,
      `email` VARCHAR(127) NOT NULL,
      `salt` VARCHAR(127) NOT NULL,
      `role` INT(1),
      PRIMARY KEY (`user_id`)
    )
  ');
  
  // 3. Create the `books` table
  // This refers to the known information on a book
  // * These are identified by their 13-digit ISBN number
  // * The authors list is split by endline characters
  $dbConn->exec('
    CREATE TABLE IF NOT EXISTS `books` (
      `isbn` INT(13) NOT NULL,
      `name` VARCHAR(127),
      `authors` VARCHAR(255),
      `genre` VARCHAR(127),
      `edition` VARCHAR(127),
      PRIMARY KEY (`isbn`)
    )
  ');
  
  // 4. Create the `entries` table
  // This contains the entries of books by users
  // * These are also identified by their 13-digit ISBN number
  // * Prices are decimels, as dollars
  // * State may be one of the $bookStates
  // * Action may be one of the $bookActions
  // (this should use `isbn` and `user_id` as foreign keys)
  $dbConn->exec('
    CREATE TABLE IF NOT EXISTS `entries` (
      `entry_id` INT(10) NOT NULL AUTO_INCREMENT,
      `isbn` INT(13) NOT NULL,
      `user_id` INT(10) NOT NULL,
      `name` VARCHAR(127) NOT NULL,
      `price` DECIMAL(19,4),
      `state` ENUM(' . makeSQLEnum($bookStates) . '),
      `action` ENUM(' . makeSQLEnum($bookActions) . '),
      PRIMARY KEY (`entry_id`)
    )
  ');
  
  // 4. Create the `history` table
  // This records an ordered history of all events, with associated rating
  // Each event is listed twice: once for each user's perspective (for rating and action)
  // * These are identified by their event_id (timestamps may not be unique)
  // * Each event has the two users' ids, their event ratings, and the book isbn
  // (this should use `isbn` and `user_id` as foreign keys)
  $dbConn->exec('
    CREATE TABLE IF NOT EXISTS `history` (
      `event_id` INT(10) NOT NULL AUTO_INCREMENT,
      `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `user_rater` INT(10) NOT NULL,
      `user_rated` INT(10) NOT NULL,
      `user_rating` ENUM(' . makeSQLEnum($historyRatings) . '),
      `isbn` INT(13) NOT NULL,
      `action` ENUM(' . makeSQLEnum($bookActions) . '),
      PRIMARY KEY (`event_id`)
    )
  ');
?>