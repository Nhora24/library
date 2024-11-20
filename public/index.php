<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require '../src/vendor/autoload.php';
$app = new \Slim\App;



$app->post('/user/add', function (Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $usr = $data->username;
    $pass = $data->password; 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO users (username, password) VALUES ('".$usr."', '".hash('SHA256',$pass)."')";
        $conn -> exec($sql);
        $response->getBody()->write(json_encode(array("status" => "success", "data" => null)));
    } catch (PDOException $e) {
        $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => $e->getMessage()))));
    }
    return $response;
});



$app->post('/user/authenticate', function (Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $usr = $data->username;
    $pass = $data->password; 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM users WHERE username = '".$usr."' AND password = '".hash('SHA256', $pass)."'";
        $stat = $conn->query($sql);
        $data = $stat->fetchAll(PDO::FETCH_ASSOC);

        if (count($data) == 1) {
            $key = 'server_hack';
            $iat = time();
            $payload = [
                'iss' => 'http://library.org',
                'aud' => 'http://library.com',
                'iat' => $iat,
                'exp' => $iat + 300,
                'data' => [
                    "userid" => $data[0]['userid']
                ]
            ];
            $jwt = JWT::encode($payload, $key, 'HS256');
            $sql1 = "UPDATE users SET token = '$jwt' WHERE username = '".$usr."'";
            $stat = $conn->query($sql1);
            $users = $stat->fetchAll(PDO::FETCH_ASSOC);
            $response->getBody()->write(json_encode(array("status" => "success", "token" => $jwt, "data" => null)));
        } else {
            $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Authentication Failed"))));
        }
    } catch (PDOException $e) {
        $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Database Error"))));
    }
    return $response;
});



$app->post('/user/view', function(Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $jwt = $data->token;
    $key = 'server_hack';

        try {
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            $userid = $decoded->data->userid;

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "library";

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM users WHERE userid = '".$userid."'";
            $stat = $conn->query($sql);
            $users = $stat->fetchAll(PDO::FETCH_ASSOC);

            $response->getBody()->write(json_encode(array("status" => "success", "users" => $users)));
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Invalid or Expired Token"))));
        }

    return $response;
});




$app->post('/user/password', function(Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $pass = $data->password; 
    $jwt = $data->token;
    $key = 'server_hack';

    try {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        $userid = $decoded->data->userid;

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "library";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE users SET password = '".hash('SHA256',$pass)."' WHERE userid = '".$userid."'";
        $stat = $conn->query($sql);
        $users = $stat->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode(array("status" => "success")));
    } catch (Exception $e) {
        $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Invalid or Expired Token"))));
    }

    return $response;
});



$app->post('/user/delete', function(Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $usr = $data->username;
    $jwt = $data->token;
    $key = 'server_hack';

    try {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        $userid = $decoded->data->userid;

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "library";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM users WHERE userid = '".$userid."'";
        $conn->exec($sql);

        $response->getBody()->write(json_encode(array("status" => "success", "data" => null)));
    } catch (Exception $e) {
        $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Invalid or Expired Token"))));
    }

    return $response;
});



$app->post('/book/authenticate', function (Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $usr = $data->username;
    $pass = $data->password; 
    $bookkey = 'book_hack';

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM users WHERE username = '".$usr."' AND password = '".hash('SHA256', $pass)."'";
        $stat = $conn->query($sql);
        $data = $stat->fetchAll(PDO::FETCH_ASSOC);

        if (count($data) == 1) {
            $bookkey = 'book_hack';
            $iat = time();
            $payload = [
                'iss' => 'http://library.org',
                'aud' => 'http://library.com',
                'iat' => $iat,
                'exp' => $iat + 300,
                'data' => [
                    "bookid" => $books[0]['bookid'] ?? null 
                ]
            ];
            $bookjwt = JWT::encode($payload, $bookkey, 'HS256');

            $response->getBody()->write(json_encode(array("status" => "success", "book token" => $bookjwt)));
        } else {
            $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Authentication Failed"))));
        }
    } catch (PDOException $e) {
        $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Database Error"))));
    }
    return $response;
});



