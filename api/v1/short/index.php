<?php 

include "../../../var/autoload.php";

header('Content-Type: application/json');

$api_token = $_GET['api_token']; //api access token ||| type = string
$id = $_GET['id']; //db id ||| type = integer
$title = $_GET['title']; //name of content ||| type = string
$imdb_id = $_GET['imdb_id']; //content id from imdb.com ||| type = string
$year = $_GET['year'];
$language = $_GET['language'];
$category_id = $_GET['category_id'];



$page = ($_GET['page']) ? $_GET['page'] : 1;
$perPage = ($_GET['perPage']) ? $_GET['perPage'] : 100;


if ($api_token) {
    $res = $db->query("SELECT * FROM `users` WHERE `api_access_token` = '$api_token' LIMIT 1");
    if ($res->num_rows == 1) {
        //success autorized
        $sql = "SELECT * FROM `main_content` WHERE `name` LIKE '%$title%'";
        if ($category_id) {
            $sql .= " AND `category_id` = '$category_id'";
        }
        if ($id) {
            $sql .= " AND `id` = '$id'";
        }
        if ($year) {
            $sql .= " AND `year` = '$year'";
        }
        if ($language) {
            $sql .= " AND `language` = '$language'";
        }
        if ($category_id) {
            $sql .= " AND `category_id` = '$category_id'";
        }

        //pagination

        $countSql = "SELECT COUNT(*) as `count` FROM `main_content` WHERE `name` LIKE '%$title%'";
        if ($category_id) {
            $countSql .= " AND `category_id` = '$category_id'";
        }
        if ($id) {
            $countSql .= " AND `id` = '$id'";
        }
        if ($year) {
            $countSql .= " AND `year` = '$year'";
        }
        if ($language) {
            $countSql .= " AND `language` = '$language'";
        }
        if ($category_id) {
            $countSql .= " AND `category_id` = '$category_id'";
        }

        $count = $db->query("$countSql")->fetch_assoc()['count'];

        $totalPages = ceil($count / $perPage);
        $from = ($page - 1) * $perPage;

        $res = $db->query("$sql");
        if ($res->num_rows > 0) {
            $sql .= "LIMIT $from, $perPage";
            if ($page <= $totalPages) {
                $res = $db->query("$sql");
            } else {
                echo json_encode([
                    "result" => "error",
                    "error" => [
                        "status_code" => 400,
                        "error_message" => "Page must be less than $totalPages"
                    ]
                ]);
                http_response_code(400);
                exit();
            }
            $out['result'] = 'success';
            while($result = $res->fetch_assoc()) {
                //get content category
                $categoryId = $result['category_id'];
                $category = $db->query("SELECT `id`, `title_eng` FROM `categories` WHERE `id` = '$categoryId'");
                $categoryResult = $category->fetch_assoc();
                $categoryName = strtolower($categoryResult['title_eng']);
                //get content country
                $countryId = $result['country_id'];
                $country = $db->query("SELECT `id`,`iso`,`name_eng` FROM `countries` WHERE `id` = '$countryId'");
                $countryResult = $country->fetch_assoc();
                //get own content data
                $contentId = $result['id'];
                $contentSql = "SELECT * FROM `$categoryName` WHERE `content_id` = '$contentId'";
                if ($categoryName == 'movies' || $categoryName == 'series' || $categoryName == 'tv_shows'){
                    
                    //genres
                    $genres = $db->query("SELECT * FROM `content_genre` WHERE `content_id` = '$contentId'");
                    if ($genres->num_rows > 0) {
                        while($genre = $genres->fetch_assoc()) {
                            $genreId = $genre['genre_id'];
                            $cGenre = $db->query("SELECT `name_eng` FROM `genres` WHERE `id` = '$genreId'")->fetch_assoc()['name_eng'];
                            $contentGenres[] = $cGenre;
                        }
                    }
                }

                $content = $db->query($contentSql);
                if ($content->num_rows == 0) {
                    echo json_encode([
                        "result" => "error",
                        "error" => [
                            "status_code" => 404,
                            "error_message" => "Not found"
                        ]
                    ]);
                    http_response_code(404);
                    exit();
                }
                $contentResult = $content->fetch_assoc();

                unset($contentResult['content_id']);
                if ($contentResult['internal_id']) {
                    unset($contentResult['internal_id']);
                }


                if ($categoryName == 'sports') {
                    if ($contentResult['kind_id']) {
                        $kindId = $contentResult['kind_id'];
                        $kindName = $db->query("SELECT `name_eng` FROM `kinds_of_sports` WHERE `id` = '$kindId'")->fetch_assoc()['name_eng'];
                    }
                }

                $thisContent = [
                    "id" => $result['id'],
                    "title" => $result['name'],
                    "year" => $result['year'],
                    "date" => $result['date'],
                    "quality" => $result['quality'],
                    "language" => $result['language'],
                    "category" => [
                        "id" => $categoryId,
                        "name" => $categoryName
                    ],
                    "country" => [
                        "id" => $countryId,
                        "iso" => $countryResult['iso'],
                        "name" => $countryResult['name_eng']
                    ]
                ];
                if ($contentGenres) {
                    $thisContent['genres'] = $contentGenres;
                }

                if ($kindName) {
                    $thisContent['kind_of_sport'] = $kindName;
                }

                foreach($contentResult as $field => $value) {
                    if ($value !== 'null') {
                        $thisContent[$field] = $value;
                    }
                }
                if ($imdb_id !== null) {
                    if ($thisContent['imdb_id'] == $imdb_id) {
                        $out['data'][] = $thisContent;
                    } 
                } else {
                    $out['data'][] = $thisContent;
                }
            }
                $out['pages'] = [
                    "current_page" => $page,
                    "per_page" => $perPage,
                ];
                $out['total'] = [
                    "value" => $count
                ];
                if ((int)$page !== (int)$totalPages) {
                    $out['pages']["last_page_url"] = "/api/v1/short?perPage=$perPage&page=$totalPages";
                    $out['pages']["last_page"] = $totalPages;
                }
                if ((int)$page !== 1) {
                    $out['pages']["prev_page_url"] = "/api/v1/short?perPage=$perPage&page=".($page-1);
                    $out['pages']["prev_page"] = (int)$page-1;

                }
                if ((int)$page < $totalPages) {
                    $out['pages']["next_page_url"] = "/api/v1/short?perPage=$perPage&page=".($page+1);
                    $out['pages']["next_page"] = (int)$page+1;
                }
                if ($out['data']) {
                    echo json_encode($out);
                } else {
                    echo json_encode([
                        "result" => "error",
                        "error" => [
                            "status_code" => 404,
                            "error_message" => "Not found"
                        ]
                    ]);
                    http_response_code(404);
                }
        } else {
            echo json_encode([
                "result" => "error",
                "error" => [
                    "status_code" => 404,
                    "error_message" => "Not found"
                ]
            ]);
            http_response_code(404);
        }
        
    } else {
        echo json_encode([
            "result" => "error",
            "error" => [
                "status_code" => 401,
                "error_message" => "Unauthorized - bad api token."
            ]
        ]);
        http_response_code(401);
    }
} else {
    echo json_encode([
        "result" => "error",
        "error" => [
            "status_code" => 400,
            "error_message" => "api_token expected"
        ]
    ]);
    http_response_code(400);
}