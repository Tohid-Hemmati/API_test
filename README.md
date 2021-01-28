## API Documentation

## run php artisan serve

### Routes:

-   **http://127.0.0.1:8000/api/UserRegister**
-   **http://127.0.0.1:8000/api/UserLogin**
-   **http://127.0.0.1:8000/api/subscribe**
-   **http://127.0.0.1:8000/api/DeviceRegister**
-   **http://127.0.0.1:8000/api/AppRegister**
-   **http://127.0.0.1:8000/api/subscription_check**
    **http://127.0.0.1:8000/api/cancel_subscription**
    <br><br>

## database schemas

stored in root directory under <b>database schemas</b>

## register user

/UserRegister

method: post
Accept: application/json

Required:
<br>name
<br>email
<br>password
<br>password confirmation

## Example Error Message

<pre>
{
    "errors": [
        "The email has already been taken."
    ]
}
</pre>

## success:

<pre>
{
    "name": "user",
    "email": "g@g.com",
    "userToken": "kjnk",
    "updated_at": "2021-01-26T19:10:47.000000Z",
    "created_at": "2021-01-26T19:10:47.000000Z"
}
</pre>
<hr>

## user Login

/UserLogin

<br>method: post
<br>Accept: application/json
<br>bearerToken: userToken(get from related user's table)<br>
<b>Required:</b>
<br>email
<br>password

<hr>

## Register Device

/DeviceRegister

<br>method: post
<br>Accept: application/json
<br>bearerToken: userToken(get from related user's table)

<b>Required:</b>
<br>lang
<br>OS

<hr>

## Regester Mobile Application

/AppRegister

<br>method: post
<br>Accept: application/json
<br>bearerToken: device_token(get from related device's table)

<b>Required:</b>
<br>app_name
<br>in_app_purchase (set to 1)

<hr>

## subscribing

/subscribe

<br>method: post
<br>Accept: application/json
<br>bearerToken: client_token(get from related app's table)

<b>Required:</b>
<br>receipt

<hr>

## subscribing check

/subscription_check

<br>method: post
<br>Accept: application/json
<br>bearerToken: app_token(get from related app's table)

## subscribing revoke

/cancel_subscription

<br>method: post
<br>Accept: application/json
<br>bearerToken: app_token(get from related app's table)
