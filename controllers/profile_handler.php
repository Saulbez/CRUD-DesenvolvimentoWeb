<?php

session_start();

include("../classes/connect.php");
include("../classes/login.php");

$message = '';
$showNewPasswordForm = false;

if(isset($_SESSION['collab_sessionid'])) {

    $id = $_SESSION['collab_sessionid'];
    $login = new Login();

    $result = $login->check_login($id);
    $DB = new Database();
    $DB->connect();
    
    if($result) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['verify_password'])) {
                $currentPassword = $_POST['current_password'];

                $query = "select user_password from users where session_id = ? limit 1";
                $types = "s";
                $params = ["$id"];

                $result = $DB->read($query, $types, ...$params);

                $hashedPassword = $result[0]['user_password'];

                if(password_verify($currentPassword, $hashedPassword)) {
                    $showNewPasswordForm = true;

                    $message = 'Por favor, digite a nova senha:';
                } else {
                    $message = 'Senha incorreta';
                }

                $_SESSION['passwordVerified'] = true;
        
            } elseif (isset($_POST['change_password'])) {
                $newPassword = $_POST['new_password'];
            
                if (strlen($newPassword) < 6) {
                    $message = 'A senha deve ser no mínimo 6 caracteres';
                    $_SESSION['passwordVerified'] = true;
                    $showNewPasswordForm = true;
                } else {
                    $query = 'update users set user_password = ? where session_id = ?';
                    $types = 'ss';
                    $params = [password_hash($newPassword, PASSWORD_DEFAULT), $id];
            
                    $result = $DB->save($query, $types, ...$params);
            
                    if ($result) {
                        $message = 'Senha atualizada!';
                        $showNewPasswordForm = false;
                    } else {
                        $message = 'Erro ao atualizar senha';
                    }
                }
            } elseif (isset($_FILES['profile-image'])) {
                if($_FILES['profile-image']['error'] != 4) {
                    $profile_image = $_FILES['profile-image'];

                    $img_name = $profile_image['name'];
                    $img_ext = $profile_image['type'];
                    $img_size = $profile_image['size'];
                    $tmp_name = $profile_image['tmp_name'];
                    $img_error = $profile_image['error'];

                    if ($img_error === 0) {
                        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_lc = strtolower($img_ext);
        
                        $allowed_exts = array("jpg", "jpeg", "png");
        
                        if (in_array($img_ex_lc, $allowed_exts)) {
        
                            if ($img_size > 12500000) {
                                $imageErrorMessage = "Desculpe, seu arquivo é grande demais.";
                            } else {
                                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                                $img_upload_path = $_SERVER['DOCUMENT_ROOT'] . '/CRUD-DesenvolvimentoWeb/image-uploads/profile/' . $new_img_name;
                                if (move_uploaded_file($tmp_name, $img_upload_path)) {

                                    $query = "select profile_image from users where session_id = ? limit 1";
                                    $types = "s";
                                    $params = [$id];

                                    $result = $DB->read($query, $types, ...$params);

                                    $image_path = $result[0]['profile_image'];
                                    define('ROOT_DIR', realpath(__DIR__ . '/../'));
                                    $full_image_path = ROOT_DIR . '/image-uploads/profile/' . $image_path;

                                    if (file_exists($full_image_path) && $image_path  != 'user.png') {

                                        chmod($full_image_path, 0777);
                                        unlink($full_image_path);
                                    }

                                } else {
                                    $imageErrorMessage = 'Error moving the uploaded image: ' . error_get_last()['message'];
                                }


                                $query = "update users set profile_image = ? where session_id = ?";
                                $types = "ss";
                                $params = [$new_img_name, $id];

                                $result = $DB->save($query, $types, ...$params);

                            }
                        } else {
                            $imageErrorMessage = "Desculpe, apenas imagens são permitidas.";
                        }
                    }
                }
            } elseif (isset($_POST['new-username'])) {
                $query = "update users set username = ? where session_id = ?";
                $types = "ss";
                $params = [$_POST['new-username'], $id];

                $result = $DB->save($query, $types, ...$params);
            } elseif (isset($_POST['logoff'])) {
                $_SESSION = [];
                session_destroy();
                header("Location: ../index.php");
                exit();
            }
        }
    }
} else {
    echo  "Você não está conectado";
}

$_SESSION['message'] = $message;
$_SESSION['showNewPasswordForm'] = $showNewPasswordForm;
$_SESSION['imageErrorMessage'] = $imageErrorMessage;

header("Location: ../profile.php");
exit();

?>