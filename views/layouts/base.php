<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $pageTitle ?? 'Twitterity'; ?></title>
    <link rel="stylesheet" href="css/style.css?v=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <?php if (isset($includeFontAwesome) && $includeFontAwesome): ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <?php endif; ?>
    <?php if (isset($includeJQuery) && $includeJQuery): ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php endif; ?>
</head>
<body>
    <?php echo $content; ?>
    <?php if (isset($includeScript) && $includeScript): ?>
    <script src="js/script.js"></script>
    <?php endif; ?>
</body>
</html> 