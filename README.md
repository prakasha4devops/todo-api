TODO REST API
=============

The **TODO REST API** application allows you to have a ready to use REST API 
for a TODO list management.

Installation
------------

Step 1: Download the application
--------------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this application:

.. code-block:: bash

    $ git clone https://github.com/B0ulzy/todo-api.git

Step 2: Setup the application
-----------------------------

First, install the dependencies by executing the following command: 

.. code-block:: bash

    $ composer install

Then, configure your `app/config/parameters.yml`. 

Finally, create your database by executing the following commands: 


.. code-block:: bash

    $ bin/console doctrine:database:create
    $ bin/console doctrine:schema:update --force

Step 3: That's it!
------------------

Your TODO REST API is now ready to use. Use the NelmioApiDoc in dev environment 
to see routes and methods availables. 

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    app/Resources/meta/LICENSE