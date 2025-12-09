# Bankly V2

Bankly V2 is a simple internal banking application for employees to manage clients, accounts, and transactions.

## Features

- Manage clients (add, edit, delete, list)  
- Manage bank accounts (create, edit, delete, list)  
- Record deposits and withdrawals  
- View transaction history  
- Access protected by authentication (login/logout)  
- Dashboard showing basic statistics

## Project Structure

Bankly-V2/
│
├── README.md
├── docs/ # Documentation, ERD
├── database/ # SQL schema and sample data
├── public/ # CSS, JS, images
├── templates/ # Header and footer templates
├── auth/ # Login and logout
├── clients/ # Client CRUD
├── accounts/ # Account CRUD
├── transactions/ # Transactions
├── dashboard/ # Dashboard
├── includes/ # DB connection, shared functions, config
└── logs/ # Optional logs

## Installation

1. Clone the repository:  
   ```bash
   git clone <your-repo-url>
Import the database schema in MySQL/PostgreSQL:

sql
Copy code
source database/schema.sql;
Configure the database connection in includes/config.php or includes/db.php.

Open the app in your browser via your local server (XAMPP, MAMP, or LAMP).

Usage
Login via auth/login.php.

Manage clients via clients/ folder pages.

Manage accounts via accounts/ folder pages.

Record transactions via transactions/make_transaction.php.

View stats in dashboard/dashboard.php.

License
This project is for educational purposes.
