<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('アクション') ?></h4>
            <?= $this->Html->link(__('編集'), ['action' => 'edit', $book->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $book->id], ['confirm' => __('# {0}を削除しても宜しいでしょうか?', $book->title), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('書籍一覧'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('新規作成'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="books view content">
            <h3><?= h($book->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('タイトル') ?></th>
                    <td><?= h($book->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('連番') ?></th>
                    <td><?= $this->Number->format($book->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('作成日時') ?></th>
                    <td><?= h($book->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('講師日時') ?></th>
                    <td><?= h($book->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('画像') ?></th>
                    <td><?= $this->Html->image($book->image, array('height' => 100, 'width' => 100)) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('説明') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($book->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('作者') ?></h4>
                <?php if (!empty($book->authors)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('名前') ?></th>
                            <th><?= __('メールアドレス') ?></th>
                            <th><?= __('自己紹介') ?></th>
                            <th class="actions"><?= __('アクション') ?></th>
                        </tr>
                        <?php foreach ($book->authors as $authors) : ?>
                        <tr>
                            <td><?= h($authors->name) ?></td>
                            <td><?= h($authors->email) ?></td>
                            <td><?= h($authors->description) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('詳細'), ['controller' => 'Authors', 'action' => 'view', $authors->id]) ?>
                                <?= $this->Html->link(__('編集'), ['controller' => 'Authors', 'action' => 'edit', $authors->id]) ?>
                                <?= $this->Form->postLink(__('削除'), ['controller' => 'Authors', 'action' => 'delete', $authors->id], ['confirm' => __('# {0}を削除しても宜しいでしょうか?', $authors->name)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
