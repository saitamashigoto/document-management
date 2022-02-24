<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book[]|\Cake\Collection\CollectionInterface $books
 */
?>
<div class="books index content">
    <?= $this->Html->link(__('新規作成'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('書籍') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('title', 'タイトル') ?></th>
                    <th><?= $this->Paginator->sort('image', '画像') ?></th>
                    <th><?= $this->Paginator->sort('created', '作成日時') ?></th>
                    <th><?= $this->Paginator->sort('modified', '更新日時') ?></th>
                    <th class="actions"><?= __('アクション') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= h($book->title) ?></td>
                    <td><?= $this->Html->image($book->image, array('height' => 100, 'width' => 100)) ?></td>
                    <td><?= h($book->created) ?></td>
                    <td><?= h($book->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('詳細'), ['action' => 'view', $book->id]) ?>
                        <?= $this->Html->link(__('編集'), ['action' => 'edit', $book->id]) ?>
                        <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $book->id], ['confirm' => __('# {0} を削除しても宜しいでしょうか?', $book->title)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('最初')) ?>
            <?= $this->Paginator->prev('< ' . __('前へ')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('次へ') . ' >') ?>
            <?= $this->Paginator->last(__('最後') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__("{{page}}ページ目")); ?></p>
        <p><?= $this->Paginator->counter(__("合計：{{pages}}ページ")); ?></p>
        <p><?= $this->Paginator->counter(__("ページ件数：{{current}}件")); ?></p>
        <p><?= $this->Paginator->counter(__("合計件数: {{count}}件")); ?></p>
    </div>
</div>
