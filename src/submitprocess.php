<?php

// Decode json into object
if (isset($_POST["json"])) {
    $conn = pg_connect(getenv("DATABASE_URL"));
    $obj = json_decode($_POST["json"]);
    $name = $obj->name;
    $email = $obj->email;
    $title = $obj->title;
    $author = $obj->author;
    $date = $obj->date;
    $doi = $obj->doi;
    $description = $obj->description;
    submit($title, $author, $date, $doi, $description);
}
/**
 * Submit the details
 */
function submit($title, $author, $date, $doi, $description) {
    $sql = "INSERT INTO articles (title, author, date, doi, description)
            VALUES ('$title', '$author', '$date', '$doi', '$description')";
    $result = pg_query($sql);

    if (pg_num_rows($result) > 0) {
        if (!isset($name) || !isset($email)) {
            $name = "Test";
            $email = "Test";
        }

        echo "<h3 class='hr_title'> Submit Article</h3>
        <hr>
        <br>
        Thank you, $name!
        <br>
        <br>   
        Your submission has been received and is now in Stage 2.
        <br>
        <br>
        <br>
        Stage 1: Submit ---> Stage 2: Moderation ---> Stage 3: Posted to SEER
        <br>
        <br>
        <br>
        A confirmation email has been sent to $email.
        <br>
        <br>
        <button class='button' onclick='window.location.href='searchform.html''>Search</button>
        <button class='button' onclick='newArticle()'>New Article</button>";
    } else if (pg_num_rows($result) == 0) {
        echo "<h3 class='hr_title'> Submit Article</h3>
        <hr>
        <br>
        Sorry, your submission failed to submit
        <br>
        <br>   
        Your submission may be already in the database
        <br>
        <br>
        <br>
        Stage 1: Submit ---> Stage 2: Moderation ---> Stage 3: Posted to SEER
        <br>
        <br>
        <br>
        Please choose another article
        <br>
        <br>
        <button class='button' onclick='window.location.href='searchform.html''>Search</button>
        <button class='button' onclick='newArticle()'>New Article</button>";
    }
}

?>