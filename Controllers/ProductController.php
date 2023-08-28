<?php
require_once 'Models/Category.php';
require_once 'Models/Product.php';
class ProductController {
    // Hien thi danh sach records => table
    public function index(){
        $products = Product::all();
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            $successMessage = 'THÊM THÀNH CÔNG!';
        }
        else if (isset($_GET['success']) && $_GET['success'] == 2) {
            $successMessage1 = 'CẬP NHẬT THÀNH CÔNG!';
        }
        else if (isset($_GET['success']) && $_GET['success'] == 3) {
            $successMessage2 = 'XÓA THÀNH CÔNG!';
        }
        // Truyen data xuong view
        require_once 'Views/products/index.php';
       
    }
    // Hien thi form them moi
    public function create(){
        $categories = Category::all();

        // var_dump($teams1);
        // die();
        require_once 'Views/products/create.php';
    }
    // Xu ly them moi
    public function store(){

        $errors = array();
      
            // Lấy dữ liệu
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            if (empty($name)){
                $errors['name'] = 'Bạn chưa nhập tên sản phẩm';
            }
            $date = isset($_POST['price']) ? $_POST['price'] : '';
            if (empty($date)){
                $errors['price'] = 'Bạn chưa nhập giá';
            }
        
        
            // Lưu dữ liệu
            if (count($errors) == 0){
               // Goi model
               Product::store($_POST);
                // Chuyen huong ve trang danh sach
                header("Location: index.php?controller=product&action=index&success=1");
            }else{
                $brands1 = Brand::create();
                require_once 'Views/products/create.php';
            }
        
        

    }
    // Hien thi form chinh sua
    public function edit(){
        $id = $_GET['id'];
        $r = Product::find($id);
        $brands1 = Category::create();
         // var_dump($teams1);
        // die();
        // Truyen xuong view
        require_once 'Views/products/edit.php';
    }
    // Xu ly chinh sua
    public function update(){
        $id = $_GET['id'];
        Product::update( $id, $_POST );
        // Chuyen huong ve trang danh sach
        header("Location: index.php?controller=Product&action=index&success=2");
    }

    // Xoa
    public function destroy(){
        $id = $_GET['id'];
        Product::delete($id);
        // Chuyen huong ve trang danh sach
        header("Location: index.php?controller=Product&action=index&success=3");
    }
    // Xem chi tiet
    public function show(){
        $id = $_GET['id'];
        $r = Product::find($id);
        // Truyen xuong view
        require_once 'Views/products/show.php';
    }
}