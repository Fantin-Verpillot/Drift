#Drift

Drift is an original social network developed in PHP/Symfony2. Send anonymous bottles containing a message and/or a picture all over the world. Follow your bottle and discover where it has been opened.

## Installation

###1. Get the project

Pull the project in your localhost directory. Start your server.

###2. Install the required dependencies

You will need composer. If you don't have it, follow [this link](https://getcomposer.org/download/ "https://getcomposer.org/download/").
Then, go to the root directory and run:

```shell 
$ composer update
```

###3. Create the database using Doctrine

From the root directory, run:
```shell
$ php app/console doctrine:database:create
$ php app/console doctrine:database:update --force
```

### 4. Load the fixtures

From the root directory, run:

```shell
$ php app/console doctrine:fixtures:load
```

### 5. Launch the website

You can now use the website. The URL depends on the path you chose.
