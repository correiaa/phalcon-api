<?php

namespace App\Event;

use App\Component\Filesystem;
use Phalcon\Db\Adapter\Pdo;
use Phalcon\Db\Profiler;
use Phalcon\Events\Event;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File;

/**
 * Database Event.
 *
 * @package App\Event
 */
class DatabaseEvent
{
    const FILE_NAME = 'query.log';

    /**
     * @var \Phalcon\Db\Profiler
     */
    protected $profiler;

    /**
     * @var \Phalcon\Logger\Adapter\File
     */
    protected $logger;

    /**
     * DatabaseListener constructor.
     *
     * @throws \App\Exception\IOException
     */
    public function __construct()
    {
        $this->profiler = new Profiler();
        $this->logger = new File($this->getLogFile());
    }

    /**
     * This is executed if the event triggered is 'beforeQuery'.
     *
     * @param \Phalcon\Events\Event   $event
     * @param \Phalcon\Db\Adapter\Pdo $connection
     *
     * @return null
     */
    public function beforeQuery(Event $event, Pdo $connection)
    {
        if (__FUNCTION__ !== $event->getType()) {
            return null;
        }
        $this->profiler->startProfile($connection->getSQLStatement());
    }

    /**
     * This is executed if the event triggered is 'afterQuery'.
     *
     * @param \Phalcon\Events\Event   $event
     * @param \Phalcon\Db\Adapter\Pdo $connection
     *
     * @return null
     */
    public function afterQuery(Event $event, Pdo $connection)
    {
        if (__FUNCTION__ !== $event->getType()) {
            return null;
        }

        $Line = new Logger\Formatter\Line("[%date%] - [%type%]\r\n%message%");
        $this->logger->setFormatter($Line);
        $this->logger->log($connection->getSQLStatement(), Logger::INFO);
        $this->profiler->stopProfile();
    }

    /**
     * @return \Phalcon\Db\Profiler
     */
    public function getProfiler()
    {
        return $this->profiler;
    }

    /**
     * @return string
     * @throws \App\Exception\IOException
     */
    protected function getLogFile()
    {
        $path = LOGS_DIR . '%s/%s/%s/' . self::FILE_NAME;
        $path = sprintf($path, date('Y'), date('m'), date('d'));

        if ( ! file_exists($path)) {
            $Filesystem = new Filesystem();
            $Filesystem->mkdir(dirname($path));
        }

        return $path;
    }
}
