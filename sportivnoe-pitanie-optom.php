<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Спортивное питание оптом");
?>

  <div class="p-opt">
    <h1 class="p-opt__main-title">Спортивное питание оптом</h1>
    <p class="p-opt__descr">Наша компания осуществляет оптовые поставки спортивного питания на специальных условиях.</p>
    <p class="p-opt__descr">Многие фитнесс-клубы, интернет-магазины, профессиональные спортсмены и тренеры выбрали нас в качестве поставщика.
      Будем рады партнерству с Вами!</p>

    <h3 class="p-opt__title">Ваши преимущества от сотрудничества:</h3>
    <ul class="p-opt__list p-opt__features">
      <li>Широчайший ассортимент спортивного питания, аксессуаров для фитнеса</li>
      <li>Выгодные цены</li>
      <li>Еженедельные акции и специальные предложения</li>
      <li>Подбор оптимальной товарной матрицы для бара/магазина</li>
      <li>Сертифицированная продукция</li>
      <li>Возможность привезти товар под заказ</li>
      <li>Оперативная обработка заявок</li>
      <li>Быстрая доставка курьером</li>
      <li>Отправка через транспортные компании</li>
      <li>Личный менеджер</li>
      <li>Грамотная консультация</li>
      <li>Совместные промоакции, презентации, дегустации</li>
      <li>Всевозможные способы оплаты</li>
    </ul>

    <h3 class="p-opt__title">Мы умеем договариваться!</h3>

    <p><b>Условия сотрудничества:</b> минимальный заказ <b>от 15000руб.</b> в месяц.<br>
      Бесплатная доставка по Екатеринбургу при заказе <b>от 3000руб.</b></p>
    <div class="p-opt__price p-opt__price-row">
      <span class="p-opt__price-col p-opt__price-title">Запрос прайс-листа:</span>
      <form class="p-opt__price-col p-opt__price-form" action="#">
        <input id="p-opt__input" class="p-opt__input" type="text" name="emailOpt" placeholder="Ваш Email">
        <button class="p-opt__submit" type="submit">Получить прайс</button>
      </form>
    </div>

    <p class="p-opt__price-alt">Либо отправьте, пожалуйста, запрос на <a href="mailto:opt@fitmenu.ru">opt@fitmenu.ru</a>
    <p>

    <h3 class="p-opt__title">Контакты:</h3>
    <p><b>Тел.</b> +7(343) 351-05-85<br>
      <b>E-mail</b> <a href="mailto:opt@fitmenu.ru">opt@fitmenu.ru</a><br>
      <b>СуперМенеджер</b> Евгений Пантелеев</p>


    <h3 class="p-opt__title p-opt__title_center">Наши партнеры:</h3>
    <ul class="p-opt__partners">
      <li><img class="p-opt__partner-img" src="<?php echo SITE_TEMPLATE_PATH . '/images/opt/phg.png'; ?>" alt="PHG" title="PHG"</li>
      <li><img class="p-opt__partner-img" src="http://яшанькин.рф/images/logo.png" alt="ЯшанькинФитнес" title="ЯшанькинФитнес"</li>
      <li><img class="p-opt__partner-img" src="http://extreme-club.ru/images/logo.png" alt="Экстрим" title="Экстрим"</li>
      <li><img class="p-opt__partner-img" src="http://ratiborets.ru/images/logo.png" alt="Ратиборец" title="Ратиборец"</li>
      <li><img class="p-opt__partner-img" src="<?php echo SITE_TEMPLATE_PATH . '/images/opt/drive.jpg'; ?>" alt="Драйв" title="Драйв"</li>
      <li class="p-opt__uff"><img class="p-opt__partner-img" src="<?php echo SITE_TEMPLATE_PATH . '/images/opt/uff.jpg'; ?>" alt="Ультра"</li>
      <li><img class="p-opt__partner-img" src="<?php echo SITE_TEMPLATE_PATH . '/images/opt/cityf.png'; ?>" alt="Ситифитнес" title="Ситифитнес"</li>
      <li><img class="p-opt__partner-img" src="<?php echo SITE_TEMPLATE_PATH . '/images/opt/bright.png'; ?>" alt="Брайт" title="Брайт"</li>
      <li><img class="p-opt__partner-img" src="http://wellness-tikhvin.ru/wp-content/themes/tsl-theme/images/logo.png" alt="Тихвин" title="Тихвин"</li>
      <li class="p-opt__cultura"><img class="p-opt__partner-img" src="http://u37279.netangels.ru/wp-content/uploads/2014/08/%D0%BB%D0%BE%D0%B3%D0%BE1.png" alt="КультураФизика" title="КультураФизика"</li>
      <li><img class="p-opt__partner-img" src="<?php echo SITE_TEMPLATE_PATH . '/images/opt/antares.jpg'; ?>" alt="Antares" title="КультураФизика"</li>
    </ul>

  </div>

  <style>
    .p-opt {
      font-size: 18px;
      background: #fff;
      padding: 5px 15px;
    }
    .p-opt__main-title {
      margin: 10px 0 15px;
      font-weight: bold;
    }
    .p-opt__descr {
      font-size: 19px;
    }
    .p-opt__list {
      list-style-type: disc;
      padding-left: 20px;
    }
    .p-opt__title {
      margin: 15px 0!important;
    }
    .p-opt__title_center {
      text-align: center;
      margin: 30px 0!important;
      font-size: 27px!important;
    }
    .p-opt__head, .p-opt__title {
      font-weight: bold;
    }
    .p-opt p {
      margin: 10px 0;
    }
    .p-opt__price {
      background: #ebf0f1;
      display: inline-block;
      padding: 20px;
    }
    .p-opt__price-alt {
      margin-top: 3px!important;
      margin-left: 4px!important;
      font-size: 17px;
    }
    .p-opt__price-col {
      display: inline-block;
    }
    .p-opt__price-col:first-child {
      margin-right: 10px;
    }
    .p-opt__price-title {
      font-weight: bold;
    }
    .p-opt__input {
      padding: 4px 10px;
      margin-right: 10px;
      box-shadow: inset 0 2px 2px #d0d0d0;
      border-radius: 2px;
      font-size: 17px;
      font-family: Magistral, sans-serif;
    }
    .p-opt__submit {
      background: #922229;
      border: none;
      color: #fff;
      font-family: Magistral, sans-serif;
      font-size: 17px;
      padding: 3px 15px;
      border-radius: 3px;
      cursor: pointer;
    }
    .p-opt__submit:hover {
      background: #787878;
    }
    .p-opt__partners {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
    }
    .p-opt__partners li {
      width: 29%;
      padding: 0 10px;
      margin-bottom: 30px!important;
      text-align: center;
    }
    .p-opt__partner-img {
      max-width: 100%;
      height: 70px;
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      border-radius: 10px;
      -webkit-filter: grayscale(100%);
      -moz-filter: grayscale(100%);
      -ms-filter: grayscale(100%);
      -o-filter: grayscale(100%);
      filter: grayscale(100%);
      transition: all .1s;
    }
    .p-opt__partner-img:hover {
      -webkit-filter: initial;
      -moz-filter: initial;
      -ms-filter: initial;
      -o-filter: initial;
      filter: initial;
    }
    .p-opt__cultura {
      background: #000000;
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      border-radius: 10px;
      padding: 10px 15px!important;
    }
    .p-opt__cultura .p-opt__partner-img, .p-opt__uff .p-opt__partner-img {
      height: 35px;
    }
  </style>

  <script>

  </script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>