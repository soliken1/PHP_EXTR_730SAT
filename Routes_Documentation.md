# Routes Overview

## Base URL

-   https://extr-fri730-704ba95d817c.herokuapp.com/api/

## Credentials Routing

### GET /users

-   **Description**: Endpoint for GETTING ALL Users, Returns with an Array of User Objects
-   **Request Body**:

    ```json
    {}
    ```

-   **Response**:
    ```json
    [
        {
            "username": "Soliken",
            "email": "solitudebaruch@gmail.com",
            "password": "$2y$12$j6gRJqedcbXH.2QeqmTPfeiBLBPOGDZWt8aaj464QUi8cbGfZamvO",
            "verified": false,
            "updated_at": "2024-11-16T12:42:49.836000Z",
            "created_at": "2024-11-16T12:42:49.836000Z",
            "id": "673893493e79f96794031103"
        },
        {
            "username": "Remi",
            "email": "kennethrex456@gmail.com",
            "password": "$2y$12$9TeGMumO.0zA21czahXoluAbD9l0I8cS7ZLyPWaELwSzYVdhGFQJK",
            "verified": true,
            "updated_at": "2024-11-16T15:31:48.127000Z",
            "created_at": "2024-11-16T14:18:16.826000Z",
            "id": "6738a9a8e747f9b18802b9a9"
        }
    ]
    ```

### POST /login

-   **Description**: Logging In Endpoint To Return User Information
-   **Request Body**:

    ```json
    {
        "username": "Remi",
        "password": "kenneth1"
    }
    ```

-   **Response**:
    ```json
    {
        "message": "Login successful.",
        "user": {
            "username": "Remi",
            "email": "kennethrex456@gmail.com",
            "password": "$2y$12$9TeGMumO.0zA21czahXoluAbD9l0I8cS7ZLyPWaELwSzYVdhGFQJK",
            "verified": true,
            "updated_at": "2024-11-16T15:31:48.127000Z",
            "created_at": "2024-11-16T14:18:16.826000Z",
            "id": "6738a9a8e747f9b18802b9a9"
        }
    }
    ```

### POST /register

-   **Description**: Registering Endpoint To Add User But Verified Status Is Set To False Initially To Be Verified On Defined Email
-   **Request Body**:
    ```json
    {
        "username": "TestUser",
        "email": "TestUser@gmail.com",
        "password": "sample123"
    }
    ```
-   **Response**:
    ```json
    {
        "message": "User added successfully. A verification email has been sent.",
        "user_id": "6738c0b2a3b66ca9ec08d242"
    }
    ```

### POST /password/forgot

-   **Description**: Forgot Password Endpoint To Return A Message and Sends an Email For Changing of Password, Token To Be Saved On Database and To Check If Route Is Expired
-   **Request Body**:
    ```json
    {
        "email": "kennethrex456@gmail.com"
    }
    ```
-   **Response**:
    ```json
    {
        "message": "Check your email to change your password"
    }
    ```

### POST /password/reset/{token}

-   **Description**: The Response of /password/forgot Route To Check Token and Lifetime of the Route, For The User To Change Their Password
-   **Request Body**:
    ```json
    {
        "email": "kennethrex456@gmail.com",
        "password": "remilia1",
        "password_confirmation": "remilia1"
    }
    ```
-   **Response**:

    ```
    redirect to 'https://extrcust.vercel.app/verifyStatus/success'

    ```

### GET /verify-email/{id}

-   **Description**: Endpoint for Email Verification Status Changing To True and Finding The UserId Who Is Changing Their Password
-   **Request Body**:
    ```json
    {}
    ```
-   **Response**:

    ```json
    {
        "verified": true
    }
    ```

## Expenses Routing

### GET /expenses

-   **Description**: Endpoint To Get All Expenses with No Constraints or Parameters Returning an Array of All Expenses
-   **Request Body**:

    ```json
    {}
    ```

-   **Response**:

    ```json
    [
        {
            "expenseName": "Ice Cream",
            "expenseDescription": "Belgian Ice Cream",
            "userId": "673812640e128833aa0143a2",
            "amount": 750.5,
            "date": "2024-11-17 15:00:00",
            "updated_at": "2024-11-16T13:01:11.605000Z",
            "created_at": "2024-11-16T10:41:45.450000Z",
            "categoryTitle": "No Category",
            "id": "673876e9e747f9b18802b9a2"
        },
        {
            "expenseName": "Pares",
            "expenseDescription": "Large Beef Pares",
            "userId": "673812640e128833aa0143a2",
            "amount": 100.24,
            "date": "2024-11-17 15:00:00",
            "categoryTitle": "No Category",
            "updated_at": "2024-11-16T13:01:11.605000Z",
            "created_at": "2024-11-16T11:07:06.436000Z",
            "id": "67387cdae747f9b18802b9a3"
        }
    ]
    ```

