<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 * @var string[]|\Cake\Collection\CollectionInterface $authors
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('アクション') ?></h4>
            <?= $this->Form->postLink(
                __('削除'),
                ['action' => 'delete', $book->id],
                ['confirm' => __('# {0}を削除しても宜しいでしょうか?', $book->title), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('書籍一覧'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="books form content">
            <?= $this->Form->create($book, ['type' => 'file']) ?>
            <fieldset>
                <legend><?= __('編集') ?></legend>
                <?php
                    echo $this->Form->control('title', ['label' => 'タイトル']);
                    echo $this->Form->control('description', ['label' => '説明']);
                    echo $this->Form->control('authors._ids', ['options' => $authors, 'label' => '作者']);
                    if (!empty($book->image)) {
                        echo '<div>'.$this->Html->image($book->image, array('height' => 100, 'width' => 100)) . '</div>';
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
