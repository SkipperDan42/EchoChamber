TERMINOLOGY:
    Alternative -   Statistics, if you're a sheep
        Facts
    Backpedal   -   To Edit the content of a Post
    Boor        -   An Echochamber User
    Boor Hole   -   User Settings page
    Clap        -   Likes on a Post
    Echo        -   To Repost a Post
    Echoes      -   The number of Reposts
    Echoed      -   The Post that was Reposted
    Monologue   -   The Profile of a single User
    Shout       -   An original Post
    The Chamber -   The live feed of Posts from all Users
    Tools       -   Settings for REAL MEN
    Whisper     -   A Comment on a Post

USING THE UI:
    - Log In
    - Landing Page is The Chamber
    - Click anywhere on a Post to view it
        - Clicking on the User will take you to the User Profile
        - If there are 2 Users then the middle one is the OP, the left hand one has Reposted
    - Upon viewing a Post many options are available to like, repost, edit and delete (depending
        on context - outlined below)
    - Clicking Monologue will show the authenticated User Profile
    - Clicking Tools will offer a dropdown to access User Settings, Statistics and Log Out (plus additional Admin views)

CREATIVE DECISIONS:
    - The site is completely locked down, logging in is a requirement for anything.
    - Users do not have to provide their name, only an email and username (and password),
        for the privacy of everyone in the EchoChamber!
    - An Echo may keep or completely change the content of the original Shout - this is in the
        vein of Retweets, Tumblr reblogs, or email chains.
    - An Echo is only linked to the original User, NOT the original Shout. This allows users to
        put words into the mouths of others, with absolutely no evidence that they did so.
        THAT IS YOUR RIGHT TO FREE SPEECH!
    - An Admin may delete ANY Shout or Whisper. While censorship is not ideal, what if some LIBS were to
        get in and spread their SATANIST propaganda?
    - An Admin may NOT edit the content of a Shout or Whisper - censorship is a last resort, but
        sanitization is for SNOWFLAKES.
    - An Admin has access to all User details and can change them, at will, but only with at request obviously,
        we do predict a lot of older users on this platform...

DEVELOPMENT DECISIONS:
    - NOTE that while running migrations it may fail due to overflow error. This is because
        picsum only has 1084 images, but I'm forcing the random number to be unique - with
        300+ posts, this can cause the migration to fail. It usually works second time!!
    - All buttons to interact with Shouts (Clap, Echo, Backpedal, Delete) and Whispers are
        located on the Shout's show view. This removes the need for Javascript (primarily as
        adding a Clap will alter the Shout's ranking - and therefore position - within The Chamber).

LOGINS:
    - Here are some useful logins so you don't have to search the seeders:
    - Admins:
            2039924@echochamber.com
            SYSarchitect!

            admin@echochamber.com
            admin

    - Users:
            twopintnigel@ukip.co.uk
            BADpassword

            aj@infowars.com
            turnTHEfrogsGAY





