# No framework application

This repository contains a test application for API processing of form data. Written without the use of frameworks.

To run, you need to have docker, docker-compose installed.

### Install and run

`make install`

### Start app

`make start`

### Stop app

`make stop`

### Rebuild docker containers

`make build`

### Show make help info

`make help`


# REST API

The REST API to the example app is described below.

## Store form data

### Success example:
### Request

`POST http://127.0.0.1:8888/form`

    curl --location --request POST 'http://127.0.0.1:8088/form' \
        --form 'email="test@gmail.com"' \
        --form 'phoneNumber="+380507776672"' \
        --form 'message="Test message"'

### Response

    HTTP/1.1 201 Created
    Date: Sun, 22 May 2022 11:57:58 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /form

    {"formId":1}


### Validation error example:
### Request

`POST http://127.0.0.1:8888/form`

    curl --location --request POST 'http://127.0.0.1:8088/form' \
        --form 'message="Test message"'

### Response

    HTTP/1.1 400 Bad Request
    Date: Sun, 22 May 2022 11:57:58 GMT
    Status: 400 Bad Request
    Connection: close
    Content-Type: application/json
    Location: /form

    { "email": "The Email is required", "phoneNumber": "The PhoneNumber is required" }


### Internal server error example:
### Request

`POST http://127.0.0.1:8888/form`

    curl --location --request POST 'http://127.0.0.1:8088/form' \
        --form 'email="test@gmail.com"' \
        --form 'phoneNumber="+380507776672"' \
        --form 'message="Test message"'

### Response

    HTTP/1.1 500 Internal Server Error
    Date: Sun, 22 May 2022 11:57:58 GMT
    Status: 500 Internal Server Error
    Connection: close
    Content-Type: application/json
    Location: /form

    {"message":"Internal server error"}

