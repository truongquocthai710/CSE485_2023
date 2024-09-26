<?php
include "../../config/db_connect.php";

$authors = array();
$sqlAuthor = "CALL sp_TacGia_getAll()";
$resultAuthor = mysqli_query($conn, $sqlAuthor);

if ($resultAuthor === false) {
    echo "Error executing query for authors: " . mysqli_error($conn);
    exit;
} else {
    $authors = mysqli_fetch_all($resultAuthor, MYSQLI_ASSOC);
    mysqli_free_result($resultAuthor);
    mysqli_next_result($conn);
}

$categories = array();
$sqlCategory = "CALL sp_TheLoai_getAll()";
$resultCategory = mysqli_query($conn, $sqlCategory);

if ($resultCategory === false) {
    echo "Error executing query for categories: " . mysqli_error($conn);
    exit;
} else {
    $categories = mysqli_fetch_all($resultCategory, MYSQLI_ASSOC);
    mysqli_free_result($resultCategory);
    mysqli_next_result($conn);
}

$message = "";
isset($_GET['message']) ? $message = $_GET['message'] : $message = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/style_login.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../index.php">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../index.php">Trang ngoài</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../category/category.php">Thể loại</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../author/author.php">Tác giả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active fw-bold" href="../article/article.php">Bài viết</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold">Thêm mới thông tin bài viết</h3>
                <form action="./process/process_add_article.php" method="post">
                    <div class="form-group">
                        <label for="title">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title" require>
                    </div>
                    <div class="form-group">
                        <label for="songName">Tên bài hát</label>
                        <input type="text" class="form-control" id="songName" name="songName" require>
                    </div>
                    <div class="form-group">
                        <label for="categoryId">Thể loại</label>
                        <select class="form-select" id="categoryId" name="categoryId" require>
                            <option selected>-- Chọn thể loại --</option>
                            <?php
                            foreach ($categories as $category) {
                                echo '<option value="' . $category['ma_tloai'] . '">' . $category['ten_tloai'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="summary">Tóm tắt</label>
                        <textarea class="form-control" id="summary" name="summary" rows="3" require></textarea>
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung</label>
                        <textarea class="form-control" id="content" name="content" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="authorId">Tác giả</label>
                        <select class="form-select" id="authorId" name="authorId" require>
                            <option selected>-- Chọn tác giả --</option>
                            <?php
                            foreach ($authors as $author) {
                                echo '<option value="' . $author['ma_tgia'] . '">' . $author['ten_tgia'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Ảnh</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-warning text-center mt-3">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group float-end mt-3">
                        <input type="submit" value="Thêm" class="btn btn-success">
                        <a href="./article.php" class="btn btn-warning ">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary  border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>