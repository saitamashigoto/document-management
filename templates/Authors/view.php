<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Author $author
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('サクション') ?></h4>
            <?= $this->Html->link(__('編集'), ['action' => 'edit', $author->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $author->id], ['confirm' => __('# {0}削除しても宜しいでしょうか?', $author->title), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('作者一覧'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('新規作成'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="authors view content">
            <h3><?= h($author->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('名前') ?></th>
                    <td><?= h($author->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('メールアドレス') ?></th>
                    <td><?= h($author->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('連番') ?></th>
                    <td><?= $this->Number->format($author->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('作成日時') ?></th>
                    <td><?= h($author->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('更新日時') ?></th>
                    <td><?= h($author->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('自己紹介') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($author->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('著書') ?></h4>
                <?php if (!empty($author->books)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('タイトル') ?></th>
                            <th><?= __('説明') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($author->books as $books) : ?>
                        <tr>
                            <td><?= h($books->title) ?></td>
                            <td><?= h($books->description) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('詳細'), ['controller' => 'Books', 'action' => 'view', $books->id]) ?>
                                <?= $this->Html->link(__('編集'), ['controller' => 'Books', 'action' => 'edit', $books->id]) ?>
                                <?= $this->Form->postLink(__('削除'), ['controller' => 'Books', 'action' => 'delete', $books->id], ['confirm' => __('# {0}を削除しても宜しいでしょうか?', $books->title)]) ?>
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
