<?php
if (isset($_POST['submit'])) {
    // 检查上传的文件是否存在
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'upload/';  // 上传文件的目标文件夹
        $fileName = $_POST['fileName'];  // 客户端提供的文件名
        $fileTmpPath = $_FILES['file']['tmp_name'];  // 临时文件路径
        $fileExtension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));  // 获取文件扩展名

        // 确保目录存在
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // 生成完整的文件路径
        $destination = $uploadDir . $fileName . '.' . $fileExtension;

        // 检查是否是图片类型
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedFileTypes)) {
            // 检查文件名是否重复，如果重复则在文件名后添加数字后缀
            $counter = 1;
            $originalDestination = $destination;
            while (file_exists($destination)) {
                $destination = $uploadDir . $fileName . "($counter)." . $fileExtension;
                $counter++;
            }

            // 移动上传的文件到目标文件夹
            if (move_uploaded_file($fileTmpPath, $destination)) {
                // 上传成功后直接跳转到 zhuye.php 页面
                header('Location: zhuye.php');
                exit;
            } else {
                echo '<p class="message">移动文件时发生错误。</p>';
            }
        } else {
            echo '<p class="message">无效的文件类型。只允许 JPG、JPEG、PNG 和 GIF 格式。</p>';
        }
    } else {
        echo '<p class="message">未上传文件或上传错误。</p>';
    }
}
?>
