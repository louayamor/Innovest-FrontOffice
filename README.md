Symfony Project README
This is a Symfony project for managing user profiles, businesses, and investors.

Project Structure
The project structure is organized as follows:

config/: Contains configuration files for Symfony.


public/: Publicly accessible directory containing the entry point (index.php) and assets.
src/: Contains PHP source code for the project.


Controller/: Controllers handling web requests.


Entity/: Entity classes representing database tables.


Form/: Form classes for data validation and handling.

Repository/: Repository classes for database queries.

Service/: Service classes for business logic.
templates/: Twig templates for rendering HTML.
templates/: Global Twig templates for layout and partials.
var/: Temporary and cache files used by Symfony.
vendor/: Third-party libraries installed via Composer.
README.md: This file providing an overview of the project.
composer.json, composer.lock: Composer configuration files.
symfony.lock: Symfony CLI configuration file.
Installation
Clone the repository to your local machine:
git clone https://github.com/louayamor/Innovest-FrontOffice
Install dependencies using Composer:
composer install
Configure your database connection in .env file:
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/innovestdb
Create the database and schema:
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
Start the Symfony development server:
symfony server:start
Access the application in your browser at http://localhost:8000.
Usage
Profile Management: Users can manage their profiles, including personal information and profile picture.
Businesses: View a list of businesses, their details, and manage your own businesses.
Investors: Explore investors' profiles and connect with them.
Technologies Used
Symfony 5
PHP 7.x
MySQL
HTML/CSS
Twig Templating Engine
Composer for package management

Contributing
Fork the repository.
Create a new branch (git checkout -b feature/your-feature).
Commit your changes (git commit -am 'Add new feature').
Push to the branch (git push origin feature/your-feature).
Create a new Pull Request.
