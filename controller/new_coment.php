<?php

    include "model/conexion.php"; 

    if (isset($_POST["bto_ec"])) { 
        $userName = $_POST["userName"];
        $userEmail = $_POST["userEmail"];
        $commentText = $_POST["commentText"];

        if (!empty($userName) && !empty($userEmail) && !empty($commentText)) {
            $stmt = $con->prepare("INSERT INTO comentarios (`nombre_o_usuario`, `email`, `nota`, `fecha_nota`) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $userName, $userEmail, $commentText);

            if ($stmt->execute()) {
                header("Location: index.php#Comentarios"); 
                exit();
            } else {
                echo "<div class='error-message'>Error al enviar comentario: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='error-message'>Todos los campos son obligatorios.</div>";
        }
    }

    if (isset($_GET['delete_id'])) {
        $idToDelete = $_GET['delete_id'];
        $stmt = $con->prepare("DELETE FROM comentarios WHERE id = ?");
        $stmt->bind_param("i", $idToDelete);

        if ($stmt->execute()) {
            header("Location: index.php#Comentarios");
            exit();
        } else {
            echo "<div class='error-message'>Error al eliminar comentario: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }

    if (isset($_POST['edit_comment_id'])) {
        $editId = $_POST['edit_comment_id'];
        $editUserName = $_POST['userName'];
        $editUserEmail = $_POST['userEmail'];
        $editCommentText = $_POST['commentText'];

        if (!empty($editUserName) && !empty($editUserEmail) && !empty($editCommentText)) {
            $stmt = $con->prepare("UPDATE comentarios SET `nombre_o_usuario` = ?, `email` = ?, `nota` = ? WHERE `id` = ?");
            $stmt->bind_param("sssi", $editUserName, $editUserEmail, $editCommentText, $editId);

            if ($stmt->execute()) {
                header("Location: index.php#Comentarios");
                exit();
            } else {
                echo "<div class='error-message'>Error al actualizar comentario: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='error-message'>Todos los campos son obligatorios para actualizar.</div>";
        }
    }
?>