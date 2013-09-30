#Coagmento Collaboratory
##Overview
Coagmento Collaboratory is a modularized and public use version of the [Coagmento](http://www.coagmento.org/) tool. This project is still under active development, but fully functioning examples can be found in the <b>demo</b> folder of this repository.
##Directories
<dl>
	<dt>core</dt>
	<dd>Contains the core classes for accessing the different components (user, snippet, query, etc.) and useful wrapper classes (session)</dd>
	<dt>db</dt>
	<dd>Contains database schema for MySQL</dd>
	<dt>demo</dt>
	<dd>Contains runnable examples of how you can implement Coagmento</dd>
	<dt>model</dt>
	<dd>Contains UML diagrams of the database</dd>
	<dt>sidebar</dt>
	<dd>Contains the Firefox sidebar plugin</dd>
	<dt>toolbar</dt>
	<dd>Contains the Firefox toolbar</dd>
	<dt>toolbarLogger</dt>
	<dd>Contains API listeners for the toolbar</dd>
	<dt>webservices</dt>
	<dd>Contains the API</dd>
</dl>
<hr/>
##Setup
###Database
The database schema for MySQL can be found in the db folder. This can be imported into your own database with this command:
```
cat db/*.sql | mysql -u <user> -h <host> -p
```
###Environment
This was developed on Apache 2.2.22 with PHP version 5.4.6. At the moment, it has not been tested with other versions of PHP but should at least work with PHP 5.4 and above. To test if your environment is working, try going to demo/index.php.