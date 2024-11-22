# Library API Documentation

## Overview
This repository contains a PHP-based API built using the Slim Framework. The API provides basic user management functionality with secure authentication using JSON Web Tokens (JWT).

---

## Features

### 1. User Registration
   Add a new user with a username and hashed password.

### 2. User Authentication
   Validate a user's credentials and generate a JWT for session management.

### 3. View User
   Fetch a registered user (requires valid JWT).

### 4. Edit User's Password 
   Update a user's password (requires valid JWT).

### 5. Delete User
   Remove a user by their ID (requires valid JWT).

### 6. Book Authentication
   Validate a book details and generate a JWT for session management.

### 7.  View All Book
    Retrieve a list of all book in the database (requires valid JWT token).  

### 8.  Add Book
   Add a new book to the database using a valid JWT token.

### 9. Return Book 
      Return the books that requires valid JWT token. 

### 10. Borrow Book 
      Borrow books that requires a valid JWT token. 

### 11. Author Authenticate
      Authenticate the author and generate a JWT for session management. 

### 12. View Author
       View all list of authors in the database (requires valid JWT).

### 13. Author Add 
      Add a new author to the database using a valid JWT token.

---

## Base URL
http://127.0.0.1/library/public

---
## Endpoints

**NOTE:** The tokens given in this examples are already used, to proceed without errors pls do 1 to 10 step by step.

 1. **User Registration**
    - **Method**: `POST`
    - **Endpoint**: `http://127.0.0.1/library/public/user/add`

    - **Request**:
        ```json
        {
              "username":"Nhora2",
              "password":"12345678"
        }
        ```

    - **Response**:
        - **Success(200)**
            ```json
            {
                "status": "success",
                "data": null
            }
            ```
        - **Failure**
            ```json
            {
             "status": "fail",
                "data": {
                "title": "fail"
                }
            }
            ```
---


  2. **User Authentication**
     - **Method**: `POST`
     - **Endpoint**: `http://127.0.0.1/library/public/user/authenticate`

     - **Request**:
        ```json
        {
            "username": "Nhora2",
            "password": "12345678"
        }
        ```

     - **Response**:
        - **Success(200)**
            ```json
            {
                "status": "success",
                "token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE0MjgsImV4cCI6MTczMjI5MTcyOCwiZGF0YSI6eyJ1c2VyaWQiOjE2fX0.COZoRMPp_-u8zh3jkGZHBduSG-ybuGtLPp9JMQn7yCw",
                "data": null
            }
            ```
        - **Failure**
            ```json
            {
             "status": "fail",
                "data": {
                "title": "Authentication Failed"
                }
            }
            ```
---
3. **View Users**
     - **Method**: `POST`
     - **Endpoint**: `http://127.0.0.1/library/public/user/view`

     - **Request**:
        ```json
        {
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE0MjgsImV4cCI6MTczMjI5MTcyOCwiZGF0YSI6eyJ1c2VyaWQiOjE2fX0.COZoRMPp_-u8zh3jkGZHBduSG-ybuGtLPp9JMQn7yCw"
        }
        ```

     - **Response**:
        - **Success(200)**
            ```json
             {
              "status": "success",
               "users": [
               {
                "userid": 16,
                "username": "Nhora2",
               "password": "ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f",
             "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE0MjgsImV4cCI6MTczMjI5MTcyOCwiZGF0YSI6eyJ1c2VyaWQiOjE2fX0.COZoRMPp_-u8zh3jkGZHBduSG-ybuGtLPp9JMQn7yCw"
          }
          ]
          }
             
            ```
        - **Failure**
            ```json
            {
                "status": "fail",
                "data": {
                "title": "Invalid or Expired Token"
               }
            }
            ```
---

4. **User Password**
    - **Method**: `POST`
    - **Endpoint**: `http://127.0.0.1/library/public/user/password`

    - **Request**:
        ```json
        {
            "password":1234567,
             "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE0MjgsImV4cCI6MTczMjI5MTcyOCwiZGF0YSI6eyJ1c2VyaWQiOjE2fX0.COZoRMPp_-u8zh3jkGZHBduSG-ybuGtLPp9JMQn7yCw"
        }
        ```

    - **Response**:
        - **Success(200)**
            ```json
            {
                "status": "success"
            }
            ```
        - **Failure**
            ```json
            {
             "status": "fail",
                "data": {
                "title": "Invalid or Expired Token"
                }
            }
            ```
