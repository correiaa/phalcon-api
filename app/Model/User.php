<?php

namespace App\Model;

use Phalcon\Mvc\Model;

class User extends Model
{
    use ModelTrait;

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(column="email", type="string", length=64, nullable=false)
     */
    protected $email;

    /**
     *
     * @var string
     * @Column(column="username", type="string", length=32, nullable=false)
     */
    protected $username;

    /**
     *
     * @var string
     * @Column(column="nickname", type="string", length=32, nullable=true)
     */
    protected $nickname;

    /**
     *
     * @var string
     * @Column(column="password", type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     *
     * @var string
     * @Column(column="role", type="string", length=256, nullable=true)
     */
    protected $role;

    /**
     *
     * @var string
     * @Column(column="locked_deadline", type="string", nullable=true)
     */
    protected $lockedDeadline;

    /**
     *
     * @var integer
     * @Column(column="is_verified_email", type="integer", length=4,
     *                                     nullable=true)
     */
    protected $isVerifiedEmail;

    /**
     *
     * @var integer
     * @Column(column="is_usable", type="integer", length=1, nullable=true)
     */
    protected $isUsable;

    /**
     *
     * @var integer
     * @Column(column="is_delete", type="integer", length=1, nullable=true)
     */
    protected $isDelete;

    /**
     *
     * @var string
     * @Column(column="created_ip", type="string", length=16, nullable=true)
     */
    protected $createdIp;

    /**
     *
     * @var string
     * @Column(column="created_at", type="string", nullable=true)
     */
    protected $createdAt;

    /**
     *
     * @var string
     * @Column(column="updated_at", type="string", nullable=true)
     */
    protected $updatedAt;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
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
     * Method to set the value of field username
     *
     * @param string $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

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
     * Method to set the value of field role
     *
     * @param string $role
     *
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;

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
     * @return integer
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
     * Returns the value of field username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
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
     * Returns the value of field role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
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
     * Returns the value of field isVerifiedEmail
     *
     * @return integer
     */
    public function getIsVerifiedEmail()
    {
        return $this->isVerifiedEmail;
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('user');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     *
     * @return User[]|User|\Phalcon\Mvc\Model\ResultSetInterface
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
     * @return User|\Phalcon\Mvc\Model\ResultInterface
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
            'id'                => 'id',
            'email'             => 'email',
            'username'          => 'username',
            'nickname'          => 'nickname',
            'password'          => 'password',
            'role'              => 'role',
            'locked_deadline'   => 'lockedDeadline',
            'is_verified_email' => 'isVerifiedEmail',
            'is_usable'         => 'isUsable',
            'is_delete'         => 'isDelete',
            'created_ip'        => 'createdIp',
            'created_at'        => 'createdAt',
            'updated_at'        => 'updatedAt',
        ];
    }
}
