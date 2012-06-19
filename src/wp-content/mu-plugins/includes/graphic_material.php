<?php

$graphicMaterial = new GraphicMaterial;

if (isset($_POST['save'])) {
    check_admin_referer('graphic_material');
    
    try {
        $graphicMaterial->maybeChangePublicity();
    } catch (Exception $e) {
        echo "<div class='error'><p>{$e->getMessage()}</p></div>";
    }
}

?>

<div>
    <h1>Material gráfico</h1>
    <p>Use o menu ao lado para gerar os diferentes tipos de material gráfico (santinho, colinha e flyer).</p>
    <p>Utilize o link <a href="<?php echo GRAPHIC_MATERIAL_PUBLIC_URL; ?>" target="_blank"><?php echo GRAPHIC_MATERIAL_PUBLIC_URL; ?></a> para compartilhar o material gráfico gerado. O checkbox abaixo precisa estar selecionado para que o conteúdo do link seja público.</p>
    <form id="graphic_material_form" method="post">
        <?php wp_nonce_field('graphic_material'); ?>
        <input type='checkbox' name='graphic_material_public' <?php if ($graphicMaterial->isPublic()) echo ' checked="checked" '; ?>> Link público?<br /><br />
        <input type="submit" name="save" value="Salvar">
    </form>
</div>
    
