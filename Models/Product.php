<?php
// Ket noi voi database
class Product
{
    // lay ta ca du lieu
    public static function all()
    {
        global $conn;

        if (isset($_GET["s"]) || isset($_GET["s1"])) {
            $s = isset($_GET["s"]) ? $_GET["s"] : "";
            $s1 = isset($_GET["s1"]) ? $_GET["s1"] : "";
            $conditions = [];

            if (!empty(trim($s))) {
                $conditions[] = "(products.name LIKE '%$s%')";
            }

            if (!empty(trim($s1))) {
                $conditions[] = "products.id LIKE '%$s1%'";
            }

            $conditionsString = implode(" OR ", $conditions);

            $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                JOIN categories ON products.category_id = categories.id";

            if (!empty($conditionsString)) {
                $sql .= " WHERE $conditionsString";
            }

            $sql .= " ORDER BY products.id DESC";
        } else {
            $s = "";
            $s1 = "";
            $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                JOIN categories ON products.category_id = categories.id
                ORDER BY products.id DESC";
        }

        $phonesPerPage = 4;
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start_index = ($current_page - 1) * $phonesPerPage;

        // Thay đổi câu truy vấn đếm tổng số bản ghi phù hợp với điều kiện tìm kiếm
        $sql_count = "SELECT COUNT(*) AS total_records FROM products
                JOIN categories ON products.category_id = categories.id";

        if (!empty($conditionsString)) {
            $sql_count .= " WHERE $conditionsString";
        }

        $stmt_count = $conn->query($sql_count);
        $total_records = $stmt_count->fetch(PDO::FETCH_ASSOC)['total_records'];

        $sql .= " LIMIT $start_index, $phonesPerPage";
        $stmt = $conn->query($sql);
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);

        $data = [
            'products' => $products,
            'total_records' => $total_records,
            'current_page' => $current_page,
            'phones_per_page' => $phonesPerPage,
            'search_s' => $s, // Thêm biến search_s để giữ lại giá trị của tham số tìm kiếm s
            'search_s1' => $s1, // Thêm biến search_s1 để giữ lại giá trị của tham số tìm kiếm s1
        ];

        // Trả về cho Model
        return $data;
    }



    // lay chi tiet 1 du lieu
    public static function find($id)
    {
        global $conn;
        $sql = "SELECT products.*, categories.name AS category_name
        FROM products
        JOIN categories ON products.category_id = categories.id
        WHERE products.id = $id";

        $stmt = $conn->query($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();
        return $row;
    }

    // Them moi du lieu
    public static function store($data)
    {

        global $conn;
        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $category_id  = $data['category_id'];
        if (isset($_FILES['image'])) {
            if (!$_FILES['image']['error']) {
                move_uploaded_file($_FILES['image']['tmp_name'], ROOT_DIR . '/public/uploads/' . $_FILES['image']['name']);
                $image = '/public/uploads/' . $_FILES['image']['name'];
            }
        }

        $sql = "INSERT INTO `products` 
            ( `name`, `description`, `price`,`image`,`category_id`) 
            VALUES 
            ('$name','$description','$price','$image','$category_id')";
        //Thuc hien truy van
        $conn->exec($sql);
        return true;
    }

    public static function create()
    {
        global $conn;
        $sql = "SELECT * FROM `products`";
        $stmt = $conn->query($sql);
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $row;
    }
    // Cap nhat du lieu
    public static function update($id, $data)
    {
        global $conn;
        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $category_id  = $data['category_id'];

        // Kiểm tra xem đã tải lên ảnh mới hay chưa
        if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            // Đường dẫn thư mục tải lên
            $uploadDir = ROOT_DIR . '/public/uploads/';

            // Xóa ảnh cũ nếu có
            $sql = "SELECT `image` FROM `products` WHERE `id` = $id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $oldImage = $stmt->fetchColumn();

            if ($oldImage && file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage);
            }

            // Di chuyển ảnh mới vào thư mục đích
            $newImage = $uploadDir . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $newImage);
            $image = '/public/uploads/' . $_FILES['image']['name'];
        } else {
            // Không có ảnh mới được tải lên, giữ nguyên ảnh cũ
            $sql = "SELECT `image` FROM `products` WHERE `id` = $id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $image = $stmt->fetchColumn();
        }

        $sql = "UPDATE `products` SET `name` = :name, `description` = :description, `image` = :image, `price` = :price, `category_id` = :category_id WHERE `id` = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
        return true;
    }


    //Xoa du lieu
    public static function delete($id)
    {
        global $conn;
        $sql = "DELETE FROM `products` WHERE `id` = $id";
        // Thuc thi SQL
        $conn->exec($sql);
        return true;
    }
}
