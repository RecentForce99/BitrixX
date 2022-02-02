<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
#print_r($arResult);
?>
<h1>Можете не пытаться, не работает(</h1>

<form action="back-end/UsersManipulation.php" method="post">
    <?php if($arResult['CLASS_NAME'] === 'Profile' || 'Connection'):?>

    <label for="NAME" class=" w-25">Имя</label>
    <input id="NAME" type="text" name="NAME" class="form-control w-25">

    <label for="EMAIL" class="w-25">Почта</label>
    <input id="EMAIL" type="text" name="EMAIL" class="form-control w-25 ">

    <input type="submit" value="Добавить" class="btn btn-primary form-control mt-2" style="width: 8rem">



<?php elseif($arResult['CLASS_NAME'] === 'Addresses'):?>


        <label for="COUNTRY" class=" w-25">Страна</label>
        <input id="COUNTRY" type="text" name="COUNTRY" class="form-control w-25">

        <label for="ADDRESS" class="w-25">Адрес</label>
        <input id="ADDRESS" type="text" name="ADDRESS" class="form-control w-25 ">

        <label for="PHONE_NUMBER" class="w-25">Номер телефона</label>
        <input id="PHONE_NUMBER" type="text" name="PHONE_NUMBER" class="form-control w-25 ">

        <input type="submit" value="Добавить" class="btn btn-primary form-control mt-2" style="max-width: 8%">
<?php endif;?>
    </form>

