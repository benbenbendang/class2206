<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>已上传的图片</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            max-height: 80vh; /* 限制最大高度 */
            overflow-y: auto; /* 启用垂直滚动 */
        }

        .image-box {
            width: 150px;
            overflow: hidden;
            border: 2px solid #ccc;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            text-align: center;
            padding: 10px;
            cursor: pointer;
        }

        .image-box img {
            max-width: 100%;
            max-height: 100px;
            object-fit: cover;
            margin-bottom: 5px;
        }

        .image-info {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        /* 弹出层样式 */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal img {
            max-width: 90%;
            max-height: 90%;
        }

        .modal.show {
            display: flex;
        }
    </style>
</head>

<body>

    <h2>计算机2206请假表单</h2>
    <div class="gallery">
        <?php
        $uploadDir = 'upload/'; // 上传目录
        $images = glob($uploadDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE); // 获取所有图片文件

        if (count($images) === 0) {
            echo '<p>没有找到已上传的图片。</p>';
        } else {
            $fileNames = []; // 用于存储文件名，避免重复

            foreach ($images as $image) {
                $uploadTime = date("Y-m-d H:i:s", filemtime($image)); // 获取上传时间
                $fileName = basename($image); // 获取文件名称
                $originalName = $fileName; // 保留原始文件名

                // 检查文件名是否重复，如果重复则修改文件名
                $counter = 1;
                while (in_array($fileName, $fileNames)) {
                    $fileName = pathinfo($originalName, PATHINFO_FILENAME) . "($counter)." . pathinfo($originalName, PATHINFO_EXTENSION);
                    $counter++;
                }

                // 将文件名添加到数组中
                $fileNames[] = $fileName;

                echo '<div class="image-box" onclick="openModal(\'' . htmlspecialchars($image) . '\')">';
                echo '<div class="image-info">上传时间: ' . htmlspecialchars($uploadTime) . '</div>';
                echo '<div class="image-info">文件名称: ' . htmlspecialchars($fileName) . '</div>';
                echo '<img src="' . htmlspecialchars($image) . '" alt="Uploaded Image">';
                echo '</div>';
            }
        }
        ?>
    </div>

    <!-- 弹出层 -->
    <div class="modal" id="imageModal" onclick="closeModal()">
        <img id="modalImage" src="" alt="Enlarged Image">
    </div>

    <script>
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            modal.classList.add('show');
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('show');
        }
    </script>

</body>

</html>
