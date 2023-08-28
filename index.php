<?php
// Ket noi voi DB
require_once 'db.php';
?>

        
        <?php
        // Client gui yeu cau den  ProductController, toi PT index, de lay toan bo du lieu ra

        /*
        index.php?Controllers=product&action=index
        index.php?Controllers=product&action=create
        index.php?Controllers=product&action=edit&id=5
        index.php?Controllers=product&action=show&id=5

        index.php?Controllers=customer&action=index
        */
        
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        $controllers = isset($_GET['controllers']) ? $_GET['controllers'] : 'product';

        switch ($controllers) {
            case 'product':
                require_once 'Controllers/ProductController.php';
                $objController = new ProductController();
                break;    
            case 'category':
                require_once 'Controllers/CategoryController.php';
                $objController = new CategoryController();
                break;    
            default:
                # code...
                break;
        }
        switch ($action) {
            case 'index':
                $objController->index();
                break;
            case 'create':
                $objController->create();
                break;
            case 'store':
                $objController->store();
                break;
            case 'edit':
                $objController->edit();
                break;
            case 'update':
                $objController->update();
                break;
            case 'show':
                $objController->show();
                break;
            case 'destroy':
                $objController->destroy();
                break;
            default:
                # code...
                break;
        }
        ?>


