## Overview
This is a Dockerfile/image to build a container with nginx and php-fpm, The goal of this docker container is to grab read only details of sonarr/radarr and display them for your users.

If you have improvements or suggestions please open an issue or pull request on the GitHub project page.

### Versioning
| Docker Tag | Git Release | Nginx Version | PHP Version | Alpine Version |
|-----|-------|-----|--------|--------|
| latest | Master Branch |1.14.0 | 7.2.8 | 3.7 |

### Links
- [https://gitlab.com/physk/sonarr-radarr-tracker](https://gitlab.com/physk/sonarr-radarr-tracker)

## Quick Start
To pull from docker hub:
```
docker pull physk/sonarr-radarr-tracker:latest
```
### Running
To simply run the container:
```
sudo docker run -d physk/sonarr-radarr-tracker
```

### Config
edit ```/var/www/config/config.php``` with your details and you're done!