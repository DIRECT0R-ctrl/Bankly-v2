#  Bankly V2 — Simple Banking Management System (PHP & PostgreSQL)

Bankly V2 is a lightweight banking management system built with **PHP**, **PostgreSQL**, and **PDO**, focusing on **clean backend architecture**, **authentication**, and **relational data modeling**.

The project demonstrates core backend concepts: authentication, CRUD operations, database relationships, and secure server-side logic.

---

##  Features

###  Authentication

* Secure login system
* Password hashing
* Session-based access control
* Protected routes

###  Clients Management

* Add clients
* Edit clients
* Delete clients
* List all clients

###  Accounts Management

* Create bank accounts linked to clients
* Account types (savings / current)
* Initial balance handling
* List / edit / delete accounts

###  Transactions

* Record transactions per account
* Transaction history
* Relational integrity via foreign keys

###  Dashboard

* Global statistics:

  * Total clients
  * Total accounts
  * Total transactions
* Central navigation

###  UI

* Minimal, elegant UI (black / gray theme)
* Responsive layout
* Simple CSS for fast backend focus

---

##  Tech Stack

* **PHP 8+**
* **PostgreSQL**
* **PDO (PHP Data Objects)**
* **HTML / CSS**
* **Session-based authentication**

---

##  Project Structure

```text
Bankly-v2/
├── accounts/
│   ├── add_account.php
│   ├── edit_account.php
│   ├── delete_account.php
│   └── list_accounts.php
├── auth/
│   ├── login.php
│   └── logout.php
├── clients/
│   ├── add_client.php
│   ├── edit_client.php
│   ├── delete_client.php
│   ├── list_clients.php
│   └── clients_store.php
├── dashboard/
│   └── dashboard.php
├── database/
│   ├── schema.sql
│   └── seed.sql
├── includes/
│   ├── auth.php
│   ├── db.php
│   ├── config.php
│   └── functions.php
├── public/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   └── images/
├── templates/
│   ├── header.php
│   └── footer.php
├── transactions/
│   ├── make_transaction.php
│   └── list_transactions.php
└── README.md
```

---

## ⚙️ Installation & Setup

### Clone the repository

```bash
git clone https://github.com/your-username/Bankly-v2.git
cd Bankly-v2
```

### Create the database

```bash
sudo -u postgres psql
CREATE DATABASE bankly;
CREATE USER bankly_user WITH PASSWORD 'bankly_pass';
GRANT ALL PRIVILEGES ON DATABASE bankly TO bankly_user;
\q
```

### Import schema & seed

```bash
psql -U bankly_user -d bankly -f database/schema.sql
psql -U bankly_user -d bankly -f database/seed.sql
```

### Start PHP server

```bash
php -S localhost:8000
```

### Access the app

* Login: `http://localhost:8000/auth/login.php`
* Dashboard: `http://localhost:8000/dashboard/dashboard.php`

**Default credentials:**

```
username: admin
password: admin123
```

---

##  Security Notes

* Passwords are hashed using `password_hash`
* SQL queries use prepared statements (PDO)
* Authentication enforced via `require_login()`
* Server-side validation for inputs

---

##  Project Goals

* Practice clean PHP backend architecture
* Understand relational databases deeply
* Learn authentication & authorization flows
* Focus on **logic over frameworks**
* Build a maintainable CRUD system

---

##  Future Improvements

* Pagination
* Flash messages
* Role-based access
* API version
* Better error handling
* CSRF protection

---

##  Author

**Aymane**
Backend-focused developer
Passionate about architecture, systems, and clean logic

---

##  Final Note

This project is intentionally **framework-free** to demonstrate strong fundamentals in PHP, SQL, and backend thinking.

