# How to run?

## first connect to mysql database 

## Migrate the Database

```bash
php migrate.php
```

## Run the Project

```bash
php -S localhost:8000
```

# Seed User Information
```txt
admin@gmail.com (admin)
user@gmail.com (customer)

All password: 1234
```

# How to create admin?

To create admin:
1. Run Following command :

```bash
php admin.php
```
### you can change config file (config/config.php) to `database` or `file`