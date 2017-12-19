<?php

namespace App\Controller;

use App\Traits\ResultsetTrait;
use App\Model\Users;
use Phalcon\Paginator\Adapter\QueryBuilder;

/**
 * User Controller.
 *
 * @package App\Controller
 */
class UserController extends AbstractController
{
    use ResultsetTrait;

    /**
     * Get user entity.
     *
     * @param null $id
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function getAction($id = null)
    {
        $entity = Users::findFirst([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $id],
        ]);
        $data = $entity ? $entity->toArray() : [];
        $result = $this->getOKResultset($data);

        $this->response
            ->setStatusCode(200, 'OK')
            ->sendHeaders()
            ->setJsonContent($result);

        return $this->response;
    }

    /**
     * Get user list.
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function listAction()
    {
        $limit = 10;
        $builder = $this->modelsManager
            ->createBuilder()
            ->columns('*')
            ->from(Users::class)
            ->where(true)
            ->orderBy('createdAt DESC');

        $paginator = new QueryBuilder(
            [
                'builder' => $builder,
                'limit'   => $limit,
                'page'    => 1,
            ]
        );
        $array = [
            'total' => $paginator->getPaginate()->total_items,
            'pages' => $paginator->getPaginate()->total_pages,
            'page'  => $paginator->getCurrentPage(),
            'limit' => $paginator->getLimit(),
            'list'  => $paginator->getPaginate()->items,
        ];
        $result = $this->getOKResultset($array);
        $this->response
            ->setStatusCode(200, 'OK')
            ->sendHeaders()
            ->setJsonContent($result);

        return $this->response;
    }

    public function authenticateAction()
    {
        $username = $this->request->getUsername();
        $password = $this->request->getPassword();

        // TODO: find user information by username and password.
        $user = [
            'id'       => 1001,
            'username' => $username,
            'password' => $password,
        ];

        $this->response
            ->setStatusCode(200, 'OK')
            ->sendHeaders()
            ->setJsonContent($user);

        return $this->response;
    }
}
