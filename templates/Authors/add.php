<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Author $author
 * @var \Cake\Collection\CollectionInterface|string[] $books
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('アクション') ?></h4>
            <?= $this->Html->link(__('作者一覧'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="authors form content">
            <?= $this->Form->create($author, ['type' => 'file']) ?>
            <fieldset>
                <legend><?= __('新規追加') ?></legend>
                <?php
                    echo $this->Form->control('name', ['label' => '名前']);
                    echo $this->Form->control('email', ['label' => 'メールアドレス']);
                    echo $this->Form->control('description', ['label' => '自己紹介']);
                    echo $this->Form->control('books._ids', ['options' => $books, 'label' => '著書']);
                    echo $this->Form->file('image');
                    echo $this->Form->error('image');
                ?>
            </fieldset>
            <?= $this->Form->button(__('保存')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
