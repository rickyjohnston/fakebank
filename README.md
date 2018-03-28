# isoftbet

## Introduction
Create a API that handles request / responses for a made up BANK. This API should be able to handle the following calls and reply in json format:
- adding of a customer:
    - **Request**: name, cnp
    - ✅ **Response**: customerId
- getting a transaction:
    - ✅ **Request**: customerId, transactionId
    - ✅ **Response**: transactionId, amount, date
- getting transaction by filters:
    - **Request**: customerId, amount, date, offset, limit
    - **Response**: an array of transactions
- adding a transaction:
    - **Request**: customerId, amount
    - **Response**: transactionId, customerId, amount, date
- updating a transaction:
    - **Request**: transactionId, amount
    - **Response**: transactionId, customerId, amount, date
- deleting a transaction:
    - ✅ **Request**: trasactionId
    - ✅ **Response**: success/fail

**Request example for getting a transaction**: APP_URL/transaction/{customerId}/{transactionId}

**Response example for getting a transaction**:
```json
{
    "transactionId" : 100,
    "amount" : 205.67,
    "date" : "20.03.2015"
}
```

## API

1. **Framework Setup**

    a. Start and setup and app with Laravel / Lumen framework

2. **Database handling**

    a. You are free to create a database structure that will fulfill the API requirements.

    b. Requirement: Use PDO prepare statement or ORM system.

3. **Security**

    a. Create a login system for GUI.

    b. Create an auth system for API.

## GUI

1. **View**

    a. Create a page where we can see transactions. Page should be accessible only for logged in users. API should be used to get the list of transactions.

## CRON

1. Create a script that stores the sum of all transactions from previous day.
2. Attach a file where you add the command you use to set up the cron job to run every 2 days at 23:47.