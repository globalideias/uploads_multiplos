<?php
$conectar = mysql_connect('localhost', 'root', 'm1a2r3') or die(mysql_error());
if ($conectar) {
    $banco = mysql_select_db('uploads_multiplos');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script type="text/javascipt" src="scripts/jquery-1.9.1.min.js"/></script>
        <script type="text/javascipt" src="scripts/jquery.MultiFile.js"/></script>
        <script type="text/javascipt" src="scripts/jquery.MultiFile.pack.js"/></script>
        <script type="text/javascipt" src="scripts/jquery.validate.js"/></script>
        <script type="text/javascipt" src="scripts/jquery.form.js"/></script>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Uploads Múltiplos</title>
    </head>

    <body>
        <?php
        if (isset($_POST['upload'])) {

            $pasta = 'uploads/';
            $id_upload = 0;

            $i = 0;
            foreach ($_FILES["img"]["error"] as $key => $error) {

                if ($error == UPLOAD_ERR_OK) {

                    if ($i == 0) {

                        mysql_query("INSERT INTO uploads (detalhes,datacadastro) Values ('---INFO UPLOAD ---','" . date("Y-m-d H:i:s") . "')");
                        $id_upload = mysql_insert_id();
                    }

                    $tmp_name = $_FILES["img"]["tmp_name"][$key];
                    $nome = $_FILES["img"]["name"][$key];
                    $uploadfile = $pasta . basename($nome);



                    if (move_uploaded_file($tmp_name, $uploadfile)) {

                        echo "Arquivos(s) Enviado(s) com Sucesso!<br>";

                        $inserir = mysql_query("INSERT INTO imagens (id_upload,imagem) Values ('$id_upload','$nome')");
                        
                        $i++;
                        
                    } else {

                        echo "Erro ao enviar o(s) arquivos(s)";
                    }
                }
            }
        }
        ?>

        <form id="upload" name="upload" method="post" action="" enctype="multipart/form-data">
            <input name="img[]" accept="png|jpg|gif" type=file multiple /><br />
            <input type="submit" name="upload" Value="Upload"/>
        </form>
    </body>
</html>