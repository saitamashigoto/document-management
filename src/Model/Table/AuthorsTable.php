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
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\UploadedFileFactory;

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
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->requirePresence('name')
            ->scalar('name')
            ->minLength('name', 1, '文字数は１から５０以内に抑えてくさだい')
            ->maxLength('name', 50, '文字数は１から５０以内に抑えてくさだい')
            ->notEmptyString('name', '必須項目');
        
        $validator
            ->requirePresence('email')
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => '無効なメールアドレスです。'
            ]);
        
        $validator
            ->add('image', 'validate_image', [
                'rule' => function ($value, $context) {
                    $isEmpty = $this->checkEmptyFile($value);
                    if (true === $isEmpty) {
                        return $this->checkImageMimeType($value);                
                    }
                    return $isEmpty;
                },
            ]);

        $validator
            ->requirePresence('description')
            ->scalar('description')
            ->minLength('description', 1, '文字数は１以上でなければなりません')
            ->notEmptyString('description', '必須項目');

        return $validator;
    }

    protected function checkEmptyFile($value)
    {
        if (empty($value)) {
            return '必須項目';
        }
        return true;
    }

    protected function checkImageMimeType($value)
    {
        $stream = (new StreamFactory())->createStreamFromFile(WWW_ROOT . 'img/' . $value);
        $file = (new UploadedFileFactory)->createUploadedFile($stream);
        if (!Validation::mimeType($file, ['image/jpeg', 'image/png'])) {
            return 'JPEG か PNG 形式のファイルを選択してください';
        }
        return true;
    }
}
