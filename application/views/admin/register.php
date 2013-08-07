<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Register new user</title>
    <link media="screen, projection" href="/css/login.css" type="text/css" rel="stylesheet">
</head>
<body>
<div id="login">
    <form action="/admin/register/save/" method="post" accept-charset="utf-8">
        <fieldset>
            <legend>Register new user</legend>
            <p>
                <input type="email" required="required" name="email" placeholder="Email">
            </p>
            <p>
                <input type="password" pattern="[0-9-._a-zA-Z]{3,}" required="required" name="password" placeholder="Password">
            </p>
            <p>
                <input type="submit" name="submit" value="Submit">
            </p>
        </fieldset>
    </form>
</div>
</body>
</html>