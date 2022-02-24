<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;
use App\ImageServiceInterface;

/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BooksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $books = $this->paginate($this->Books);

        $this->set(compact('books'));
    }

    /**
     * View method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        try {
            $book = $this->Books->get($id, [
                'contain' => ['Authors'],
            ]);
            $this->set(compact('book'));
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__("書籍が見つかりませんでした"));
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(ImageServiceInterface $imageService)
    {
        $book = $this->Books->newEmptyEntity();
        $this->Authorization->authorize($book);
        if ($this->request->is('post')) {
            $bookData = $this->request->getData();
            $file = $bookData['image'];
            $filename = $imageService->moveFile($file);
            $bookData['image'] = $filename;
            $book = $this->Books->patchEntity($book, $bookData);
            if ($this->Books->save($book)) {
                $this->Flash->success(__('書籍作成に成功しました'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('書籍を作成できませんした'));
        }
        $authors = $this->Books->Authors->find('list', ['limit' => 200])->all();
        $this->set(compact('book', 'authors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(ImageServiceInterface $imageService, $id = null)
    {
        try {
            $book = $this->Books->get($id, [
                'contain' => ['Authors'],
            ]);
            $this->Authorization->authorize($book);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $bookData = $this->request->getData();
                $file = $bookData['change_image'];
                unset($bookData['change_image']);
                if ($file->getError() === UPLOAD_ERR_OK) {
                    $filename = $imageService->moveFile($file);
                    $isValid = $imageService->validateMimeType($filename);
                    $bookData['image'] = $filename;
                    if (true === $isValid) {
                        $imageService->deleteFile($book->image);
                    }
                }
                $book = $this->Books->patchEntity($book, $bookData);
                if ($this->Books->save($book)) {
                    $this->Flash->success(__('書籍更新に成功しました'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('書籍を更新できませんでした'));
            }
            $authors = $this->Books->Authors->find('list', ['limit' => 200])->all();
            $this->set(compact('book', 'authors'));
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__("書籍が見つかりませんでした"));
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(ImageServiceInterface $imageService, $id = null)
    {
        try {
            $this->request->allowMethod(['post', 'delete']);
            $book = $this->Books->get($id);
            $this->Authorization->authorize($book);
            $image = $book->image;
            if ($this->Books->delete($book)) {
                $imageService->deleteFile($image);
                $this->Flash->success(__('書籍の削除に成功しました'));
            } else {
                $this->Flash->error(__('書籍を削除できませんでした'));
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__("書籍が見つかりませんでした"));
        }

        return $this->redirect(['action' => 'index']);
    }
}
