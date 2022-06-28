<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Something went wrong</title>
    <style>
        .container {
            display: flex;
            position: relative;
            margin-left: auto;
            margin-right: auto;
            margin-top: 10rem;
            width: fit-content;
            justify-content: center;
            align-items: start;
            flex-direction: column;
        }

        .container h1 {
            font-size: 5rem;
            color: orangered;
        }

        .container h2 {
            font-size: 3rem;
            color: royalblue;
            margin: 0;
        }

        h1.icon {
            font-size: 5rem;
            color: royalblue;
            left: -10rem;
            position: absolute;
            margin-right: 2rem
        }
    </style>
</head>
<body>
<div class="container">
    <div>
        <h1 class="icon">
            :-(
        </h1>
        <h1>
            Sorry,
        </h1>
    </div>
    <div>
        <h2>
            something went wrong
        </h2>
    </div>
</div>
</body>
</html>