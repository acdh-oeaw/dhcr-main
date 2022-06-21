# The Digital Humanities Course Registry - DHCR

## Release notes
Release notes of the latest version can be found here: [RELEASE_NOTES.md](RELEASE_NOTES.md)

## Old content
The text below is outdated and needs to be updated:

The applications currently consists of three sub-apps.___
This is the DHCR Front-End and the site's main entry point, which resembles all publicly available parts of the DHCR. 
The administrative back-end (contributors, moderators and admins) is plugged in as a submodule in the directory `ops` (operations), while the JSON-API is made available `api/v1` (eventually incompatible new API versions will get their own directory, while maintaining the legacy version). 
The back-end app holds CakePhp 2.x legacy code, that in future will be migrated to CakePhp 3.x and integrated into the DHCR front-end main app. 
All three applications can be installed, used and developed separately in different locations or containers. However, they are meant to appear as one single site and are therefore joined as follows:
```
<installation_directory>
    |
    |__ops	(the administrative back-end)
    |
    |__api
    |	|
    |	|__v1	(the first API version goes here)
    |
    |__...	(all other front-end code)
```

## Setup
The front-end project is build using composer. 
See instructions on how to install composer and 
CakePhp specific instructions here: 
https://book.cakephp.org/3.0/en/installation.html

After downloading/cloning the repository, run
```bash
php composer.phar update
```

If not present, create directories logs and tmp:
```
<installation_directory>
    |
    |__logs
    |
    |__tmp
    |
    |__...
```

Run following command to make them writable:
```bash
HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
setfacl -R -m u:${HTTPDUSER}:rwx tmp
setfacl -R -d -m u:${HTTPDUSER}:rwx tmp
setfacl -R -m u:${HTTPDUSER}:rwx logs
setfacl -R -d -m u:${HTTPDUSER}:rwx logs
```

## Database
You'll require a dump from the production database. CakePhp connects to most SQL dialects, either MySQL, Postgres, MariaDB etc.

## Configuration
The application reads all configuration constants from environment variables present on the system or docker container. 
Each partial app (Front-End, Back-End, API) can be run standing alone without the environment variables being present, eg. for local development. The required settings are then exported on runtime from an .env file present in the applications config directory. Overriding any already present environmental configuration from local file is prohibited, if the variable `DHCR_ENV` is present and TRUE. 

To connect to databases, provide required access keys, set debug level or interconnect the, use the .env.default file as a template. 
```
<installation_directory>
	|
	|__config
		|
		|__.env.default
```

Make sure the file's contents are interpreted on container startup globally or use the renamed local file for development:
```
<installation_directory>
	|
	|__config
		|
		|__.env
```
