# Rytlock's Forge API

Laravel 11 backend project focused on consuming and synchronizing data from the Guild Wars 2 public API into a relational database.

The project demonstrates external API integration, data transformation, caching, incremental synchronization, batch processing, validation and transactional persistence.

## Main Features

- REST API integration
- External data ingestion and transformation
- Relational data modeling with Eloquent
- Incremental synchronization
- Batch processing in chunks
- Retry and error handling
- Response caching
- Database transactions
- Synchronization tracking
- Artisan command for data import

## Synchronization Flow

1. Fetches available item IDs from the Guild Wars 2 API
2. Removes items already synchronized
3. Splits remaining IDs into batches
4. Retrieves item data from the API
5. Validates and maps the received data
6. Persists items and related records in a transaction
7. Registers successfully synchronized items

## Technologies

- PHP 8.2+
- Laravel 11
- Eloquent ORM
- PostgreSQL / MySQL
- Laravel HTTP Client
- Laravel Cache
- Artisan Commands

## Running the Synchronization

```bash
php artisan app:sync-gw2-items
```
## Getting Started

git clone https://github.com/WillianHoracio/rytlocks-forge-api.git
cd rytlocks-forge-api

composer install
cp .env.example .env
php artisan key:generate

Configure the database in .env

php artisan migrate
php artisan serve
