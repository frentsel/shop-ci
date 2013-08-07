<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link media="screen, projection" href="/css/login.css" type="text/css" rel="stylesheet">
</head>
<body>
    <div id="login">
        <form action="/admin/login/check/" method="post" accept-charset="utf-8">
            <fieldset>
                <legend>Log in</legend>
                <p>
                    <input type="email" required="required" name="email" placeholder="Email">
                </p>
                <p>
                    <input type="password" pattern="[0-9-._a-zA-Z]{3,}" required="required" name="password" placeholder="Password">
                </p>
                <p>
                    <input type="submit" name="submit" value="Submit">
                </p>
                <p>
                    <input type="checkbox" name="remember"> Remember my
                </p>
            </fieldset>
        </form>
    </div>
</body>
</html>