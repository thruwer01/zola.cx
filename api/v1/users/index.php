<?php 

include $_SERVER['DOCUMENT_ROOT']."/var/autoload.php";
header('Content-Type: application/json');


$perPage = ($_GET['perPage']) ? $_GET['perPage'] : 20;
$page = ($_GET['page']) ? $_GET['page'] : 1;


if ($_SESSION['user']) {
    $userEmail = $_SESSION['user'];
    $userTypeId = $db->query("SELECT * FROM `users` WHERE `email` = '$userEmail'")->fetch_assoc()['user_type_id'];
    $userType = $db->query("SELECT * FROM `user_types` WHERE `id` = '$userTypeId'")->fetch_assoc()['name'];
    
    if ($userType == 'admin') {
        $counter = $db->query("SELECT COUNT(*) as `counter` FROM `users`")->fetch_assoc()['counter'];
        
        $totalPages = ceil($counter / $perPage);
        $from = ($page - 1) * $perPage;

        $res = $db->query("SELECT * FROM `users` LIMIT $from, $perPage");
        if ($res->num_rows > 0) {

            $out['result'] = 'success';

            while($user = $res->fetch_assoc()) {
                $out['data'][] = $user;
            }
            
            $out['pages'] = [
                "current_page" => $page,
                "per_page" => $perPage,
                "total_pages" => $totalPages
            ];
            if ((int)$page !== (int)$totalPages) {
                $out['pages']["last_page_url"] = "/api/v1/users?perPage=$perPage&page=$totalPages";
                $out['pages']["last_page"] = $totalPages;
            }
            if ((int)$page !== (int)1) {
                $out['pages']["prev_page_url"] = "/api/v1/users?perPage=$perPage&page=".($page-1);
                $out['pages']["prev_page"] = (int)$page-1;

            }
            if ((int)$page < $totalPages) {
                $out['pages']["next_page_url"] = "/api/v1/users?perPage=$perPage&page=".($page+1);
                $out['pages']["next_page"] = (int)$page+1;
            }
            echo json_encode($out);
        } else {
            echo json_encode([
                "result" => "error",
                "error" => [
                    "status_code" => 404,
                    "error_message" => "No data avaible."
                ]
            ]);
        }

    } else {
        echo json_encode([
            "result" => "error",
            "error" => [
                "status_code" => 403,
                "error_message" => "Forbidden."
            ]
        ]);
    }

} else {
    echo json_encode([
        "result" => "error",
        "error" => [
            "status_code" => 401,
            "error_message" => "Unauthorized."
        ]
    ]);
    http_response_code(401);
}

?>