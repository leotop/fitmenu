<div><?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"slider_main",
	Array(
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "sliders",
		"IBLOCK_ID" => "6",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(),
		"PROPERTY_CODE" => array("URL"),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "#SERVER_NAME#",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N"
	)
);?> </div>
	<div class="full-width ovf"> <?$APPLICATION->IncludeComponent(
			"it:catalog.filter",
			"full",
			Array(
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_ID" => "23",
				"FILTER_NAME" => "arrFilter",
				"FIELD_CODE" => array(0=>"",1=>"",),
				"PROPERTY_CODE" => array(0=>"sports",1=>"indicator",2=>"sex",3=>"mission",),
				"OFFERS_FIELD_CODE" => array(0=>"",1=>"",),
				"OFFERS_PROPERTY_CODE" => array(0=>"",1=>"",),
				"LIST_HEIGHT" => "5",
				"TEXT_WIDTH" => "20",
				"NUMBER_WIDTH" => "5",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_GROUPS" => "Y",
				"SAVE_IN_SESSION" => "N",
				"PRICE_CODE" => array()
			)
		);?> </div>
</div> <!-- End content holder -->
</div> <!-- End fix width -->
<div class="features">
      <div class="fix-width">
          <div class="row">
              <div class="feature">
                  <a href="http://fitmenu.ru/about/delivery" class="feature__link"></a>
                  <div class="feature__image"></div>
                  <div class="feature__title">Бесплатная<br> доставка</div>
                  <div class="feature__descr">От 1000р.<br>Доставим быстро и<br> в любую точку Екатеринбурга</div>
              </div>
              <div class="feature">
                  <div class="feature__image"></div>
                  <div class="feature__title">Профессиональные<br>консультанты</div>
                  <div class="feature__descr">Наша команда-это мастера спорта по различным видам спорта, которые на своем опыте знают какое спортивное питание нужно принимать; дипломированные тренеры с многолетним стажем; квалифицированные специалисты по рациональному питанию</div>
              </div>
              <div class="feature">
                  <a href="http://fitmenu.ru/about/discount/" class="feature__link"></a>
                  <div class="feature__image"></div>
                  <div class="feature__title">Система скидок</div>
                  <div class="feature__descr">Наша система скидок очень выгодна для Вашего кошелька. Еженедельные акции с самыми популярными продуктами, скидки при первой покупке через интернет-магазин-все для Вас!</div>
              </div>
              <div class="feature">
                  <div class="feature__image"></div>
                  <div class="feature__title">1200 товаров</div>
                  <div class="feature__descr">Качественный ассортимент самых популярных товаров от производителей мировых брендов. Всегда долгий срок голности продуктов!</div>
              </div>
              <div class="feature">
                  <a href="http://fitmenu.ru/magaziny/" class="feature__link"></a>
                  <div class="feature__image"></div>
                  <div class="feature__title">4 магазина</div>
                  <div class="feature__descr">Вы всегда можете приобрести любой товар в наших магазинах, проконсультироваться с нашими продавцами или забрать товар в случае самовывоза.</div>
              </div>
          </div>
      </div>
  </div>
<div class="fix-width main-gallery"> 	 
  <div class="full-width ovf"> <?$APPLICATION->IncludeComponent(
	"bitrix:photogallery.section.list",
	"home",
	Array(
		"IBLOCK_TYPE" => "gallery",
		"IBLOCK_ID" => "8",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"BEHAVIOUR" => "SIMPLE",
		"PHOTO_LIST_MODE" => "Y",
		"SHOWN_ITEMS_COUNT" => "1",
		"ELEMENT_SORT_FIELD" => "SORT",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD1" => "",
		"ELEMENT_SORT_ORDER1" => "asc",
		"SORT_BY" => "UF_DATE",
		"SORT_ORD" => "ASC",
		"PAGE_ELEMENTS" => "0",
		"INDEX_URL" => "/photogallery/",
		"SECTION_URL" => "/photogallery/#SECTION_ID#/",
		"SECTION_EDIT_URL" => "#SECTION_ID#/action/#ACTION#/",
		"SECTION_EDIT_ICON_URL" => "section_edit_icon.php?SECTION_ID=#SECTION_ID#",
		"UPLOAD_URL" => "upload.php?SECTION_ID=#SECTION_ID#",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"ALBUM_PHOTO_SIZE" => "250",
		"ALBUM_PHOTO_THUMBS_SIZE" => "250",
		"PAGE_NAVIGATION_TEMPLATE" => "",
		"DATE_TIME_FORMAT" => "d.m.Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N"
	)
);?> 	</div>
 </div>
<div class="fix-width">
     <div class="discount-offers row">
         <div class="discount-offers__item-inner">
             <div class="discount-offers__item">
                 <div class="discount-offers__descr"><span>Дарите силу, красоту и здоровье!</span><br> Это возможно с нашими подарочными картами!</div>
                 <a class="discount-offers__btn" href="http://fitmenu.ru/catalog/podarochnye_sertifikaty">Купить карту</a>
             </div>
         </div>
         <div class="discount-offers__item-inner">
             <div class="discount-offers__item">
                 <div class="discount-offers__descr"><span>Получайте скидки и подарки!</span><br>Уже с первой покупки во всех магазинах!</div>
                 <a class="discount-offers__btn" href="http://fitmenu.ru/about/discount/">Подробности</a>
             </div>
         </div>
     </div>
 </div>
