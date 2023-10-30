<?php

// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");


function home()
{
    return ROOT_URL."/home";
}

function signup()
{
    return ROOT_URL."/signup";
}

function login()
{
    return ROOT_URL."/login";
}
function logout()
{
    return ROOT_URL."/logout";
}
function verify_OTP()
{
    return ROOT_URL."/verify_OTP";
}

function forgot_PWD()
{
    return ROOT_URL."/forgot_PWD";
}

// check which php extensions are needed
function check_extensions()
{
    $required_extensions = [
        "gd",
        "pdo_mysql",
        "pdo_sqlite",
        "curl",
        "fileinfo",
        "intl",
        "exif",
        "mbstring"
    ];
    $not_loaded = [];
    foreach ($required_extensions as $ext) {
        if (!extension_loaded($ext)) {
            $not_loaded[] = $ext;
        }
    }

    if (!empty($not_loaded)) {
        show("Please load the following extensions in your php.ini file: <br>". implode("<br>", $not_loaded));
        die;
    }

}

function show_array($stuff) {
    echo "<pre>";
    var_dump($stuff);
    echo "</pre>";
}
function show($stuff) {
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}
function redirect($path)
{
    echo header("Location: ".ROOT_URL."/".$path);
    die;
}
function shorten_letter($string, $a) {
    $v = "";
    if (strlen($string)>$a) {
        $sstr= str_split($string, "1");
        foreach ($sstr as $i => $value) {
            echo $value;
            $v= $a - 1;
            if($i == $v) {
                break;
            }
        }
        $b = $sstr[$a];
        $b= "...";
        echo $b;
    } else {
        echo $string;
    }
}

function shorten_sentence($string, $a) {
    $v = "";
    $str_array= explode(" ", $string);
    if (count($str_array)>$a) {
        foreach ($str_array as $i => $value) {
            echo $value;
            $v= $a - 1;
            if($i == $v) {
                break;
            }
        }
        $b = $str_array[$a];
        $b= "...";
        echo $b;
    } else {
        echo $string." ";
    }
}
function test_function($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/** load image, if image not exist, load placeholder */
function get_image(mixed $file = "", string $type = "post"): string
{
    $file = $file ?? "";
    if (file_exists($file)) {
        return ROOT_URL. "/". $file;
    } 

    if ($type == "user") {
        return ROOT_URL. "/assets/images/user.webp";
    } else {
        return ROOT_URL. "/assets/images/no_image.jpg";
    }
}

/** returns pagination links */
function get_pagination_vars(): array
{
    $vars = [];
    $vars["page"]      = $_GET["page"] ?? 1;
    $vars["page"]      = intval($vars["page"]);
    $vars["prev_page"] = $vars["page"] <= 1 ? 1 : $vars["page"] - 1;
    $vars["next_page"] = $vars["page"] + 1;

    return $vars;
}

/** saves or displays a saved message to the user */
function message(string $msg = null, bool $clear = false)
{
    $ses = new \app\model\Session();

    if (!empty($msg)) {
        $ses->set("message", $msg);
    } else
    if (!empty($ses->get("message"))) {
        $msg = $ses->get("message");
        if ($clear) {
            $ses->pop("message");
        }
        return $msg;
    }

    return false;
    
}

/**
 * retains and displays old select input values on a form after a refresh
 */
function old_select(string $key, mixed $value, mixed $default = "", string $mode = "post"): mixed
{
    $POST = $mode == "post" ? $_POST : $_GET;
    if (isset($POST[$key])) {
        if ($POST[$key] == $value) {
            return " selected ";
        }
    } else {
        if ($default == $value) {
            return " selected ";
        }
        return ""; 
    }
}

/**
 * retains and displays old text values or inputs on a form after a page refresh
 */
function old_value(string $key, mixed $default = "", string $mode = "post"): mixed
{
    $POST = $mode == "post" ? $_POST : $_GET;
    if (isset($POST[$key])) {
        return $POST[$key];
    } else {
        return $default;
    }
}

/**
 * retains and displays old checked radio or checkbox inputs of a form after a page refresh 
 */
function old_checked(string $key, string $value, string $default = ""): string
{
    if (isset($_POST[$key])) {
        if ($_POST[$key] == $value) {
            return " checked ";
        }
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "GET" && $default == $value) {
            return " checked ";
        }
    }
    return "";
}

/**
 *  returns a user readable date format
 */
function get_date($date): string 
{
    return date("jS M, Y", strtotime($date));
}

