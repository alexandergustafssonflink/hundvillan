# Hundvillan (Sort of a facebook-clone for dogs)

Assignment in programming class @ Yrgo.

<img src="https://media.giphy.com/media/eYilisUwipOEM/giphy.gif" width="100%">

## Contains

-   [Assignment instructions](#Assignment-instructions)
-   [Install](#Install)
-   [Preview](#Preview)
-   [Tested by](#Tested-by)
-   [Code review](#Code-review)

## Assignment instructions

### Create an Instagram clone using PHP, HTML, CSS & JavaScript.

-   As a user I should be able to create an account, sign in, sign out, create new posts, edit posts, delete posts, edit account details, add an avatar, like and dislike posts, add, edit and delete comments.

## Install

-   Clone repository.
-   Go into the public-folder using your terminal and use the following command to start a server.
-   `php -S localhost:1337`
-   Open your browser and go to localhost:1337

## Tested by

-   [Andreas Lindberg](https://github.com/oaflindberg)
-   [Maja Alin](https://github.com/majaalin)
-   [Mikeala Lundsgård](https://github.com/mikaelaalu)

## Code Review

by [Maja Alin](https://github.com/majaalin)

-   Delete empty file “updatepassword.php”

-   Don’t forget “declare(strict_types=1);” in register.php

-   Don’t forget “declare(strict_types=1);” in updateprofile.php

-   It might be easier to find in the css file if it was split into more files.

-   Good comments! But maybe you could have had some more to make it even clearer.

-   Great that you are consistent and use the Camel case when naming the classes. I just saw “form-group”, maybe you should do the same there.

-   You have used “br” in some files, maybe you could solved it with css instead.

-   Haha I love this “‘It is hard to type with paws. We know. Try again.”

-   I noted this “$statement->bindParam(‘:postId’, $postid, PDO::PARAM_STR);“, I think it should be “PDO::PARAM_INT”.

-   I think you’ve named your files well, but maybe you could use kebab-case or camelCase, so it’s easier to read the file names with more then one word.
