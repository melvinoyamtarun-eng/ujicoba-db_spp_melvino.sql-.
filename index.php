<html>
    <head>
        <title>From Login</title>
        <style>
            body{
                background: #f2cd7e;
                margin: 0%;
                font-family: 'Open Sans', sans-serif;
            }

            fieldset{
                margin: 100 auto;
                width: 320px;
                height: 400px;
                border: 2px solid white;
                background-color: white;
            }

            label{
                font-family: tahoma;
                color: red;
            }

            input{
                position: center;
                margin: 5px;
                padding: 5px;
                width: 300px;
                height: 40px;
                border: 1px solid white;
                border-radius: 10px;
            }

            select{
                position: center;
                margin: 5px;
                padding: 10px;
                width: 300px;
                height: 40px;
                border: 1px solid white;
                border-radius: 10px;
            }
            #submit
            {
                color: white;
                background-color: #428df5;
            }

            #input
            {
                background-color: #c6cfc7;
            }
        </style>
    </head>
    <body>

        <h1 align="center"> <b> SPP </b> ONLINE </h1>
        <form action="Login_validasi.php" method="post">
    <fieldset>

        <legend align="center">
            <img src="src/Pria Solo.jpg" width="75" height="75">
        </legend>

        <table align="center">
            <tr>
                <td>
                    <input name="username" type="text"
                           placeholder="Username" id="input">
                </td>
            </tr>

            <tr>
                <td>
                    <input name="password" type="password"
                           placeholder="Password" id="input">
                </td>
            </tr>

            <tr>
                <td>
                    <input name="login" type="submit"
                           value="LOGIN" id="submit">
                </td>
            </tr>
            <tr><td> </tr></td>
            <tr><td> </tr></td>
            <tr> <td align="center"> <a href = "bayar.php"> CEK PEMBAYARAN </a> </tr></td>

        </table>

    </fieldset>
</form>