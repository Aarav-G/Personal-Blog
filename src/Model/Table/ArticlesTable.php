<?php
declare(strict_types=1);
namespace App\Model\Table;

use Cake\Event\EventInterface;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Cache\Cache;
use Cake\ORM\Query;

class ArticlesTable extends Table{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users');
    }

    public function beforeSave(EventInterface $event, $entity, $options)
    {
        if($entity->isNew() && !$entity->Slug){
            $sluggedTitle = Text::Slug($entity->Title);
            $entity->Slug = substr($sluggedTitle, 0, 191);

        }
    }
    public function findPublished(Query $query, array $options): Query
    {
        $query = $this->applyOptions($query, $options);

        return $this->_findPublished($query, $options);
    }

    protected function _findPublished(Query $query, array $options): Query
    {
        // Check if cache is available for this query
        $cacheKey = $this->getCacheKey($query, $options);
        $cachedData = Cache::read($cacheKey, 'my_cache');
        if ($cachedData !== false) {
            return $this->queryFromCache($cachedData, $query);
        }

        // Cache is not available, execute the query and cache the result
        $result = $query->where(['published' => true])
            ->contain(['Users'])
            ->order(['created' => 'DESC']);

        Cache::write($cacheKey, $this->resultToCache($result, $query), 'my_cache');

        return $result;
    }

    protected function getCacheKey(Query $query, array $options): string
    {
        return 'articles_published_' . md5(serialize($query->clause('where')));
    }
}