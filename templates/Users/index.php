<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="users index content">
    <?= $this->Html->link(__('新規登録'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('ユーザ一覧') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('email', 'メールアドレス') ?></th>
                    <th><?= $this->Paginator->sort('created', '作成日時') ?></th>
                    <th><?= $this->Paginator->sort('modified', '更新日時') ?></th>
                    <th class="actions"><?= __('アクション') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->created) ?></td>
                    <td><?= h($user->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('詳細'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('編集'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $user->id], ['confirm' => __('# {0}を削除しても宜しいでしょうか?', $user->email)]) ?>
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