/**
 * converts images from text editor content to actual files
 */
function remove_images_from_content($content, $folder = "uploads/")
{
    // check if the folder exists
    if (!file_exists($folder)) {
        mkdir($folder, 0777,true);
        file_put_contents($folder."index.php", "Access Denied");
    }

    //remove images from content
    preg_match_all('/<img[^>]+>/', $content, $matches);

    if (is_array($matches) && count($matches) > 0) {
        $imageClass = new \app\model\Image();
        foreach ($matches[0] as $match) {
            if (strstr($match,"http")) {
                // ignore images with links already
                continue;
            }

            // get the src
            preg_match('/src="[^"]+/', $match, $matches2);

            //get the filename
            preg_match_all('/data-filename="[^\"]+/', $match, $matches3);

            if (strstr($matches2[0], 
            "data:")) {
                $parts = explode(",", $matches2[0]);
                $basename = $matches3[0] ?? "basename.jpg";
                $basename = str_replace('data-filename="', "", $basename);

                $filename = $folder . "img_". sha1(rand(0,9999999999)). $basename;

                $new_content = str_replace($parts[0].",". $parts[1], 'src="'. $filename, file_put_contents($filename, base64_decode($parts[1])));

                // resize image
                $imageClass->resize($filename, 1000);
            }
        }
    }
    return $new_content;
}

// deletes images from text editor content
function delete_images_from_content(string $content, string $content_new = ""): void
{
    // delete images from content
    if (empty($content_new)) {
        preg_match_all('/<img[^>]+>/', $content, $matches);

        if (is_array($matches) && count($matches) > 0) {
            foreach ($matches[0] as $match) {
                
                preg_match('/src="[^"]+/', $match, $matches2);
                $matches2[0] = str_replace('src="', "", $matches2[0]);

                if (file_exists($matches2[0])) {
                    unlink($matches2[0]);
                }

            }
        }
    } else {
        // compare old to new and delete from old what isn't in the new
        preg_match_all('/<img[^>]+>/', $content, $matches);
        preg_match_all('/<img[^>]+>/', $content_new, $matches_new);

        $old_images = [];
        $new_images = [];

        // collect od images
        if (is_array($matches) && count($matches) > 0) {
            
            foreach ($matches[0] as $match) {
                preg_match('/src="[^"]+/', $match, $matches2);
                $matches2[0] = str_replace('src="', "", $matches2[0]);
                if (file_exists($matches2[0])) {
                    $old_images[] = $matches2[0];
                }
            }

        }

        // collect new images
        if (is_array($matches) && count($matches) > 0) {
            
            foreach ($matches[0] as $match) {
                preg_match('/src="[^"]+/', $match, $matches2);
                $matches2[0] = str_replace('src="', "", $matches2[0]);
                if (file_exists($matches2[0])) {
                    $new_images[] = $matches2[0];
                }
            }

        }
        // compare and delete all that dont appear in the new array
        foreach ($old_images as $img) {
            if (in_array($img, $new_images)) {
                if (file_exists($img)) {
                    unlink($img);
                }
            }
        }
    }
}

/** converts image paths from relative to absolute */
function add_root_to_images($contents)
{
    preg_match_all('/<img[^>]+>/', $contents, $matches);
    if (is_array($matches) && count($matches) > 0 ) {
        foreach ($matches[0] as $match) {
            
            preg_match('/src="[^"]+/', $match, $matches2);
            if (!strstr($matches2[0], "http")) {
                $contents = str_replace($matches[0], 'src="'.ROOT_URL.'/'.str_replace('src="', "", $matches2[0]), $contents);
            }
        }
    }
    return $contents;
}

/** returns URL variables  */
function URL($key):mixed
{
    if (isset($_GET["url"])) {
        $splittedURL = explode("/", trim($_GET["url"], "/"));
    } else {
        $_GET["url"] = "home";
        $splittedURL = explode("/", trim($_GET["url"], "/"));
    }
    switch ($key) {
        case "page":
        case 0:
            return $splittedURL[0] ?? null;
            break;
        case "section":
        case "slug":
        case 1:
            return $splittedURL[1] ?? null;
            break;
        case "action":
        case 2:
            return $splittedURL[2] ?? null;
            break;
        case "id":
        case 3:
            return $splittedURL[3] ?? null;
            break;
        default:
            return null;
            break;
    }
}

// Get page Url
function getFullUrl() {
    show_array($_SERVER); 
}