---

5. **Delete User**
    - **Method**: `POST`
    - **Endpoint**: `http://127.0.0.1/library/public/user/delete`

    - **Request**:
        ```json
       {
         "username":"Nhora2",
         "password":1234567,
         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE0MjgsImV4cCI6MTczMjI5MTcyOCwiZGF0YSI6eyJ1c2VyaWQiOjE2fX0.COZoRMPp_-u8zh3jkGZHBduSG-ybuGtLPp9JMQn7yCw"
       }
        ```

    - **Response**:
        - **Success(200)**
            ```json
            {
                "status": "success",
                "data": null
            }
            ```
        - **Failure**
            ```json
            {
             "status": "fail",
                "data": {
                "title": "Invalid or Expired Token"
                }
            }
            ```
---

6. **Book Authenticate**
    - **Method**: `POST`
    - **Endpoint**: `http://127.0.0.1/library/public/book/authenticate`

    - **Request**:
        ```json
       {
         "username":"Nhora2",
         "password":"1234567",
         "token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE0MjgsImV4cCI6MTczMjI5MTcyOCwiZGF0YSI6eyJ1c2VyaWQiOjE2fX0.COZoRMPp_-u8zh3jkGZHBduSG-ybuGtLPp9JMQn7yCw"
       }
        ```

    - **Response**:
        - **Success(200)**
            ```json
           {
           "status": "success",
           "book token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE4NzMsImV4cCI6MTczMjI5MjE3MywiZGF0YSI6eyJib29raWQiOm51bGx9fQ.jnsva6-_lvHgYxR0Q3EtcNiVjFhrGcrWHwmO7wGH_w8"
           }
            ```
        - **Failure**
            ```json
            {
             "status": "fail",
                "data": {
                "title": "Authentication Failed"
                }
            }
            ```
---

7. **View All Books**
    - **Method**: `POST`
    - **Endpoint**: `http://127.0.0.1/library/public/book/view`

    - **Request**:
        ```json
        {
            "book_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE4NzMsImV4cCI6MTczMjI5MjE3MywiZGF0YSI6eyJib29raWQiOm51bGx9fQ.jnsva6-_lvHgYxR0Q3EtcNiVjFhrGcrWHwmO7wGH_w8"
        }
        ```

    - **Response**:
        - **Success(200)**
            ```json
           {
           "status": "success",
            "books": [
          {
            "bookid": 1,
            "title": "The Frog Prince",
            "pages": 32,
            "status": "free"
          },
          {
          "bookid": 2,
           "title": "Snow White and the Seven Dwarfs",
           "pages": 112,
          "status": "borrowed"
          },
          {
          "bookid": 3,
          "title": "Harry Potter",
          "pages": 223,
          "status": "free"
          },
          {
          "bookid": 4,
          "title": "Ends With Us",
           "pages": 376,
           "status": "free"
          },
          {
          "bookid": 5,
          "title": "It Starts with Us",
          "pages": 336,
          "status": "free"
          }
          ]
          }
            ```
        - **Failure**
            ```json
            {
             "status": "fail",
                "data": {
                "title":"Invalid or Expired Token"
                }
            }
            ```
---

8. **Add Book**
    - **Method**: `POST`
    - **Endpoint**: `http://127.0.0.1/library/public/book/add`

    - **Request**:
        ```json
        {
             "title":"IT",
             "author":"Alexandra",
              "pages": 337,
            "book_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE4NzMsImV4cCI6MTczMjI5MjE3MywiZGF0YSI6eyJib29raWQiOm51bGx9fQ.jnsva6-_lvHgYxR0Q3EtcNiVjFhrGcrWHwmO7wGH_w8"
        }
        ```

    - **Response**:
        - **Success(200)**
            ```json
            {
                "status": "success",
                "data": null
            }
            ```
        - **Failure**
            ```json
            {
             "status": "fail",
                "data": {
                "title":"Invalid or Expired Token"
                }
            }
            ```
---

