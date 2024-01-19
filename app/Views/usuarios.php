<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title>
</head>
<body>
    <div style="margin: 0 auto;display: block;width: 500px;">
    <?php foreach ($usuarios as $item): ?>    
    <table width="100%" border="0">
        
            <tr >
                <td rowspan="4">
                    <img src="<?= $item["imageSrc"] ?>" style="width:200px;"> 
                </td>
                <td><?= $item["nombre"]." ".$item["apellido"] ?></td>
            </tr>
            <tr>
                <td><?=$item["celular"] ?></td>
            </tr>
            <tr>
                <td><?= $item["email"] ?></td>
            </tr>
            <tr>
                <td><?= $item["tipo_usuario"] ?></td>
            </tr>
        </table>
        <br><br><br><br>
        <?php endforeach ?>
    </div>
</body>
</html>