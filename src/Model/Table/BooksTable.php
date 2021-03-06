<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Validation\Validation;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use App\ImageServiceInterface;
use App\ImageService;

/**
 * Books Model
 *
 * @property \App\Model\Table\AuthorsTable&\Cake\ORM\Association\BelongsToMany $Authors
 *
 * @method \App\Model\Entity\Book newEmptyEntity()
 * @method \App\Model\Entity\Book newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Book[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Book get($primaryKey, $options = [])
 * @method \App\Model\Entity\Book findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Book patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Book[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Book|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Book saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BooksTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('books');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Authors', [
            'foreignKey' => 'book_id',
            'targetForeignKey' => 'author_id',
            'joinTable' => 'authors_books',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $imageService = ImageService::getInstance();
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->requirePresence('title')
            ->scalar('title')
            ->minLength('title', 1, '?????????????????????????????????????????????????????????')
            ->maxLength('title', 50, '?????????????????????????????????????????????????????????')
            ->notEmptyString('title', '????????????');

        $validator
            ->requirePresence('description')
            ->scalar('description')
            ->minLength('description', 1, '???????????????????????????????????????????????????')
            ->notEmptyString('description', '????????????');

        $validator
            ->requirePresence('authors')
            ->add('authors', 'custom', [
                'rule' => function ($value, $context) {
                    return false === empty($value['_ids']);
                },
                'message' => '????????????'
            ]);
        
        $validator
            ->add('image', 'validate_image', [
                'rule' => function ($value, $context) use ($imageService) {
                    $isNotEmpty = $imageService->validateEmptyFile($value);
                    if (true === $isNotEmpty) {
                        $isValid = $imageService->validateMimeType($value);
                        if (true === $isValid) {
                            return true;
                        }
                        $imageService->deleteFile($value);
                        return $isValid; 
                    }
                    return $isEmpty;
                },
            ]);

        return $validator;
    }
}
