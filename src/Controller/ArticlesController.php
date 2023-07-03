<?php

namespace App\Controller;
use Cake\Cache\Cache;

class ArticlesController extends AppController
{
    public function initialize(): void {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
    }
    public function index()
    {
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
    }
    public function add(){
        $article = $this->Articles->newEmptyEntity();
        if($this->request->is('post'))
        {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            $article->User_Id = 1;
            if($this->Articles->save($article))
            {
                $this->Flash->success('Article Saved');
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error('Unable to add Article');
        }
        $this->set('article', $article);
    }
    public function edit($slug){
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if($this->request->is(['post', 'put']))
        {
            $this->Articles->patchEntity($article, $this->request->getData());
            if($this->Articles->save($article))
            {
                $this->Flash->success("Article has been updated");
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error('Unable to Update');
            return $this->redirect(['action'=>'index']);
        }
        $this->set('article', $article);
    }
    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if($this->Articles->delete($article))
        {
            $this->Flash->success("Article has been deleted");
            return $this->redirect(['action'=>'index']);
        }
        $this->Flash->error('Unable to Delete');
        return $this->redirect(['action'=>'index']);

    }
    public function view($slug = null)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $this->set(compact('article'));
    }
}