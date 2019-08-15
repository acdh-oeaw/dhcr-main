# DHCR-Frontend
Frontend UI for the Digital Humanities Course Registry

## Setup
The project is build using composer. 
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
    |__... (other source code)
```

Run following command to make them writable:
```bash
HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
setfacl -R -m u:${HTTPDUSER}:rwx tmp
setfacl -R -d -m u:${HTTPDUSER}:rwx tmp
setfacl -R -m u:${HTTPDUSER}:rwx logs
setfacl -R -d -m u:${HTTPDUSER}:rwx logs
```



