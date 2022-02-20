<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 * @var \Cake\Collection\CollectionInterface|string[] $authors
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('アクション') ?></h4>
            <?= $this->Html->link(__('書籍一覧'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="books form content">
            <?= $this->Form->create($book) ?>
            <fieldset>
                <legend><?= __('新規作成') ?></legend>
                <?php
                    echo $this->Form->control('title', ['label' => 'タイトル']);
                    echo $this->Form->control('description', ['label' => '説明']);
                    echo $this->Form->control('authors._ids', ['options' => $authors, 'label' => '作者']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('保存')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
