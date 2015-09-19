<?php
require_once dirname(__FILE__)."/ApnsMessageSender.php";

date_default_timezone_set('Asia/Tokyo');

try {
    $sender = new ApnsMessageSender(
        ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
        dirname(__FILE__)."/server_certificates_sandbox.pem",
        dirname(__FILE__)."/entrust_root_certification_authority.pem"
    );
    // �w��̑S�[���ɓ������b�Z�[�W��push
    $sender
        ->setMessage(sprintf("���{��:message date:%s", date("Y-m-d H:i:s")))
        ->setDeviceTokens(
            array(
                "device token",
            )
        )
        ->send();
} catch (Exception $e) {
    // �Ȃ�炩�̗�O����
    echo $e->getMessage();
}
