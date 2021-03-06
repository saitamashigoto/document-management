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
 * Authors Model
 *
 * @property \App\Model\Table\BooksTable&\Cake\ORM\Association\BelongsToMany $Books
 *
 * @method \App\Model\Entity\Author newEmptyEntity()
 * @method \App\Model\Entity\Author newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Author[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Author get($primaryKey, $options = [])
 * @method \App\Model\Entity\Author findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Author patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Author[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Author|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Author saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Author[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Author[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Author[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Author[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AuthorsTable extends Table
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

        $this->setTable('authors');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Books', [
            'foreignKey' => 'author_id',
            'targetForeignKey' => 'book_id',
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
            ->requirePresence('name')
            ->scalar('name')
            ->minLength('name', 1, '?????????????????????????????????????????????????????????')
            ->maxLength('name', 50, '?????????????????????????????????????????????????????????')
            ->notEmptyString('name', '????????????');
        
        $validator
            ->requirePresence('email')
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => '???????????????????????????????????????'
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

        $validator
            ->requirePresence('description')
            ->scalar('description')
            ->minLength('description', 1, '???????????????????????????????????????????????????')
            ->notEmptyString('description', '????????????');

        return $validator;
    }
}