9. **Return book**
    - **Method**: `POST`
    - **Endpoint**: `http://127.0.0.1/library/public/book/return`

    - **Request**:
        ```json
        {
           "bookid":2,
            "book_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE4NzMsImV4cCI6MTczMjI5MjE3MywiZGF0YSI6eyJib29raWQiOm51bGx9fQ.jnsva6-_lvHgYxR0Q3EtcNiVjFhrGcrWHwmO7wGH_w8"
        }
        ```

    - **Response**:
        - **Success(200)**
            ```json
            {
                "status": "success",
                "data": null
            }
            ```
        - **Failure**
            ```json
            {
             "status": "fail",
                "data": {
                "title":"Invalid or Expired Token"
                }
            }
            ```
---

10. **Borrow Book**
    - **Method**: `POST`
    - **Endpoint**: `http://127.0.0.1/library/public/book/borrow`

    - **Request**:
        ```json
        {
            "bookid":2,
             "book_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE4NzMsImV4cCI6MTczMjI5MjE3MywiZGF0YSI6eyJib29raWQiOm51bGx9fQ.jnsva6-_lvHgYxR0Q3EtcNiVjFhrGcrWHwmO7wGH_w8"
        }
        ```

    - **Response**:
        - **Success(200)**
            ```json
            {
                "status": "success",
                "data": null
            }
            ```
        - **Failure**
            ```json
            {
             "status": "fail",
                "data": {
                "title": "Invalid or Expired Token"
                }
            }
            ```
11. **Author Authenticate**
    - **Method**: `POST`
    - **Endpoint**: `http://127.0.0.1/library/public/author/authenticate`

    - **Request**:
        ```json
        {
            "username":"Nhora2",
            "password":"1234567",
            "token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTE4NzMsImV4cCI6MTczMjI5MjE3MywiZGF0YSI6eyJib29raWQiOm51bGx9fQ.jnsva6-_lvHgYxR0Q3EtcNiVjFhrGcrWHwmO7wGH_w8"
        }
        ```

    - **Response**:
        - **Success(200)**
            ```json
            {
                "status": "success",
                  "author token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTI5MjQsImV4cCI6MTczMjI5MzIyNCwiZGF0YSI6eyJhdXRob3IiOm51bGx9fQ.u_Z3oq62cxaf3O6YQzpYhwbihFgHCMSy_pQ4taL3ruY"
            }
            ```
        - **Failure**
            ```json
            {
             "status": "fail",
                "data": {
                "title": "Invalid or Expired Token"
                }
            }
            ```
12. **Author View**
    - **Method**: `POST`
    - **Endpoint**: `http://127.0.0.1/library/public/author/view`

    - **Request**:
        ```json
        {
            "author_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTI5MjQsImV4cCI6MTczMjI5MzIyNCwiZGF0YSI6eyJhdXRob3IiOm51bGx9fQ.u_Z3oq62cxaf3O6YQzpYhwbihFgHCMSy_pQ4taL3ruY"
        }
        ```

    - **Response**:
        - **Success(200)**
            ```json
            {
             "status": "success",
             "author token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIyOTMxNTYsImV4cCI6MTczMjI5MzQ1NiwiZGF0YSI6eyJib29raWQiOjF9fQ.bs4OwB8N1M8GqEq0ppYjk4G8bbvh6F6_hxywYD9ogmE",
            "authors": [
             {
              "authorid": 1,
               "name": "Brother Grimm"
             },
             {
              "authorid": 2,
             "name": "Disney Press"
             },
             {
             "authorid": 3,
            "name": "J.K Rowling"
            },
             {
             "authorid": 4,
              "name": "Colleen Hoover"
             },
              {
             "authorid": 5,
              "name": "Colleen Hoover"
             }
            ]
            }
            ```
        - **Failure**
            ```json
            {
             "status": "fail",
                "data": {
                "title": "Invalid or Expired Token"
                }
            }
            ```
## Contact Information

If you have any questions or need further assistance, feel free to reach out:

- **Name:** Nhora A. Esmael
- **Address:** Bet-Ang, Balaoan, La Union
- **School:** Don Mariano Marcos Memorial State University - Mid La Union Campus
- **Email:** nesmael09662@student.dmmmsu.edu.ph
- **Facebook:** Nhora Arquero Esmael
- **Contact Number:** 09564927876


---





