<?

session_start();
if( isset($_POST['username']) && isset($_POST['password']) )
{
    if( auth($_POST['username'], $_POST['password']) )
    {
        // auth okay, setup session
        $_SESSION['user'] = $_POST['username'];
        // redirect to required page
        header( "Location: index.php" );
     } else {
        // didn't auth go back to loginform
        header( "Location: loginform.html" );
     }
 } else {
     // username and password not given so go back to login
     header( "Location: loginform.html" );
 }