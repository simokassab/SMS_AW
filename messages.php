<?php  if (count($errors) > 0) : ?>
    <div class="msg">
        <?php foreach ($errors as $error) : ?>
           <center><span style="color: #EB078C;"><?php echo $error ?></span></center>
        <?php endforeach ?>
    </div>
<?php  endif ?>