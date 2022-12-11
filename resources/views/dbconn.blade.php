<!DOCTYPE html>

<html>

<head>
    <title>Laravel</title>
</head>

<body>
    <?php
        if (DB::connection()->getPDO()) {
            echo "Connected to DB ";
        }
</body>
</html>