<?php
echo '<br>'.__FILE__;
?>
<a href="index.php?action=create"> Them moi </a>
<table border="1">
    <tr>
        <th>STT</th>
        <th>Tên danh mục </th>
        <th>Mô tả</th>
    
        <th>ACTION</th>
    </tr>

    <!-- Bắt đầu lặp -->
<?php
        foreach($items as $r) :
            // echo '<pre>';
            // print_r($r);
            // die();
        ?>   
    <tr>
        <td><?php echo $r['id'];?> </td>
        <td><?php echo $r['name'];?> </td>
        <td><?php echo $r['description'];?> </td>
   
        <td>
            <a href="index.php?action=edit&id=<?php echo $r['id'];?>">Sua</a> |  
            <a href="index.php?action=show&id=<?php echo $r['id'];?>">Xem</a> |  
            <a onclick=" return confirm('Are you sure ?'); " href="index.php?action=destroy&id=<?php echo $r['id'];?>">Xoa</a> 
        </td>
    </tr>

    <!-- Kết thúc vòng lặp -->
    <?php endforeach; ?>
</table>