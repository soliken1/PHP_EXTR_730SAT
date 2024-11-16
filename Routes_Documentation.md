# Routes Overview

## Users

## Base URL

-   https://extr-fri730-704ba95d817c.herokuapp.com/

### GET /users

-   **Description**: Endpoint for GETTING ALL Users
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

-   **Description**: Forgot Password Endpoint To Return A Route For Changing of Password, Token To Be Saved On Database and To Check If Route Is Expired
-   **Request Body**:
    ```json
    {
        "email": "kennethrex456@gmail.com"
    }
    ```
-   **Response**:
    ```json
    {
        "resetRoute": "http://extr-fri730-704ba95d817c.herokuapp.com/api/password/reset/gwDXYPRwmRunxzf7D5SLk7OlhHv8wjKg4UqlmqNfypAYIi5wxQto2Gv7Lx5Z?email=kennethrex456@gmail.com"
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
    ```json
    {
        "message": "Password reset successfully."
    }
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