### POST /userExpenses/

-   **Description**: An endpoint for accessing user's expenses with the constraint or requiring user's Id returning an Array of Expenses object from the user.
-   **Request Body**:

    ```json
    {
        "userId": "673812640e128833aa0143a2"
    }
    ```

-   **Response**:

    ```json
    [
        {
            "expenseName": "Ice Cream",
            "expenseDescription": "Belgian Ice Cream",
            "userId": "673812640e128833aa0143a2",
            "amount": 750.5,
            "date": "2024-11-17 15:00:00",
            "updated_at": "2024-11-16T13:01:11.605000Z",
            "created_at": "2024-11-16T10:41:45.450000Z",
            "categoryTitle": "No Category",
            "id": "673876e9e747f9b18802b9a2"
        }
    ]
    ```

### POST /addExpense

-   **Description**: Endpoint for adding single expenses with the requirements of the body below, this also needs UserId to refer ownership of that expense
-   **Request Body**:

    ```json
    {
        "userId": "673812640e128833aa0143a2",
        "expenseName": "Chocolate Cake",
        "expenseDescription": "A Large Birthday Cake",
        "amount": 200.24,
        "date": "2024-11-17 15:00:00"
    }
    ```

-   **Response**:

    ```json
    {
        "message": "Expense added successfully",
        "expense": {
            "expenseName": "Chocolate Cake",
            "expenseDescription": "A Large Birthday Cake",
            "userId": "673812640e128833aa0143a2",
            "amount": 200.24,
            "date": "2024-11-17 15:00:00",
            "categoryTitle": "No Category",
            "updated_at": "2024-11-17T05:25:44.335000Z",
            "created_at": "2024-11-17T05:25:44.335000Z",
            "id": "67397e58b456efde3e01ce74"
        }
    }
    ```

### PATCH /updateExpense/{expenseName}

-   **Description**: Updates the expense name, the end route is dynamic, craft the URL carefully with the desired expenseName from the user in submitting to this endpoint. Also Requiring user's Id to update their Expense Details, The PATCHING of the details are optional and if one detail is edited, not all is changed but the specified field is patched.
-   **Sample URL Craft**: https://extr-fri730-704ba95d817c.herokuapp.com/api/updateExpense/Chocolate%20Cake
-   **Request Body**:
-   **Patching of 1 Field**:

    ```json
    {
        "userId": "673812640e128833aa0143a2",
        "categoryTitle": "Food Expense"
    }
    ```

-   **Response**:

    ```json
    {
        "message": "Expense updated successfully.",
        "expense": {
            "expenseName": "Birthday Cake",
            "expenseDescription": "A Large Chocolate Cake",
            "userId": "673812640e128833aa0143a2",
            "amount": 500.23,
            "date": "2024-11-17 15:00:00",
            "categoryTitle": "Food Expense",
            "updated_at": "2024-11-17T05:32:33.401000Z",
            "created_at": "2024-11-17T05:25:44.335000Z",
            "id": "67397e58b456efde3e01ce74"
        }
    }
    ```

-   **Patching of All Field**:

    ```json
    {
        "userId": "673812640e128833aa0143a2",
        "categoryTitle": "Food Expense",
        "amount": 500.23,
        "expenseName": "Birthday Cake",
        "expenseDescription": "A Large Chocolate Cake"
    }
    ```

-   **Response**:

    ```json
    {
        "message": "Expense updated successfully.",
        "expense": {
            "expenseName": "Birthday Cake",
            "expenseDescription": "A Large Chocolate Cake",
            "userId": "673812640e128833aa0143a2",
            "amount": 500.23,
            "date": "2024-11-17 15:00:00",
            "categoryTitle": "Food Expense",
            "updated_at": "2024-11-17T05:32:33.401000Z",
            "created_at": "2024-11-17T05:25:44.335000Z",
            "id": "67397e58b456efde3e01ce74"
        }
    }
    ```

### DELETE /deleteExpense/{expenseName}

-   **Description**:Deletes the expense from the user, carefully craft the url to handle the endpoint in order to make it successful
-   **Sample URL Craft**: https://extr-fri730-704ba95d817c.herokuapp.com/api/deleteExpense/Birthday%20Cake
-   **Request Body**:

    ```json
    {
        "userId": "673812640e128833aa0143a2"
    }
    ```

-   **Response**:

    ```json
    {
        "message": "Expense deleted successfully."
    }
    ```

## Template

### HTTPRequest

-   **Description**:
-   **Request Body**:

    ```json
    {}
    ```

-   **Response**:

    ```json
    {}
    ```