$app->post('/book/view', function(Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $bookjwt = $data->book_token;
    $bookkey = 'book_hack';

        try {
            $decoded = JWT::decode($bookjwt, new Key($bookkey, 'HS256'));

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "library";

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM books";
            $stat = $conn->query($sql);
            $books = $stat->fetchAll(PDO::FETCH_ASSOC);

            $response->getBody()->write(json_encode(array("status" => "success", "books" => $books)));
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Invalid or Expired Token"))));
        }

    return $response;
});



$app->post('/book/add', function(Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $bookjwt = $data->book_token;
    $title = $data->title;
    $pages = $data->pages;

    $bookkey = 'book_hack';
        try {
            $decoded = JWT::decode($bookjwt, new Key($bookkey, 'HS256'));

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "library";

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO books (title, author, pages, status) VALUES ('".$title."', '".$author."', '".$pages."', 'free')";
            $conn->exec($sql);

            $response->getBody()->write(json_encode(array("status" => "success")));
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Invalid or Expired Token"))));
        }

    return $response;
});




$app->post('/book/return', function(Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $bookid = $data->bookid;
    $bookjwt = $data->book_token;
    $bookkey = 'book_hack';

    try {
        $decoded = JWT::decode($bookjwt, new Key($bookkey, 'HS256'));

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "library";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE books SET status = 'borrowed' WHERE bookid = '".$bookid."'";
        $stat = $conn->query($sql);
        $books = $stat->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode(array("status" => "success")));
    } catch (Exception $e) {
        $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Invalid or Expired Token"))));
    }

    return $response;

});



$app->post('/book/borrow', function(Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $bookid = $data->bookid;
    $bookjwt = $data->book_token;
    $bookkey = 'book_hack';

    try {
        $decoded = JWT::decode($bookjwt, new Key($bookkey, 'HS256'));

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "library";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE books SET status = 'free' WHERE bookid = '".$bookid."'";
        $stat = $conn->query($sql);
        $books = $stat->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode(array("status" => "success")));
    } catch (Exception $e) {
        $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Invalid or Expired Token"))));
    }

    return $response;

});






$app->post('/author/authenticate', function (Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $usr = $data->username;
    $pass = $data->password; 
    $authorkey = 'author_hack';

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM users WHERE username = '".$usr."' AND password = '".hash('SHA256', $pass)."'";
        $stat = $conn->query($sql);
        $data = $stat->fetchAll(PDO::FETCH_ASSOC);

        if (count($data) == 1) {
            $authorkey = 'author_hack';
            $iat = time();
            $payload = [
                'iss' => 'http://library.org',
                'aud' => 'http://library.com',
                'iat' => $iat,
                'exp' => $iat + 300,
                'data' => [
                    "author" => $author[0]['authorid'] ?? null // Safe access
                ]
            ];
            $authorjwt = JWT::encode($payload, $authorkey, 'HS256');

            $response->getBody()->write(json_encode(array("status" => "success", "author token" => $authorjwt)));
        } else {
            $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Authentication Failed"))));
        }
    } catch (PDOException $e) {
        $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Database Error"))));
    }
    return $response;
});


$app->post('/author/view', function(Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $jwt = $data->author_token;
    $key = 'author_hack';

        try {
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "library";

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM authors";
            $stat = $conn->query($sql);
            $authors = $stat->fetchAll(PDO::FETCH_ASSOC);

            $authorkey = 'author_hack';
            $iat = time();
            $payload = [
                'iss' => 'http://library.org',
                'aud' => 'http://library.com',
                'iat' => $iat,
                'exp' => $iat + 300,
                'data' => [
                    "bookid" => $authors[0]['authorid'] ?? null
                ]
            ];
            $authorjwt = JWT::encode($payload, $authorkey, 'HS256');

            $response->getBody()->write(json_encode(array("status" => "success", "author token" => $authorjwt, "authors" => $authors)));
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Invalid or Expired Token"))));
        }

    return $response;
});




$app->post('/author/add', function(Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $jwt = $data->author_token;
    $author = $data->author;
    $key = 'author_hack';

        try {
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "library";

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO authors (name) VALUES ('".$author."')";
            $conn->exec($sql);

            $response->getBody()->write(json_encode(array("status" => "success")));
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(array("status" => "fail", "data" => array("title" => "Invalid or Expired Token"))));
        }

    return $response;
});





$app->run();
?>
