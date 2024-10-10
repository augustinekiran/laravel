
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
  php artisan cache:clear
```
```bash
  php artisan config:cache
```
```bash
  php artisan view:cache
```
```bash
  php artisan route:cache
```

### Setup Queue Worker
```bash
  php artisan queue:work
```

### Run the Development Server
```bash
  php artisan serve
```

## Login to the Project

#### Login

```http
  http://localhost:8000/
```

#### Credentials

| Username | Password |
|----------|----------|
| `admin`  | `123456` |
