# Welcome to Lil' Monkey!

## URL to site : https://lil-monkey.be/

Lil' Monkey is a platform where you can make 1 or multiple babylists for your incoming baby('s). By sharing a link and a password, friends can enter and order some items from the list. It's easy and everyone can do it.

IMPORTANT: When doing a checkout of an item, check your spam folder if you did not receive an email

## Table of Content
  * [What can you do](#what-can-you-do)
    + [User](#user)
      - [View articles](#view-articles)
      - [Creating a list](#creating-a-list)
      - [Overview lists](#overview-lists)
      - [Add products to the list](#add-products-to-the-list)
      - [Review the list and edit](#review-the-list-and-edit)
      - [Review bought items](#review-bought-items)
      - [The babylist URL](#the-babylist-url)
    + [Admin](#admin)
      - [Articles](#articles)
      - [Categories](#categories)
      - [Scraper](#scraper)
  * [Accounts - Sample list](#accounts---sample-list)
      - [premade account](#premade-account)
      - [Sample list](#sample-list)
- [Deployment](#deployment)
    + [Git clone](#git-clone)
    + [Install](#install)
  * [Setup your .env file](#setup-your-env-file)
    + [Database](#database)
    + [Mail service with Mailhog](#mail-service-with-mailhog)
      - [Outlook](#outlook)
    + [Payment with Mollie](#payment-with-mollie)
        * [Mollie Key](#mollie-key)
        * [Ngrok.exe](#ngrokexe)
  * [Download the images](#download-the-images)
  * [You are good to go](#you-are-good-to-go)

## What can you do
### User
#### View articles
In the tab 'Artikelen' you can view all the articles that are currently in the app which you can add to your list. <br>
With the navigation you can navigate to see the articles per shop.
#### Creating a list
A user can create a list in which they enter the name of the baby, the name of the list, a password and a message that the guests can read. 
#### Overview lists
When a user is logged in, they can see an overview of all the lists that they have created. By a simple click on the button you will enter the list. <br>
 In this overview you will not see the list of other uses nor can you enter another person's list. Trying will result in an error message (flash message).
#### Add products to the list
When you enter the list you get an overview of all the products arranged by categories.<br>
 Here you can arrange it by price or name, however you like it. <br>
When you decide that you want to add a certain product to the list, you simply click the '+' icon. <br>
A flash message will appear that the product is succesfully added to the list. <br>
On the top of the page you will see the URL to the list and the password that you have chosen. <br>
You can share this with your friends so they can go buy an item. 

#### Review the list and edit
When you click on the button 'aanpassen/bekijken lijst' you can edit your list's information should you wish to change the password for example. <br>
You can also delete products from your list if you decide that you no longer want them. <br>
A product will not be deletable if it has already been bought by someone. This is visually shown by a greyed out item and a disabled button.
#### Review bought items
Another option is the 'bekijk gekochte producten'. <br>
When you click on this you will get an overview of all the products that have already been bought along with the name and message the people left for you. <br>
There is an option to export the list to an excel file if you prefer this.
#### The babylist URL
When you visit the babylist's URL you will be redirected to a page where they ask for a password. <br>
When you enter the given password by the hosts, you wil enter the 'shop' in which you can add articles to your basket and checkout. <br>
If the order has been succesfully received, you will be redirected to a 'thank you'-page and an email will be send to both the buyer and the host.

### Admin
#### Articles 
Overview of all the articles 
#### Categories
You can see an overview of all the categories and to which shop they belong to.
#### Scraper
Admin can scrape items from certain categories which will add even more products to the database. There is also a download image button to download all the images so that they will be displayed throughout the app.

## Accounts - Sample list

#### premade account
|                |Email                  |Password                         |
|----------------|-------------------------------|-----------------------------|
|Admin|`admin@admin.com`           |"`administrator`"            |
|User         |`tester@test.com`            |"`testaccount`"            |
#### Sample list
|                |list URL                 |Password                         |
|----------------|-------------------------------|-----------------------------|
|Guusje|`localhost:8000/geboortelijst/guusje-5`           |"`guusjeschrijvers`"            |


# Deployment
Let's get this app running local. The following instructions will guide you on how to set it up locally.

###  Git clone
First pull in the project from the git link using git clone.

    git clone https://github.com/gdmgent-webdev2/werkstuk---geboortelijst-gdmgent-nielsminne.git


###  Install 
Before you run the commands in the cli make sure that these extensions are uncommented in your php.ini file

    extension=curl
    extension=fileinfo
    extension=gd ; (important for excel export)
    extension=intl
    extension=mbstring
    extension=exif ; Must be after mbstring as it depends on it
    extension=openssl
    extension=pdo_mysql
    

After you have uncommented the extensions, go to the directory of your file and run composer install & npm install to install all the dependencies needed for this project to run locally.

    composer install
    
    npm install


## Setup your .env file

Create a .env file and copy the values from the .env.example file. Fill in all the following required fields.

run this command to generate a new APP_KEY

    php artisan key:generate

###  Database

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE="name of your database"
    DB_USERNAME=root
    DB_PASSWORD="your password"

### Mail service with Mailhog

To test the mailservice with Mailhog, simply run the mailhog executable and fill in the following data in the .env file

    MAIL_MAILER=smtp
    MAIL_HOST=localhost
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="lilmonkey@gmail.com"
    MAIL_FROM_NAME="Lil Monkey"
    
    
#### Outlook
If you want to use a real email address (e.g. outlook) , then change .env data to the following

    MAIL_MAILER=smtp
    MAIL_HOST=outlook.office365.com
    MAIL_PORT=587
    MAIL_USERNAME='your outlook email'
    MAIL_PASSWORD='your password'
    MAIL_ENCRYPTION=STARTTLS
    MAIL_FROM_ADDRESS="same outlook email address"
    MAIL_FROM_NAME="Your name"

### Payment with Mollie
To set up the payment system with mollie you will need to do a few more steps.
##### Mollie Key
Make a mollie account and in your dashboard go to Developers->Api-keys. 
In this tab you will find a test-API-key. Copy this key and insert it into the .env

    MOLLIE_KEY=YOUR_TEST_KEY

##### Ngrok.exe
Use an application like ngrok and run the executable. Copy the link that you will find in your terminal inside App/Http/Controllers/CheckoutController.php file 
  
    if(App::environment('local')){
    $webhookUrl  =  'insert-your-ngrok-link/webhooks/mollie';
    }

Now you should be all set up to use the mollie payment system.

### Hit it!
Now run the application via the artisan command

    php artisan serve

## Download the images
The application gets the images from the storage but this is not pushed to github. <br>
To display the images you will have to go to the database and set the images table in products to NULL first. <br>
After you have done this, log in as an admin and go to the scraper page. You will find a button called "download foto's". <br>
By clicking this you will download all the pictures and put them in your storage folder under public/images/. <br>

Now run this command to make a symlink to your public folder so the images can be displayed correctly

    php artisan storage:link

Now the storage is linked to the public folder and all images will be displayed.

## You are good to go
Now you are all set up to enjoy the application to the fullest. Enjoy!

