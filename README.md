# Simple Bill Payments API

## Objective

This project is a RESTful API for managing a simple bill payments system using Laravel. It includes functionalities for managing users and their transactions.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [Testing](#testing)
- [Postman Collection](#postman-collection)
- [Submission](#submission)

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/phenomT/bill_payment_api.git

2. Navigate to the project directory:

    cd bills-payment-api

3. Install dependencies:

    composer install

4. Set up your environment variables:

    cp .env.example .env

5. Generate an application key:

    php artisan key:generate

6. Run database migrations:

    php artisan migrate

7. Usage

    php artisan serve

The API will be available at http://localhost:8000/api.

API Endpoints
User Endpoints

GET /api/users - Retrieve all users
POST /api/users - Create a new user
GET /api/users/{id} - Retrieve a specific user
PUT /api/users/{id} - Update a specific user
DELETE /api/users/{id} - Delete a specific user
Transaction Endpoints

GET /api/transactions - Retrieve all transactions
POST /api/transactions - Create a new transaction
GET /api/transactions/{id} - Retrieve a specific transaction
PUT /api/transactions/{id} - Update a specific transaction
DELETE /api/transactions/{id} - Delete a specific transaction


Testing
To run the unit tests for the API endpoints, you can use the following command:

php artisan test

Make sure to have the database set up correctly as mentioned in the installation section. The tests will be found in the tests/Feature directory.

Postman Collection
You can access the Postman collection for testing the API

https://app.getpostman.com/join-team?invite_code=4298d57f95dc3e45526dd72b567fe4b2&target_code=91feb281b1b72d0f1ed854990bbd6daf
