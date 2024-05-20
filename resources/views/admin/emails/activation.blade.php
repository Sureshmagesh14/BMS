<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultant Invitation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            display: grid;
            place-items: center;
            height: 100vh;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .button-container {
            margin-top: 20px;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .expired {
            font-size: 24px;
            color: #dc3545; /* Red color */
        }
        .accepted {
            font-size: 24px;
            color: #4caf50; /* Red color */
        }
        .btn-container {
            display: flex;
            justify-content: center;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .accept {
            background-color: #4caf50;
            color: #fff;
        }
        .decline {
            background-color: #f44336;
            color: #fff;
        }
        .accept a,.decline a{
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
     
            <h1>Acceptance Invitation</h1>
            <p>
                You have received an activation email to collaborate on The Brand Surgeon.
            </p>
            <div class="btn-container">
                <button class="btn accept">
                    <a href="{{ env('APP_URL') }}activation_status/{{$id}}/1">Accept</a>
                </button>
                <button class="btn decline">
                    <a href="{{ env('APP_URL') }}activation_status/{{$id}}/0">Decline</a>
                </button>
            </div>
      
    </div>
</body>
</html>
