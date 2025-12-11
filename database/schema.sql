DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS accounts;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,    -- hashed password
    created_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE clients (
    id SERIAL PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    cin VARCHAR(20) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE accounts (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL REFERENCES clients(id) ON DELETE CASCADE,
    account_number VARCHAR(20) UNIQUE NOT NULL,
    balance NUMERIC(12,2) DEFAULT 0 NOT NULL,
    type VARCHAR(20) NOT NULL,             -- checking/saving etc.
    created_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE transactions (
    id SERIAL PRIMARY KEY,
    account_id INTEGER NOT NULL REFERENCES accounts(id) ON DELETE CASCADE,
    amount NUMERIC(12,2) NOT NULL,          -- positive for deposit, negative for withdraw
    type VARCHAR(20) NOT NULL,              -- 'deposit' or 'withdraw'
    created_at TIMESTAMP DEFAULT NOW()
);


