<?
global $MESS;

$MESS["hutkigrosh_webpay_success_text"] = 'Счет успешно оплачен через шлюз WebPay';
$MESS["hutkigrosh_webpay_failed_text"] = 'Ошибка оплаты счета через шлюз WebPay';
$MESS["hutkigrosh_alfaclick_label"] = 'Выставить счет в AlfaClick';
$MESS["hutkigrosh_alfaclick_success_text"] = 'Выставлен счет в системе AlfaClick';
$MESS["hutkigrosh_alfaclick_failed_text"] = 'Не удалось выставить счет в системе AlfaClick';
$MESS["hutkigrosh_default_error_text"] = 'Произошла ошибка при выставлении счета! Обратитесь к админситратору.';
$MESS["hutkigrosh_success_text"] = "<p>Счет <b>№#ORDER_ID#</b> успешно выставлен в ЕРИП.
Вы можете оплатить его наличными деньгами, пластиковой карточкой и электронными деньгами, в любом из отделений банков, кассах, банкоматах, платежных терминалах, в системе электронных денег, через Интернет-банкинг, М-банкинг, интернет-эквайринг
Для оплаты счета в ЕРИП необходимо: </p>
<div class='erip-steps'>
    <ol>
        <li>Выбрать пункт <b>Система 'Расчет' (ЕРИП)</b> </li>
        <li>Выбрать последовательно вкладки: <b>#ERIP_TREE_PATH#</b></li> 
        <li>Ввести номер заказа #ORDER_ID#</li>
        <li>Проверить корректность информации</li>
        <li>Совершить платеж</li>.
    </ol>
</div>";

?>