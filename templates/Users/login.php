<div class="users form">
    <?= $this->Flash->render() ?>
    <h3>管理者ログイン</h3>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('メールアドレスとパスワードを入力してください。') ?></legend>
        <?= $this->Form->control('email', ['label' => 'メールアドレス', 'required' => true]) ?>
        <?= $this->Form->control('password', ['label' => 'パスワード', 'required' => true]) ?>
    </fieldset>
    <?= $this->Form->submit(__('ログイン')); ?>
    <?= $this->Form->end() ?>

    <?= $this->Html->link("新規登録", ['action' => 'add']) ?>
</div>