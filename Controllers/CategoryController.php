<?php
require_once 'Models/Category.php';
class CategoryController {
    // Hien thi danh sach records => table
    public function index(){
        $items = Category::all();
       
        // Truyen data xuong view
        require_once 'Views/categories/index.php';
       
    }
    // Hien thi form them moi
    public function create(){
        require_once 'Views/categories/create.php';
    }
    // Xu ly them moi
    public function store(){
        // Goi model
        // Product::store($_POST);
        // Chuyen huong ve trang danh sach
        header("Location: index.php?controller=product&action=index");

    }
    // Hien thi form chinh sua
    public function edit(){
        // $id = $_GET['id'];
        // $row = Product::find($id);
        // Truyen xuong view
        require_once 'Views/categories/edit.php';
    }
    // Xu ly chinh sua
    public function update(){
        // $id = $_GET['id'];
        // Product::update( $id, $_POST );
        // Chuyen huong ve trang danh sach
        header("Location: index.php?controller=product&action=index");
    }

    // Xoa
    public function destroy(){
        // $id = $_GET['id'];
        // Product::delete($id);
        // Chuyen huong ve trang danh sach
        header("Location: index.php?controller=product&action=index");
    }
    // Xem chi tiet
    public function show(){
        // $id = $_GET['id'];
        // $row = Product::find($id);

        // Truyen xuong view
        require_once 'Views/categories/show.php';
    }
}