
# Dynamic Forms

Create dynamic form and allow data update

## Setup Project

### Setup .env File
* Open .env.example and update as .env File

### Update Packages
```bash
  composer install
```

### Migrate Database
```bash
  php artisan migrate --seed
```

### Cache the Files
```bash
  php artian cache:clear
```
```bash
  php artian config:cache
```
```bash
  php artian view:cache
```
```bash
  php artian route:cache
```

### Setup Queue Worker
```bash
  php artian queue:work
```

### Run the Development Server
```bash
  php artian serve
```

## Login to the Project

#### Login

```http
  RouteUrl - '/'
```

#### Credentials

| Username | Password |
|----------|----------|
| `admin`  | `123456` |
