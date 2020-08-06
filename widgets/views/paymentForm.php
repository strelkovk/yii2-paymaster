<?php
    use yii\helpers\Url;
    use yii\bootstrap\Html;
    $index = 0;
?>
<form action="https://paymaster.ru/Payment/Init" method="post" id="payment_paymaster_form">
    <input type="hidden" name="LMI_MERCHANT_ID" value="<?=$module->merchantId;?>" />
    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
    <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?=$orderModel->getCost();?>" />
    <input type="hidden" name="LMI_CURRENCY" value="<?=$module->currency;?>" />
    <input type="hidden" name="LMI_PAYMENT_NO" value="<?=$orderModel->getId();?>" />
    <input type="hidden" name="LMI_PAYMENT_DESC" value="<?=$description;?>" />
    <?php if($module->debugMode): ?>
        <input type="hidden" name="LMI_SIM_MODE" value="<?= $module->debugMode ?>" />
    <?php endif; ?>
    <?php foreach ($orderModel->getItems() as $item): ?>

            <input type="hidden" name="LMI_SHOPPINGCART.ITEMS[<?= $index ?>].NAME" value="<?= $orderModel->name) ?>"/>
            <input type="hidden" name="LMI_SHOPPINGCART.ITEMS[<?= $index ?>].QTY" value="<?= $item->amount ?>"/>
            <input type="hidden" name="LMI_SHOPPINGCART.ITEMS[<?= $index ?>].PRICE" value="<?= $item->price ?>"/>
            <input type="hidden" name="LMI_SHOPPINGCART.ITEMS[<?= $index ?>].TAX" value="no_vat"/>

    <?php $index++; endforeach; ?>
    <input type="hidden" name="LMI_PAYMENT_NOTIFICATION_URL" value="<?=Url::toRoute(['/paymaster/paymaster/result'], true);?>" />
    <input type="hidden" name="LMI_FAILURE_URL" value="<?=Url::toRoute([$module->failUrl, 'id' => $orderModel->getId(), 'cash' => true], true);?>" />
    <input type="hidden" name="LMI_SUCCESS_URL" value="<?=Url::toRoute([$module->thanksUrl, 'id' => $orderModel->getId(), 'cash' => true], true);?>" />
    <?php if(!$autoSend) { ?>
        <input type="submit" value="Оплатить <?=$orderModel->getCost();?> <?=$module->currency;?>" />
    <?php } ?>
</form>

<?php if($autoSend) { ?><script>document.getElementById('payment_paymaster_form').submit();</script><?php } ?>
