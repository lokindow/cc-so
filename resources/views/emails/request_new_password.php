<!DOCTYPE html>
<html>

<body>
    <?= $arrData['name'] ?>,<br />
    Houve uma solicitação de geração de nova senha para seu acesso ao sistema.<br />
    Para confirmar, <a href="<?= "http://localhost/v1/users/reset-password/?request_password_key={$arrData['request_password_key']}" ?>">clique aqui</a>.<br /><br />
    Caso não reconheça esta solicitação, basta ignorar que sua senha permanecerá a mesma.
</body>

</html>