<div class="fix-width"> 
	<div class="news-main-bottom">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"side_left",
	Array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",
		"NEWS_COUNT" => "7",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(0=>"",1=>"",),
		"PROPERTY_CODE" => array(0=>"",1=>"",),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_OPTION_ADDITIONAL" => ""
	)
);?> 
</div>
  <div class="left-sidebar reviews-main-bottom">
 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"reviews",
	Array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "30",
		"NEWS_COUNT" => "5",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(0=>"DATE_CREATE",1=>"",),
		"PROPERTY_CODE" => array(0=>"",1=>"",),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Отзывы",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_OPTION_ADDITIONAL" => ""
	)
); ?> 
 </div>
  <div class="right-sidebar m"> 
    <div class="social hidden-480"> <?$APPLICATION->IncludeComponent(
	"softbalance:vkgroupwidget",
	"",
	Array(
		"LINK" => "fitmenu",
		"TYPE" => "0",
		"WIDTH" => "220",
		"HEIGHT" => "200",
		"COLOR_BACKGROUND" => "#FFFFFF",
		"COLOR_TEXT" => "#2B587A",
		"COLOR_BUTTON" => "#5B7FA6",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "0",
		"CACHE_NOTES" => ""
	)
);?> 
      <div class="fb-like-box" data-href="https://www.facebook.com/fitmenu.ru" data-width="230" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
     </div>
   </div>
    <div class="content content-main-bottom"><h1>Спортивное питание в Екатеринбурге</h1>
        <p>Сегодня спортивное питание – особая тема в работе диетологов, тренеров и самих людей, ведущих активный образ жизни. Каждый представитель названных категорий понимает, что только возможность купить спортивное питание в Екатеринбурге позволит конкретному спортсмену улучшить свои качественные и количественные показатели. Например, повысить выносливость, нарастить мышечную массу, избавиться от жировых отложений, нормализовать обмен веществ. </p>
        <p>В последнее время в действии большинства спортивных добавок замечены факторы, позволяющие говорить про общее укрепление здоровья и профилактику целого ряда системных заболеваний. Почему? Покупая спортивное питание в Екатеринбурге, человек может быть уверен в том, что потребляет натуральный продукт с хорошо изученным механизмом действия. Поэтому в России все продукты этой группы отнесены к биологически активным добавкам. Это означает то, что они изготовлены из натуральных компонентов с минимально возможным уровнем обработки, соответствуют физиологии человека, безвредны и разрешены на всех уровнях спортивных соревнований.</p>
        <h2>Нюансы, связанные со спортивным питанием</h2>
        <p>Прежде, чем купить спортивное питание в Интернет-магазине, его потенциальный потребитель должен знать следующие вещи:</p>
        <ol class="olmain">
            <li>Все протеины, витамины, аминокислоты, энергетики и прочее являются всего лишь дополнением к основному – относительно традиционному, питанию человека. Рассматривать витаминно-минеральный комплекс или протеиновый коктейль в качестве основной еды нельзя.</li>
            <li>Допинг и спортивное питание в Екатеринбурге из Интернет-магазина не имеют ничего общего.</li>
        </ol>
        <h2>Ассортимент стандартного магазина спортивного питания</h2>
        <p>Практически любая виртуальная площадка, торгующая пищевыми добавками для спортсменов, имеет стандартный ассортимент. Это связано со стабильным химическим составом человеческого организма и выверенными десятилетиями потребностями в пополнении его необходимыми веществами.</p>
        <p>Наш магазин спортивного питания в Екатеринбурге предлагает своим следующие группы продуктов:</p>
        <ul>
            <li>Высокобелковые смеси или протеины, которые являются готовым строительным материалом для клеток человека, особенно мышечных.</li>
            <li>Углеводно-белковые смеси, созданные для экстренного пополнения организма необходимыми нутриентами, набрать желаемую мышечную массу. </li>
            <li>Аминокислоты, которые имеют расширенный функционал, поэтому покупаются по потребности, назначению врача или тренера.</li>
            <li>Жиросжигатели – добавки, позволяющие избавиться от жировых отложений в максимально щадящем для человека режиме.</li>
            <li>Специальные препараты – это особая группа, которая назначается в зависимости от культивируемого спортсменом качества – силы, воли к победе, агрессии, настойчивости или выносливости.</li>
            <li>Витамины, расписывать важность применения которых нет необходимости.</li>
            <li>Энергетики и изотоники, пополняющие организм необходимым запасом углеводов и минералов непосредственно в тренировочном процессе.</li>
        </ul>
        <h3 class="h3main">Как выбрать спортивную добавку?</h3>
        <p>Планируя купить спортивное питание в Екатеринбурге, человек должен обращать внимание на следующие пункты:</p>
        <ol class="olmain">
            <li>Химический состав выбранного препарата. Вычитывается и анализируется до употребления.</li>
            <li>Производитель – выбирается тот, которому доверят ваш тренер, диетолог или его продукция проверена лично или кем-то из друзей, коллег.</li>
            <li>Цена спортивного питания – еще один тест на качество. Хороший продукт априори не может быть дешевым. Некачественный продукт не даст вам ожидаемый эффект.</li>
        </ol></div>