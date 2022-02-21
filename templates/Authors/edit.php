<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Author $author
 * @var string[]|\Cake\Collection\CollectionInterface $books
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('アクション') ?></h4>
            <?= $this->Form->postLink(
                __('削除'),
                ['action' => 'delete', $author->id],
                ['confirm' => __('# {0}削除しても宜しいでしょうか?', $author->name), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('作者一覧'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="authors form content">
            <?= $this->Form->create($author, ['type' => 'file']) ?>
            <fieldset>
                <legend><?= __('編集') ?></legend>
                <?php
                    echo $this->Form->control('name', ['label' => '名前']);
                    echo $this->Form->control('email', ['label' => 'メールアドレス']);
                    echo $this->Form->control('description', ['label' => '自己紹介']);
                    echo $this->Form->control('books._ids', ['options' => $books, 'label' => '著書']);
                    if (!empty($author->image)) {
                        echo '<div>'.$this->Html->image($author->image, array('height' => 100, 'width' => 100)) . '</div>';
                    }
                    echo $this->Form->file('change_image', ['required' => false]);
                    echo $this->Form->error('image');
                ?>
            </fieldset>
            <?= $this->Form->button(__('保存')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
