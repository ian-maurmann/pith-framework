
# How to run Pith web app on your web server

- Copy index.php to your web server's public HTML folder.
- Edit index.php to `chdir( )` to the folder where the app is. (`chdir( )` to the folder containing the front-controller).
- If there is an index.html, rename it to something else. (Because index.html has higher precedence than index.php for the `/` path, and we want it to always pick our index.php)
- Copy the .htaccess file to your web server's public HTML folder. But if an .htaccess file already exists, at least copy the URL routing rules into it to make URL routing work.