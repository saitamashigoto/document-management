<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Authorization\Exception\ForbiddenException;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
    }

    public function login()
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Authors',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('無効なユーザ名またはパスワード'));
        }
    }

    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $users = $this->paginate($this->Users);
        
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__("ユーザが見つかりませんでした"));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->skipAuthorization();
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('新規作成が完了しました'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('新しいユーザを保存できませんでした'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);
            $this->Authorization->authorize($user);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('ユーザの更新に成功しました'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('ユーザを更新できませんでした'));
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__("ユーザが見つかりませんでした"));
            return $this->redirect(['action' => 'index']);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__("許可がありません"));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $this->request->allowMethod(['post', 'delete']);
            $user = $this->Users->get($id);
            $this->Authorization->authorize($user);
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('ユーザの削除に成功しました'));
            } else {
                $this->Flash->error(__('ユーザを削除できませんした'));
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__("ユーザが見つかりませんでした"));
            return $this->redirect(['action' => 'index']);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__("許可がありません"));
            return $this->redirect(['action' => 'index']);
        }

        return $this->redirect(['action' => 'index']);
    }
}
