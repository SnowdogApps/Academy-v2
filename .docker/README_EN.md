## Wihajster - Docker environment

#### Before the first run

Create a file `.env` in the `.docker` directory. You can base on `.env.example` file from the same directory and fill in the missing values.

Add the following entry to your `/etc/hosts` file:
```
127.0.0.1 wihajster.test
```
The application will be accessible via the `http://wihajster.test` link.

#### First run
```
./dc.sh init
```
The above command will download the necessary docker images and start the containers. It will also perform the initial setup and import database and media files.

#### Managing the application
* `./dc.sh up` - start the containers
* `./dc.sh down` - destroy the containers
* `./dc.sh import_db <file.sql>` - import the provided SQL dump 
* `./dc.sh import_media <media.zip>` - import media files

#### Useful links
* [Wihajster Home Page](http://wihajster.test)
* [Wihajster Admin Panel](http://wihajster.test/admin) - login credentials `admin / password123`
* [MailHog](127.0.0.1:8025) - email testing tool, all emails sent from the application will be visible in this panel

#### Troubleshooting

##### 1. Error while running Catalog Search indexer.

When running Catalog Search indexer you get the following error:

```
{"error":{"root_cause":[{"type":"cluster_block_exception","reason":"blocked by: [FORBIDDEN/12/index read-only / allow delete (api)];"}],"type":"cluster_block_exception","reason":"blocked by: [FORBIDDEN/12/index read-only / allow delete (api)];"},"status":403}
```

It means that there is low space on the hard drive and Elasticsearch automatically switches to a read-only mode. The obvious solution is to free up some disk space. Another solution is resetting the read-only setting by sending the following request to the Elasticsearch:

```
curl -XPUT -H "Content-Type: application/json" http://localhost:9200/_all/_settings -d '{"index.blocks.read_only_allow_delete": null}'
``` 
