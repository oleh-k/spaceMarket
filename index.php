<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lead</title>
</head>
<body>
    <h1>Add Lead</h1>
    <form action="addlead.php" method="post">

        <label for="firstName">First Name:</label><br>
        <input type="text" name="firstName" required><br><br>

        <label for="lastName">Last Name:</label><br>
        <input type="text" name="lastName" required><br><br>

        <label for="phone">Phone:</label><br>
        <input type="tel" name="phone" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="countryCode">Country Code:</label><br>
        <input type="text" name="countryCode" value="GB" required><br><br>

        <label for="box_id">Box ID:</label><br>
        <input type="number" name="box_id" value="28" required><br><br>

        <label for="offer_id">Offer ID:</label><br>
        <input type="number" name="offer_id" value="5" required><br><br>

        <label for="landingUrl">Landing URL:</label><br>
        <input type="text" name="landingUrl" value="<?= $_SERVER['HTTP_HOST'] ?>" required><br><br>

        <label for="ip">IP Address:</label><br>
        <input type="text" name="ip" value="<?= $_SERVER['REMOTE_ADDR'] ?>" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" value="qwerty12"><br><br>

        <label for="language">Language:</label><br>
        <input type="text" name="language" value="en"><br><br>

        <label for="clickId">Click ID:</label><br>
        <input type="text" name="clickId"><br><br>

        <label for="quizAnswers">Quiz Answers:</label><br>
        <textarea name="quizAnswers" rows="3"></textarea><br><br>

        <label for="custom1">Custom Field 1:</label><br>
        <input type="text" name="custom1"><br><br>

        <label for="custom2">Custom Field 2:</label><br>
        <input type="text" name="custom2"><br><br>

        <label for="custom3">Custom Field 3:</label><br>
        <input type="text" name="custom3"><br><br>

        <button type="submit">Submit</button>
    </form>

    <a href="getstatuses.php">View Statuses</a>
    <a href="getleads.php">View Leads</a>
</body>
</html>