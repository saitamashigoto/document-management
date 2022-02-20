<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('アクション') ?></h4>
            <?= $this->Form->postLink(
                __('削除'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('# {0}削除しても宜しいでしょうか?', $user->email), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('ユーザ一覧'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('編集') ?></legend>
                <?php
                    echo $this->Form->control('email', ['label' => 'メールアドレス']);
                    echo $this->Form->control('password', ['label' => 'パスワード']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('保存')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
