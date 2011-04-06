<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('UserLanguage', 'doctrine');

/**
 * BaseUserLanguage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property integer $language_id
 * @property User $User
 * @property Language $Language
 * 
 * @method integer      getId()          Returns the current record's "id" value
 * @method integer      getUserId()      Returns the current record's "user_id" value
 * @method integer      getLanguageId()  Returns the current record's "language_id" value
 * @method User         getUser()        Returns the current record's "User" value
 * @method Language     getLanguage()    Returns the current record's "Language" value
 * @method UserLanguage setId()          Sets the current record's "id" value
 * @method UserLanguage setUserId()      Sets the current record's "user_id" value
 * @method UserLanguage setLanguageId()  Sets the current record's "language_id" value
 * @method UserLanguage setUser()        Sets the current record's "User" value
 * @method UserLanguage setLanguage()    Sets the current record's "Language" value
 * 
 * @package    localizit
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUserLanguage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_user_language');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('language_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'user_id'));

        $this->hasOne('Language', array(
             'local' => 'language_id',
             'foreign' => 'language_id'));
    }
}