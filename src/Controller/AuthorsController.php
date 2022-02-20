<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Authors Controller
 *
 * @property \App\Model\Table\AuthorsTable $Authors
 * @method \App\Model\Entity\Author[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AuthorsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $authors = $this->paginate($this->Authors);

        $this->set(compact('authors'));
    }

    /**
     * View method
     *
     * @param string|null $id Author id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        try {
            $author = $this->Authors->get($id, [
                'contain' => ['Books'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__("作者が見つかりませんでした"));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('author'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $author = $this->Authors->newEmptyEntity();
        $this->Authorization->authorize($author);
        if ($this->request->is('post')) {
            $author = $this->Authors->patchEntity($author, $this->request->getData());
            if ($this->Authors->save($author)) {
                $this->Flash->success(__('作者の保存に成功しました'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('作者を保存できませんでした'));
        }
        $books = $this->Authors->Books->find('list', ['limit' => 200])->all();
        $this->set(compact('author', 'books'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Author id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $author = $this->Authors->get($id, [
                'contain' => ['Books'],
            ]);
            $this->Authorization->authorize($author);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $author = $this->Authors->patchEntity($author, $this->request->getData());
                if ($this->Authors->save($author)) {
                    $this->Flash->success(__('作者の更新に成功しました'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('作者を更新できませんでした'));
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__("作者が見つかりませんでした"));
            return $this->redirect(['action' => 'index']);
        }
        $books = $this->Authors->Books->find('list', ['limit' => 200])->all();
        $this->set(compact('author', 'books'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Author id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $this->request->allowMethod(['post', 'delete']);
            $author = $this->Authors->get($id);
            $this->Authorization->authorize($author);
            if ($this->Authors->delete($author)) {
                $this->Flash->success(__('作者の削除に成功しました'));
            } else {
                $this->Flash->error(__('作者を削除できませんした'));
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__("作者が見つかりませんでした"));
        }

        return $this->redirect(['action' => 'index']);
    }
}
