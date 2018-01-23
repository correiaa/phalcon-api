<?php

namespace App\Model;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Users extends Model
{
    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=36, nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=false)
     */
    protected $email;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=true)
     */
    protected $nickname;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=false)
     */
    protected $password;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=false)
     */
    protected $passwordSalt;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $lockedDeadline;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $isUsable;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $isDelete;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $isVerifiedEmail;

    /**
     *
     * @var string
     * @Column(type="string", length=16, nullable=true)
     */
    protected $createdIp;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $createdAt;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $updatedAt;

    /**
     * Method to set the value of field id
     *
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field email
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Method to set the value of field nickname
     *
     * @param string $nickname
     *
     * @return $this
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Method to set the value of field passwordSalt
     *
     * @param string $passwordSalt
     *
     * @return $this
     */
    public function setPasswordSalt($passwordSalt)
    {
        $this->passwordSalt = $passwordSalt;

        return $this;
    }

    /**
     * Method to set the value of field lockedDeadline
     *
     * @param string $lockedDeadline
     *
     * @return $this
     */
    public function setLockedDeadline($lockedDeadline)
    {
        $this->lockedDeadline = $lockedDeadline;

        return $this;
    }

    /**
     * Method to set the value of field isUsable
     *
     * @param integer $isUsable
     *
     * @return $this
     */
    public function setIsUsable($isUsable)
    {
        $this->isUsable = $isUsable;

        return $this;
    }

    /**
     * Method to set the value of field isDelete
     *
     * @param integer $isDelete
     *
     * @return $this
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * Method to set the value of field isVerifiedEmail
     *
     * @param integer $isVerifiedEmail
     *
     * @return $this
     */
    public function setIsVerifiedEmail($isVerifiedEmail)
    {
        $this->isVerifiedEmail = $isVerifiedEmail;

        return $this;
    }

    /**
     * Method to set the value of field createdIp
     *
     * @param string $createdIp
     *
     * @return $this
     */
    public function setCreatedIp($createdIp)
    {
        $this->createdIp = $createdIp;

        return $this;
    }

    /**
     * Method to set the value of field createdAt
     *
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Method to set the value of field updatedAt
     *
     * @param string $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns the value of field nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the value of field passwordSalt
     *
     * @return string
     */
    public function getPasswordSalt()
    {
        return $this->passwordSalt;
    }

    /**
     * Returns the value of field lockedDeadline
     *
     * @return string
     */
    public function getLockedDeadline()
    {
        return $this->lockedDeadline;
    }

    /**
     * Returns the value of field isUsable
     *
     * @return integer
     */
    public function getIsUsable()
    {
        return $this->isUsable;
    }

    /**
     * Returns the value of field isDelete
     *
     * @return integer
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * Returns the value of field isVerifiedEmail
     *
     * @return integer
     */
    public function getIsVerifiedEmail()
    {
        return $this->isVerifiedEmail;
    }

    /**
     * Returns the value of field createdIp
     *
     * @return string
     */
    public function getCreatedIp()
    {
        return $this->createdIp;
    }

    /**
     * Returns the value of field createdAt
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Returns the value of field updatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test");
        $this->setSource("users");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     *
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     *
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the
     * application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id'              => 'id',
            'email'           => 'email',
            'nickname'        => 'nickname',
            'password'        => 'password',
            'passwordSalt'    => 'passwordSalt',
            'lockedDeadline'  => 'lockedDeadline',
            'isUsable'        => 'isUsable',
            'isDelete'        => 'isDelete',
            'isVerifiedEmail' => 'isVerifiedEmail',
            'createdIp'       => 'createdIp',
            'createdAt'       => 'createdAt',
            'updatedAt'       => 'updatedAt',
        ];
    }
}
