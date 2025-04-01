# Digital Humanities Course Registry

## Application
The application can be found here: https://dhcr.clarin-dariah.eu/

## Release notes
For an overview of the latest changes, check the release notes here: [RELEASE_NOTES.md](RELEASE_NOTES.md)

## Installation in local development environment
The steps below have been tested with Debian Linux 12.9 (Bookworm)
1. Install Docker


https://docs.docker.com/install/linux/docker-ce/debian/

2. Install DDEV


https://ddev.com/get-started/

3. Clone DHCR repo's

(api and core are currently not public available)
```
mkdir $PROJECT_DIR && cd $PROJECT_DIR
git clone git@github.com:acdh-oeaw/dhcr-core-plugin.git
git clone git@github.com:acdh-oeaw/dhcr-api.git
git clone git@github.com:acdh-oeaw/dhcr-main.git
```

4. Install submodules
```
cd $PROJECT_DIR/dhcr-api && git submodule update --init --force --remote
cd $PROJECT_DIR/dhcr-main && git submodule update --init --force --remote
```

5. Start DDEV
```
ddev start
```

6. Add ssh keys to container
```
ddev auth ssh
```

7. Install dependencies
```
ddev composer update
```
(ddev composer install results in more git differences)

8. Import DB

(copy of database is needed)
```
ddev import-db --file=dhcr.sql
```

9. Create .env files
```
cd $PROJECT_DIR/dhcr-main/config && cp .env.default .env
cd $PROJECT_DIR/dhcr-main/api/v2/config && cp .env.default .env
```

10. Generate search list

(only needed for autocomplete in the search bar)
```
ddev exec bin/cake gen_search_list
```

11. Launch application
```
ddev launch
```