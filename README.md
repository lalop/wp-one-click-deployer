
One Click Deployer is a Wordpress plugin that will help you sync your theme between development and production via FTP.

This plugin should only be installed in development environment.
Once installed it will save your ftp login and password in a json file (one-click-deployer.json) at the root of your wordpress, be carreful to not share this file, anyone who can read it can connect to your production server.

![Demo](https://raw.githubusercontent.com/lalop/wp-one-click-deployer/master/demo.gif "One click deployer demo")


CONTRIBUTION
== 

You can contribute via the [development repository](https://github.com/lalop/wp-one-click-deployer) on github.

The simplest way to start to enhance the plugin is by cloning the development repository and using docker-compose.
You should get a wordpress instance with the theme folder mounted for development, a wordpress instance for production, a server ftp and a database with the 2 wordpress initialized. Wordpress administrations are accessible with the login/password admin/admin.