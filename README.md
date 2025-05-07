# USARPS Championship Tracker

A web application for tracking Rock Paper Scissors tournament rounds using PHP and Doctrine DBAL.

## Setup Instructions

1. Install dependencies:
```bash
composer install
```

2. Create the database:
```sql
CREATE DATABASE rps_tournament;
```

3. Import the database schema:
```bash
mysql -u root -p rps_tournament < src/Config/database_schema.sql
```

4. Import the seed data:
```bash
mysql -u root -p rps_tournament < src/Config/seed_data.sql
```

5. Configure your web server to point to the `public` directory.

6. Update database credentials in `src/Config/Database.php` if needed.

## Features

- View tournament rounds
- Add new game rounds
- Delete game rounds
- Responsive design with Bootstrap 5

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer
- Web server (Apache/Nginx)

# WEBT | CORE | Doctrine DBAL

## Overview
The USARPS Championship is scheduled for a comeback - and your company is to develop a tool that allows to log the tournament statistics.
https://www.youtube.com/watch?v=6yrdT5y12kA

## User Story 1
*As a Developer I want to create a responsive prototype HTML page, containing demonstration entries for Rock, Paper, Scissors game rounds, so that the customer can get an impression of the final view.*

### Acceptance Criteria
- A plain HTML prototype exists
- The HTML needs to be responsive 
- The tournament name and date are listed
- A minimum of 5 game rounds are listed (1 game round equals 1 RPS game)
- Each game round features the player, symbol he/she picked (rock, paper, scissors), as well as date and time

## User Story 2
*As a Developer I want to create a database for saving staistics about game rounds, so that the data can later be retrieved and analyzed.*

### Acceptance Criteria
- A relational database is setup on the dev environment per developer
- A table for storing game rounds exists (having attributes with according types)
- The create statements are available as SQL file

## User Story 3
*As a Developer I want to insert test data into the database (aka "seed the database"), so that the retrieval and display of data can later be tested.*

### Acceptance Criteria
- The database contains information about at least 5 rounds of RPS (see user story 2 for a round definition).

## User Story 4
*As a Developer I want to connect the view (see user story 1) with the data from the database and list all entries, so that the information from the database is directly displayed in the final frontend representation.*

### Acceptance Criteria
- The database information is used as data source for the view

## User Story 5
*As a Developer I want to create a webpage that allows to insert new records into the database, so that I can store new information easier.*

### Acceptance Criteria
- A webpage exists that allows to enter relevant information for the record
- The webpage uses Doctrine DBAL to store the information in the database

## User Story 6
*As a Developer I want to create a webpage that allows to delete records in the database, so that I can remove information easier.*

### Acceptance Criteria
- A webpage exists that allows to delete a record from the database
- The webpage uses Doctrine DBAL to delete the information in the database

#### Links
https://my.skilldisplay.eu/en/skillset/88
