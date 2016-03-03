<!DOCTYPE html>
<html>
    <head>
        <title>Dev - Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1>Dev - Login Page</h1>
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" action="auth">
                            <p>Username</p>
                            <input name="username" type="text">
                            <p>Password</p>
                            <input name="password" type="text">

                            <input value="Login" type="submit">
                        </form>
                    </div>
            </div>
        </div>
    </body>
</html>
